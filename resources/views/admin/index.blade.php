<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manajemen Akun</title>
</head>
<body>
    <p><a href="{{ route('home') }}">&larr; Kembali ke Beranda</a> | <a href="{{ route('projects.index') }}">Daftar Proyek</a></p>

    <h1>Manajemen Akun (Admin)</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Tambah User -->
    <h3>Tambah Akun Baru</h3>
    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        <div>
            <label>Nama:</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label>Email:</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label>Role:</label><br>
            <select name="role">
                <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div><br>
        <button type="submit">Simpan</button>
    </form>

    <hr>

    <!-- Tabel Daftar User -->
    <h3>Daftar Akun</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <form action="{{ route('admin.destroy', $user) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>