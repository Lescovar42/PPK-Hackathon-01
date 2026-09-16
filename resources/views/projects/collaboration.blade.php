<x-layout title="Kolaborasi Proyek: {{ $project->name }} - Jara">
    <x-page-header
        title="Kolaborasi Proyek: {{ $project->name }}"
        description="Kelola anggota tim proyek dan pantau persentase kemajuan penyelesaian tugas."
        backUrl="{{ route('projects.show', $project) }}"
        backLabel="Kembali ke Detail Proyek ({{ $project->name }})"
    >
        <x-slot:actions>
            <x-button href="{{ route('projects.index') }}" variant="secondary" size="sm">
                <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <span>Daftar Proyek</span>
            </x-button>
        </x-slot:actions>
    </x-page-header>

    <div class="space-y-8">
        <!-- Progress Penyelesaian Section -->
        <x-card title="Progress Penyelesaian" subtitle="Status pencapaian target tugas proyek">
            <div class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <p class="text-sm sm:text-base text-slate-700">
                        <strong>{{ $completedTasks }}</strong> dari <strong>{{ $totalTasks }}</strong> tugas selesai (<strong>{{ $progress }}%</strong>).
                    </p>
                    <x-badge variant="{{ $progress === 100 ? 'success' : ($progress > 0 ? 'info' : 'neutral') }}" size="md" :dot="true">
                        {{ $progress === 100 ? 'Selesai Sempurna' : ($progress > 0 ? 'Sedang Berjalan' : 'Belum Dimulai') }}
                    </x-badge>
                </div>

                <!-- Visual Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden border border-slate-200/60 shadow-inner">
                    <div
                        class="h-full bg-gradient-to-r from-indigo-500 to-emerald-500 rounded-full transition-all duration-700 ease-out"
                        style="width: {{ $progress }}%;"
                    ></div>
                </div>
            </div>
        </x-card>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            <!-- Tambah Anggota Form -->
            <x-card title="Tambah Anggota" subtitle="Tugaskan pengguna terdaftar ke proyek ini">
                @if($users->isEmpty())
                    <div class="py-8 text-center text-sm text-slate-500">
                        <p>Belum ada pengguna terdaftar dalam sistem.</p>
                    </div>
                @else
                    <form method="POST" action="{{ route('projects.members.add', $project) }}" class="space-y-4">
                        @csrf
                        <div>
                            <x-select name="user_id" id="user_id" label="Pilih Pengguna" :required="true">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="pt-2">
                            <x-button type="submit" class="w-full sm:w-auto">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                <span>Tambah Anggota</span>
                            </x-button>
                        </div>
                    </form>
                @endif
            </x-card>

            <!-- Anggota Proyek Saat Ini -->
            <x-card title="Anggota Proyek Saat Ini" subtitle="Daftar tim yang berkolaborasi pada proyek ini">
                @if($members->isEmpty())
                    <div class="py-8 text-center text-sm text-slate-500">
                        <p>Belum ada anggota yang ditambahkan ke proyek ini.</p>
                    </div>
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach ($members as $member)
                            <li class="py-3.5 flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gradient-to-tr from-indigo-500 to-violet-500 text-white font-bold text-sm shadow-xs">
                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-slate-900 truncate">
                                        {{ $member->name }}
                                    </p>
                                    <p class="text-xs text-slate-500 truncate">
                                        {{ $member->name }} ({{ $member->email }})
                                    </p>
                                </div>
                                <x-badge variant="neutral" size="sm">Anggota</x-badge>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </x-card>
        </div>
    </div>
</x-layout>