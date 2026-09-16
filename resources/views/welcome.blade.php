<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jara - Collaborative Task Management Platform</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 40px; line-height: 1.6;">
    <h1>Selamat Datang di Jara</h1>
    <p>Platform manajemen proyek dan tugas kolaboratif.</p>

    <hr style="margin: 20px 0;">

    <h2>Menu Utama</h2>
    <ul>
        <li>
            <a href="{{ route('projects.index') }}" style="font-size: 18px; font-weight: bold;">
                📁 Manajemen Proyek & Tugas
            </a>
            <p>Kelola proyek, tambahkan tugas, atur deadline, dan pantau penyelesaian tugas.</p>
        </li>
        <li>
            <a href="{{ route('admin.index') }}" style="font-size: 18px; font-weight: bold;">
                ⚙️ Panel Admin (Manajemen Akun)
            </a>
            <p>Kelola akun pengguna, peran sistem (admin/user), dan akses pengguna.</p>
        </li>
    </ul>
</body>
</html>