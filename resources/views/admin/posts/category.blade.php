@extends('admin.layouts.main')

@section('container')
    @include('admin.feature.alert')
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white border-b-2 border-indigo-600">
        <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-2 transition-colors hover:text-gray-900">
            Posts By {{ $category->name }}
        </h1>
        <div class="flex justify-between items-center mb-10">
            <div class="flex items-center space-x-4">
                <select id="bulkAction"
                    class="border-2 border-gray-300 p-2 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
                    <option value="">Pilih Aksi Masal</option>
                    <option value="delete">Hapus</option>
                    <option value="draft">Set Draft</option>
                    <option value="published">Set Published</option>
                </select>
                <button onclick="applyBulkAction()"
                    class="border-2 bg-indigo-600 p-2 text-sm font-bold rounded-lg text-white hover:bg-indigo-700 transition duration-300 ease-in-out">
                    Terapkan
                </button>
            </div>
            <a href="{{ route('posts.create') }}"
                class="border-2 bg-amber-400 p-2 text-sm font-bold rounded-lg text-white hover:bg-amber-500 hover:text-white transition duration-300 ease-in-out">
                New Data
            </a>
        </div>

        <table id="dataItem" class="stripe hover" style="width:100%; padding-top: 1em; padding-bottom: 1em;">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"></th>
                    <th data-priority="1">Title</th>
                    <th data-priority="2">Author</th>
                    <th data-priority="3">Categories</th>
                    <th data-priority="4">Comment</th>
                    <th data-priority="5">Status</th>
                    <th data-priority="6">Date</th>
                    <th data-priority="7">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $data)
                    <tr>
                        <td><input type="checkbox" name="post_ids[]" value="{{ $data->id }}"
                                class="post-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"></td>
                        <td>{{ $data->title }}</td>
                        <td><a href="{{ route('posts.byAuthor', $data->user->id) }}"
                                class="text-blue-600 hover:border-b hover:border-blue-600">{{ $data->user->name }}</a></td>
                        <td>
                            <a href="{{ route('posts.byCategory', $data->category->id) }}"
                                class="text-indigo-600 hover:border-b hover:border-indigo-600">{{ $data->category->name }}</a>
                        </td>
                        <td>{{ $data->comments_count > 0 ? $data->comments_count : 0 }}</td>
                        <td><span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $data->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $data->status }}
                            </span>
                        </td>
                        <td>{{ $data->published_at }}</td>
                        <td>
                            <div>
                                <a href="{{ route('posts.edit', $data->id) }}"
                                    class="inline-flex items-center px-1 py-2 text-md font-medium text-indigo-600 hover:underline transition-colors duration-200 ease-in-out">Edit</a>
                                <form action="{{ route('posts.destroy', $data->id) }}" method="POST"
                                    class="inline-block delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="inline-flex items-center px-1 py-2 text-md font-medium text-red-600 hover:underline transition-colors duration-200 ease-in-out"
                                        onclick="confirmDelete(this)">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#dataItem')) {
                $('#dataItem').DataTable().destroy();
            }

            $('#dataItem').DataTable({
                responsive: true,
                destroy: true,
            }).columns.adjust().responsive.recalc();

            // Handle select all checkbox
            $('#select-all').change(function() {
                $('.post-checkbox').prop('checked', $(this).prop('checked'));
            });
        });

        function applyBulkAction() {
            const selectedPosts = $('.post-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedPosts.length === 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Pilih minimal satu post',
                    icon: 'error',
                });
                return;
            }

            const action = $('#bulkAction').val();
            if (!action) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Pilih aksi yang akan dilakukan',
                    icon: 'error',
                });
                return;
            }

            let confirmMessage = '';
            switch (action) {
                case 'delete':
                    confirmMessage = 'Anda yakin ingin menghapus post yang dipilih?';
                    break;
                case 'draft':
                    confirmMessage = 'Anda yakin ingin mengubah status post menjadi draft?';
                    break;
                case 'published':
                    confirmMessage = 'Anda yakin ingin mempublish post yang dipilih?';
                    break;
            }

            Swal.fire({
                title: 'Konfirmasi',
                text: confirmMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request
                    $.ajax({
                        url: '/admin/posts/bulk-action',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            action: action,
                            post_ids: selectedPosts
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.message,
                                icon: 'success'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        }

        function confirmDelete(button) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
@endsection
