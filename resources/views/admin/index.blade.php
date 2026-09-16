<x-layout title="Admin - Manajemen Akun - Jara">
    <x-page-header
        title="Manajemen Akun (Admin)"
        description="Kelola akun pengguna, hak akses, dan peran sistem."
        backUrl="{{ route('home') }}"
        backLabel="Kembali ke Beranda"
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <!-- Form Tambah User -->
        <div class="lg:col-span-1">
            <x-card title="Tambah Akun Baru" subtitle="Buat akun pengguna baru dalam sistem">
                <form action="{{ route('admin.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <x-input
                            name="name"
                            label="Nama Lengkap"
                            placeholder="Contoh: Jane Doe"
                            :value="old('name')"
                            :required="true"
                        />
                    </div>
                    <div>
                        <x-input
                            type="email"
                            name="email"
                            label="Alamat Email"
                            placeholder="nama@perusahaan.com"
                            :value="old('email')"
                            :required="true"
                        />
                    </div>
                    <div>
                        <x-select name="role" label="Peran / Role">
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </x-select>
                    </div>
                    <div class="pt-2">
                        <x-button type="submit" class="w-full">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span>Simpan Akun</span>
                        </x-button>
                    </div>
                </form>
            </x-card>
        </div>

        <!-- Tabel Daftar User -->
        <div class="lg:col-span-2">
            <x-card title="Daftar Akun" subtitle="Semua pengguna yang terdaftar di platform">
                <x-table>
                    <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                        <tr>
                            <th scope="col" class="px-4 py-3.5 text-center w-16">ID</th>
                            <th scope="col" class="px-6 py-3.5">Nama</th>
                            <th scope="col" class="px-6 py-3.5">Email</th>
                            <th scope="col" class="px-4 py-3.5 text-center w-28">Role</th>
                            <th scope="col" class="px-6 py-3.5 text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="px-4 py-4 text-center text-xs font-semibold text-slate-400">
                                    #{{ $user->id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-700 font-bold text-xs">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <span class="font-medium text-slate-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-600">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-4 text-center whitespace-nowrap">
                                    <x-badge variant="{{ $user->role === 'admin' ? 'info' : 'neutral' }}" size="sm">
                                        {{ $user->role }}
                                    </x-badge>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <form action="{{ route('admin.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" variant="danger" size="xs">
                                            Hapus
                                        </x-button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            </x-card>
        </div>
    </div>
</x-layout>