<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Akun - Admin Jara</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 40px;">

    <h2>Panel Admin: Manajemen Akun Pengguna</h2>

    @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
    @endif

    <!-- Form Tambah Akun -->
    <fieldset style="margin-bottom: 20px; padding: 15px;">
        <legend><strong>Tambah Akun Baru</strong></legend>
        <form action="{{ route('admin.store') }}" method="POST">
            @csrf
            <p>
                <label>Nama:</label><br>
                <input type="text" name="name" required>
            </p>
            <p>
                <label>Email:</label><br>
                <input type="email" name="email" required>
            </p>
            <p>
                <label>Role:</label><br>
                <select name="role">
                    <option value="user">User (Biasa)</option>
                    <option value="admin">Admin</option>
                </select>
            </p>
            <button type="submit">Simpan Akun</button>
        </form>
    </fieldset>

    <!-- Tabel Daftar Akun -->
    <h3>Daftar Pengguna Sistem</h3>
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background: #f2f2f2;">
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $u->id }}</td>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->role }}</td>
                <td>
                    <form action="{{ route('admin.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus akun ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red;">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>