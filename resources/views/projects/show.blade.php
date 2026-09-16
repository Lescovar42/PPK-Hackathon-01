<x-layout title="Detail Proyek: {{ $project->name }} - Jara">
    <x-page-header
        title="Proyek: {{ $project->name }}"
        description="Detail proyek dan manajemen daftar tugas tim."
        backUrl="{{ route('projects.index') }}"
        backLabel="Kembali ke Daftar Proyek"
    >
        <x-slot:actions>
            <x-button href="{{ route('projects.collaboration', $project) }}" variant="secondary" size="sm">
                <svg class="h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <span>Kolaborasi & Progress</span>
            </x-button>
        </x-slot:actions>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Form Tambah Tugas Baru -->
        <div class="lg:col-span-1">
            <x-card title="Tambah Tugas Baru" subtitle="Tambahkan pekerjaan ke dalam proyek ini">
                <form action="{{ route('tasks.store', $project) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input
                            name="name"
                            label="Nama Tugas"
                            placeholder="Masukkan nama tugas"
                            :value="old('name')"
                            :required="true"
                        />
                    </div>
                    <div>
                        <x-input
                            type="date"
                            name="deadline"
                            label="Deadline (Opsional)"
                            :value="old('deadline')"
                        />
                    </div>
                    <div class="pt-2">
                        <x-button type="submit" class="w-full">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Tambah Tugas</span>
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Daftar Tugas Proyek -->
        <div class="lg:col-span-2">
            <x-card title="Daftar Tugas" subtitle="Tugas yang terdaftar untuk proyek ini">
                @if($tasks->isEmpty())
                    <div class="py-12 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="mt-4 text-sm font-medium text-slate-600">Belum ada tugas untuk proyek ini. Silakan tambahkan tugas di atas.</p>
                    </div>
                @else
                    <x-table>
                        <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                            <tr>
                                <th scope="col" class="px-4 py-3.5 text-center w-36">Status</th>
                                <th scope="col" class="px-6 py-3.5">Nama Tugas</th>
                                <th scope="col" class="px-4 py-3.5 text-center w-32">Deadline</th>
                                <th scope="col" class="px-6 py-3.5 text-center w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach($tasks as $task)
                                <tr class="transition-colors {{ $task->is_done ? 'bg-slate-50/50 hover:bg-slate-50' : 'hover:bg-slate-50/80' }}">
                                    <td class="px-4 py-4 text-center whitespace-nowrap">
                                        @if($task->is_done)
                                            <x-badge variant="success" size="sm" :dot="true">Selesai</x-badge>
                                        @else
                                            <x-badge variant="warning" size="sm" :dot="true">Belum Selesai</x-badge>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="{{ $task->is_done ? 'line-through text-slate-400' : 'font-medium text-slate-900' }}">
                                            {{ $task->name }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center text-xs text-slate-500 whitespace-nowrap">
                                        {{ $task->deadline ? $task->deadline->format('Y-m-d') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <x-button
                                                type="submit"
                                                size="xs"
                                                variant="{{ $task->is_done ? 'secondary' : 'primary' }}"
                                            >
                                                {{ $task->is_done ? 'Batal Selesai' : 'Tandai Selesai' }}
                                            </x-button>
                                        </form>
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