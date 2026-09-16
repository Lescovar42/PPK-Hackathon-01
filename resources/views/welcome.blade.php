<x-layout title="Jara - Collaborative Task Management Platform" :full-width="true">
    <div class="relative isolate w-full overflow-hidden">
        <!-- Full-Bleed Background Pattern (No Cutoff, 100% Screen Width) -->
        <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <!-- Horizon Accent Beam -->
            <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-indigo-500/30 to-transparent"></div>

            <!-- Tech Blueprint Grid Pattern with Vertex Dots -->
            <svg class="absolute inset-0 h-full w-full stroke-slate-200/60 [mask-image:radial-gradient(ellipse_85%_70%_at_50%_15%,#000_50%,transparent_100%)]" aria-hidden="true">
                <defs>
                    <pattern id="jara-grid-pattern" width="48" height="48" patternUnits="userSpaceOnUse" x="50%" y="-1">
                        <path d="M.5 48V.5H48" fill="none" stroke-width="1" />
                        <circle cx="0.5" cy="0.5" r="1.5" class="fill-slate-300" stroke-width="0" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#jara-grid-pattern)" />
            </svg>

            <!-- Multi-Layer Atmospheric Ambient Glow -->
            <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[1000px] h-[550px] bg-gradient-to-b from-indigo-200/40 via-violet-200/25 to-transparent blur-[110px] rounded-full"></div>
            <div class="absolute top-1/3 -left-32 w-[500px] h-[500px] bg-sky-200/25 blur-[120px] rounded-full"></div>
            <div class="absolute top-1/3 -right-32 w-[500px] h-[500px] bg-indigo-200/25 blur-[120px] rounded-full"></div>
        </div>

        <!-- Main Content (Centered in standard max-w-7xl container) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20">
            <!-- Hero Section -->
            <div class="flex flex-col items-center text-center">
                <!-- Tagline Badge with Pulsing Live Indicator -->
                <div class="mb-6 inline-flex items-center gap-2.5 px-3.5 py-1.5 rounded-full border border-indigo-200/80 bg-white/80 backdrop-blur-md text-xs font-semibold text-indigo-700 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <span>Platform Kolaborasi & Manajemen Tugas Modern</span>
                </div>

                <!-- Headline -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 max-w-3xl leading-[1.15]">
                    Selamat Datang di <span class="bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-800 bg-clip-text text-transparent">Jara</span>
                </h1>

                <!-- Subtitle -->
                <p class="mt-5 text-base sm:text-lg lg:text-xl text-slate-600 max-w-2xl leading-relaxed">
                    Platform manajemen proyek dan tugas kolaboratif. Rencanakan pekerjaan, delegasikan tugas, pantau tenggat waktu, dan capai target tim dengan mudah.
                </p>

                <!-- CTA Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4 w-full max-w-md">
                    <x-button href="{{ route('projects.index') }}" size="lg" class="w-full sm:w-auto shadow-lg shadow-indigo-600/25 hover:shadow-indigo-600/35 transition-all">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                        <span>Manajemen Proyek & Tugas</span>
                    </x-button>

                    <x-button href="{{ route('admin.index') }}" variant="secondary" size="lg" class="w-full sm:w-auto shadow-sm bg-white/90 backdrop-blur-xs hover:bg-white transition-all">
                        <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Panel Admin</span>
                    </x-button>
                </div>

                <!-- Subtle Value Props Row -->
                <div class="mt-8 flex flex-wrap items-center justify-center gap-6 text-xs font-medium text-slate-500">
                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Tracking Deadline Akurat</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Kolaborasi Tim Cepat</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>Kendali Hak Akses Aman</span>
                    </div>
                </div>
            </div>

            <!-- Features Section / Menu Utama -->
            <div class="mt-16 md:mt-24">
                <div class="text-center mb-10">
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Menu Utama & Fitur Unggulan</h2>
                    <p class="mt-2 text-sm text-slate-600">Jelajahi fungsionalitas inti platform Jara untuk mempercepat alur kerja Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Feature 1: Manajemen Proyek & Tugas -->
                    <x-card class="bg-white/85 backdrop-blur-sm border-slate-200/90 hover:border-indigo-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between group">
                        <div class="flex flex-col gap-4">
                            <div class="h-12 w-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:scale-105 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-200 shadow-xs">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">
                                    <a href="{{ route('projects.index') }}" class="hover:text-indigo-600 transition-colors">
                                        Manajemen Proyek & Tugas
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                    Kelola proyek, tambahkan tugas, atur deadline, dan pantau penyelesaian tugas dengan visual status yang jelas.
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <x-button href="{{ route('projects.index') }}" variant="ghost" size="sm" class="w-full justify-between group-hover:text-indigo-600">
                                <span>Buka Manajemen Proyek</span>
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </x-button>
                        </div>
                    </x-card>

                    <!-- Feature 2: Kolaborasi & Progress -->
                    <x-card class="bg-white/85 backdrop-blur-sm border-slate-200/90 hover:border-indigo-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between group">
                        <div class="flex flex-col gap-4">
                            <div class="h-12 w-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center group-hover:scale-105 group-hover:bg-violet-600 group-hover:text-white transition-all duration-200 shadow-xs">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">
                                    <a href="{{ route('projects.index') }}" class="hover:text-indigo-600 transition-colors">
                                        Kolaborasi Tim
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                    Ajak anggota tim bergabung dalam proyek, pantau persentase kemajuan penyelesaian tugas, dan koordinasi secara terarah.
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <x-button href="{{ route('projects.index') }}" variant="ghost" size="sm" class="w-full justify-between group-hover:text-indigo-600">
                                <span>Pilih Proyek & Kolaborasi</span>
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </x-button>
                        </div>
                    </x-card>

                    <!-- Feature 3: Panel Admin -->
                    <x-card class="bg-white/85 backdrop-blur-sm border-slate-200/90 hover:border-indigo-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-200 flex flex-col justify-between md:col-span-2 lg:col-span-1 group">
                        <div class="flex flex-col gap-4">
                            <div class="h-12 w-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center group-hover:scale-105 group-hover:bg-sky-600 group-hover:text-white transition-all duration-200 shadow-xs">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-slate-900">
                                    <a href="{{ route('admin.index') }}" class="hover:text-indigo-600 transition-colors">
                                        Panel Admin
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                    Kelola akun pengguna, peran sistem (admin/user), dan akses pengguna dengan kendali terpusat.
                                </p>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-slate-100">
                            <x-button href="{{ route('admin.index') }}" variant="ghost" size="sm" class="w-full justify-between group-hover:text-indigo-600">
                                <span>Buka Panel Admin</span>
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </x-button>
                        </div>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
</x-layout>