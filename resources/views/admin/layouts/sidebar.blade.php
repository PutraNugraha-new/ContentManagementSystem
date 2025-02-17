<div
    class="fixed left-0 top-0 w-64 h-full border-r overflow-y-auto border-grey-300 bg-slate-950 md:bg-white p-4 z-40 sidebar-menu transition-transform">
    <a href="/" class="flex items-center pb-4 justify-center">
        {{-- <img src="https://placehold.co/32x32" alt="" class="w-8 h-8 rounded object-cover"> --}}
        {{-- <img src="{{ asset('image/putra.png') }}" alt="" class="w-8 h-8 rounded object-cover"> --}}
        <span class="text-lg font-bold text-white md:text-indigo-950 ml-3 text-center">CMS</span>
    </a>
    <ul class="mt-4">
        <span class="text-sm text-slate-400 tracking-wider">
            MAIN MENU
        </span>
        <li class="mb-1 group {{ Request::is('/') ? 'active' : '' }}">
            <a href="/"
                class="flex items-center py-2 px-4 text-slate-400 md:text-indigo-950 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="ri-home-2-line mr-3 text-lg"></i>
                <span class="text-sm">Dashboard</span>
            </a>
        </li>
        {{-- <span class="text-sm text-slate-400 tracking-wider">
            DATA MASTER
        </span> --}}
        <li x-data="{ open: false }"
            class="mb-1 group {{ Request::is('posts*') || Request::is('posts*') ? 'active' : '' }}">
            <div class="flex flex-col">
                <!-- Menu Utama -->
                <button @click="open = !open"
                    class="flex items-center justify-between w-full py-2 px-4 text-slate-400 md:text-indigo-950 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white focus:outline-none">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                            </path>
                        </svg>
                        <span class="text-sm">Management Posts</span>
                    </div>
                    <i :class="open ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line'"
                        class="text-gray-400 hover:text-gray-600"></i>
                </button>

                <!-- Submenu -->
                <ul x-show="open" x-transition.origin.top.duration.300ms
                    class="mt-1 pl-1 py-1 rounded-md bg-gray-100 border border-gray-200 divide-y divide-gray-200">
                    <li>
                        <a href="{{ route('posts.index') }}"
                            class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 rounded-md hover:text-blue-500 hover:bg-gray-50">
                            All Posts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts.create') }}"
                            class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 rounded-md hover:text-blue-500 hover:bg-gray-50">
                            Add New
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="mb-1 group {{ Request::is('categories*') ? 'active' : '' }}">
            <a href="{{ route('categories.index') }}"
                class="flex items-center py-2 px-4 text-slate-400 md:text-indigo-950 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2-2h4l2 2h4a2 2 0 012 2v10a2 2 0 01-2 2H5z"></path>
                </svg>
                <span class="text-sm">Management Categories</span>
            </a>
        </li>
        <li class="mb-1 group {{ Request::is('tags*') ? 'active' : '' }}">
            <a href="{{ route('tags.index') }}"
                class="flex items-center py-2 px-4 text-slate-400 md:text-indigo-950 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z">
                    </path>
                </svg>
                <span class="text-sm">Management Tags</span>
            </a>
        </li>
        <li class="mb-1 group {{ Request::is('comments*') ? 'active' : '' }}">
            <a href="{{ route('comments.index') }}"
                class="flex items-center py-2 px-4 text-slate-400 md:text-indigo-950 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                    </path>
                </svg>
                <span class="text-sm">Management Comments</span>
                @if ($pendingCommentsCount > 0)
                    <span id="pending-comments-count"
                        class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-medium text-white bg-red-500 rounded-full">
                        {{ $pendingCommentsCount }}
                    </span>
                @endif
            </a>
        </li>
        <span class="text-sm text-slate-400 tracking-wider">
            Other
        </span>
        <li x-data="{ open: false }"
            class="mb-1 group {{ Request::is('users*') || Request::is('users*') ? 'active' : '' }}">
            <div class="flex flex-col">
                <!-- Menu Utama -->
                <button @click="open = !open"
                    class="flex items-center justify-between w-full py-2 px-4 text-slate-400 md:text-indigo-950 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white focus:outline-none">
                    <div class="flex items-center">
                        <i class="ri-user-settings-line mr-3 text-lg"></i>
                        <span class="text-sm">Management Users</span>
                    </div>
                    <i :class="open ? 'ri-arrow-up-s-line' : 'ri-arrow-down-s-line'"
                        class="text-gray-400 hover:text-gray-600"></i>
                </button>

                <!-- Submenu -->
                <ul x-show="open" x-transition.origin.top.duration.300ms
                    class="mt-1 pl-1 py-1 rounded-md bg-gray-100 border border-gray-200 divide-y divide-gray-200">
                    <li>
                        <a href="{{ route('users.index') }}"
                            class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 rounded-md hover:text-blue-500 hover:bg-gray-50">
                            All Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.create') }}"
                            class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 rounded-md hover:text-blue-500 hover:bg-gray-50">
                            Add New
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="mb-1 group {{ Request::is('settings') ? 'active' : '' }}">
            <a href="{{ route('settings.index') }}"
                class="flex items-center py-2 px-4 text-slate-400 md:text-indigo-950 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100">
                <i class="ri-settings-2-line mr-3 text-lg"></i>
                <span class="text-sm">Application Settings</span>
            </a>
        </li>
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>
