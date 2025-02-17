@extends('admin.layouts.main')

@section('container')
    @include('admin.feature.alert')
    <div id='recipients' class="p-8 mt-6 lg:mt-0 rounded shadow bg-white border-b-2 border-indigo-600">
        <div class="flex items-center space-x-4 mb-10">
            <select id="bulkAction"
                class="border-2 border-gray-300 p-2 text-sm rounded-lg focus:outline-none focus:border-indigo-500">
                <option value="">Pilih Aksi Masal</option>
                <option value="delete">Hapus</option>
                <option value="pending">Set Pending</option>
                <option value="approved">Set Approved</option>
            </select>
            <button onclick="applyBulkAction()"
                class="border-2 bg-indigo-600 p-2 text-sm font-bold rounded-lg text-white hover:bg-indigo-700 transition duration-300 ease-in-out">
                Terapkan
            </button>
        </div>
        <table id="dataItem" class="stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;">
            <thead>
                <tr>
                    <th data-priority="1"><input type="checkbox" id="select-all"
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"></th>
                    <th data-priority="2">Komentar</th>
                    <th data-priority="3">Post</th>
                    <th data-priority="4">Nama Komentator</th>
                    <th data-priority="5">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($comments as $data)
                    <tr>
                        <td><input type="checkbox" name="comment_ids[]" value="{{ $data->id }}"
                                class="comment-checkbox rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"></td>
                        <td>{{ $data->content }}</td>
                        <td>{{ $data->post->title }}</td>
                        <td>{{ $data->user->name }}</td>
                        <td>
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $data->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $data->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Hancurkan instance DataTable jika sudah ada
            if ($.fn.DataTable.isDataTable('#dataItem')) {
                $('#dataItem').DataTable().destroy();
            }

            // Inisialisasi ulang DataTable
            $('#dataItem').DataTable({
                responsive: true,
                destroy: true, // Tambahkan ini untuk memastikan destroy berjalan
            }).columns.adjust().responsive.recalc();

            // Handle select all checkbox
            $('#select-all').change(function() {
                $('.comment-checkbox').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
    <script>
        function applyBulkAction() {
            const selectedComments = $('.comment-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedComments.length === 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Pilih minimal satu comment',
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
                    confirmMessage = 'Anda yakin ingin menghapus comment yang dipilih?';
                    break;
                case 'pending':
                    confirmMessage = 'Anda yakin ingin mengubah status comment menjadi pending?';
                    break;
                case 'approved':
                    confirmMessage = 'Anda yakin ingin mengapproved comment yang dipilih?';
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
                        url: '/admin/comments/bulk-action',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            action: action,
                            comment_ids: selectedComments
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
