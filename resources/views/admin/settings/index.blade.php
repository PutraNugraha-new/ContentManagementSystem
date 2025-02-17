@extends('admin.layouts.main')

@section('container')
    @include('admin.feature.alert')
    <div class="min-h-screen bg-gray-100 p-6">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Pengaturan</h1>

            <!-- Form Pengaturan -->
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Judul Website -->
                <div class="mb-4">
                    <label for="site_title" class="block text-sm font-medium text-gray-700">Judul Website</label>
                    <input type="text" name="site_title" id="site_title" value="{{ $settings['site_title'] ?? '' }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Deskripsi Website -->
                <div class="mb-4">
                    <label for="site_description" class="block text-sm font-medium text-gray-700">Deskripsi Website</label>
                    <textarea name="site_description" id="site_description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['site_description'] ?? '' }}</textarea>
                </div>

                <!-- Email Admin -->
                <div class="mb-4">
                    <label for="admin_email" class="block text-sm font-medium text-gray-700">Email Admin</label>
                    <input type="email" name="admin_email" id="admin_email" value="{{ $settings['admin_email'] ?? '' }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <!-- Tombol Simpan -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
