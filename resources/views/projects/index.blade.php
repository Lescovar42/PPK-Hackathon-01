<x-layout title="Daftar Proyek - Jara">
    <x-page-header
        title="Manajemen Proyek"
        description="Pantau seluruh proyek aktif, kelola daftar tugas, dan atur kolaborasi tim."
        backUrl="{{ route('home') }}"
        backLabel="Kembali ke Beranda"
    />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Form Buat Proyek Baru -->
        <div class="lg:col-span-1">
            <x-card title="Buat Proyek Baru" subtitle="Tambahkan ruang kerja baru untuk tim Anda">
                <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input
                            name="name"
                            label="Nama Proyek"
                            placeholder="Contoh: Redesign Website"
                            :value="old('name')"
                            :required="true"
                            hint="Gunakan nama yang jelas dan spesifik."
                        />
                    </div>
                    <div class="pt-2">
                        <x-button type="submit" class="w-full">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Buat Proyek</span>
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Tabel Daftar Proyek -->
        <div class="lg:col-span-2">
            <x-card title="Daftar Proyek" subtitle="Daftar semua proyek yang sedang berjalan">
                @if($projects->isEmpty())
                    <div class="py-12 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <p class="mt-4 text-sm font-medium text-slate-600">Belum ada proyek. Silakan buat proyek baru di atas.</p>
                    </div>
                @else
                    <x-table>
                        <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-center w-16">ID</th>
                                <th scope="col" class="px-6 py-3.5">Nama Proyek</th>
                                <th scope="col" class="px-4 py-3.5 text-center w-32">Jumlah Tugas</th>
                                <th scope="col" class="px-6 py-3.5 text-right w-56">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($projects as $project)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-4 py-4 text-center text-xs font-semibold text-slate-400">
                                        #{{ $project->id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('projects.show', $project) }}" class="font-semibold text-slate-900 hover:text-indigo-600 transition-colors">
                                            {{ $project->name }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <x-badge variant="neutral" size="sm">
                                            {{ $project->tasks_count }} Tugas
                                        </x-badge>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2 text-xs">
                                            <a href="{{ route('projects.show', $project) }}" class="font-medium text-indigo-600 hover:text-indigo-800 hover:underline">
                                                Detail & Tugas
                                            </a>
                                            <span class="text-slate-300">|</span>
                                            <a href="{{ route('projects.collaboration', $project) }}" class="font-medium text-violet-600 hover:text-violet-800 hover:underline">
                                                Kolaborasi
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </x-table>
                @endif
            </x-card>
        </div>
    </div>
</x-layout>
