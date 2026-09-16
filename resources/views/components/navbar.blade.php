<nav class="sticky top-0 z-40 w-full border-b border-slate-200/80 bg-white/90 backdrop-blur-md transition-all">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-4">
            <!-- Brand Logo -->
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-600 text-white shadow-md shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xl font-bold tracking-tight text-slate-900 group-hover:text-indigo-600 transition-colors">Jara</span>
                        <span class="text-[10px] uppercase font-semibold tracking-wider text-slate-400 -mt-1">Task Platform</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70' }}">
                        Beranda
                    </a>
                    <a href="{{ route('projects.index') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('projects.*') ? 'bg-indigo-50 text-indigo-700 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70' }}">
                        Manajemen Proyek
                    </a>
                    <a href="{{ route('admin.index') }}"
                       class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('admin.*') ? 'bg-indigo-50 text-indigo-700 shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100/70' }}">
                        Panel Admin
                    </a>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="flex items-center gap-3">
                <a href="{{ route('projects.index') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg text-xs sm:text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 active:scale-[0.98] shadow-sm shadow-indigo-600/20 transition-all">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Proyek Baru</span>
                </a>
            </div>
        </div>
    </div>
</nav>

