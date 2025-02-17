@extends('admin.layouts.main')


@section('container')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-2xl font-semibold mb-1"></div>
                    <div class="text-sm font-medium text-gray-400">Total Barang</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-2xl font-semibold mb-1"></div>
                    <div class="text-sm font-medium text-gray-400">Total Transaksi</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-2xl font-semibold mb-1"></div>
                    <div class="text-sm font-medium text-gray-400">Total Pembelian</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-2xl font-semibold mb-1"></div>
                    <div class="text-sm font-medium text-gray-400">Total Penjualan</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-2xl font-semibold mb-1"></div>
                    <div class="text-sm font-medium text-gray-400">Supplier Aktif</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-2xl font-semibold mb-1"></div>
                    <div class="text-sm font-medium text-gray-400">Stok Habis</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-2xl font-semibold mb-1 text-green-500"></div>
                    <div class="text-sm font-medium text-gray-400">Total Pendapatan</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-2xl font-semibold mb-1 text-indigo-700"></div>
                    <div class="text-sm font-medium text-gray-400">Total Profit</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
        </div>
        <div class="bg-white rounded-md border border-gray-100 p-6 shadow-md shadow-black/5">
            <div class="flex justify-between mb-6">
                <div>
                    <div class="text-2xl font-semibold mb-1 text-rose-500"></div>
                    <div class="text-sm font-medium text-gray-400">Total Pengeluaran</div>
                </div>
            </div>
            <a href="#" class="text-blue-500 font-medium text-sm hover:text-blue-600">View details</a>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex justify-between mb-4 items-start">
                <div class="font-medium">Tren Penjualan per Bulan</div>
            </div>
            <div class="overflow-x-auto">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
        <div class="bg-white border border-gray-100 shadow-md shadow-black/5 p-6 rounded-md">
            <div class="flex justify-between mb-4 items-start">
                <div class="font-medium">Tren Stok Tiap Barang</div>
            </div>
            <div class="overflow-x-auto">
                <canvas id="stockChart"></canvas>
            </div>
        </div>
    </div>
@endsection
