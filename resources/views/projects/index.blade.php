<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Proyek - Jara</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 40px; line-height: 1.6;">

    <p><a href="{{ route('home') }}">&larr; Kembali ke Beranda</a></p>

    <h1>Manajemen Proyek</h1>

    @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
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

    <!-- Form Buat Proyek Baru -->
    <fieldset style="margin-bottom: 25px; padding: 15px; max-width: 500px;">
        <legend><strong>Buat Proyek Baru</strong></legend>
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 10px;">
                <label for="name">Nama Proyek:</label><br>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama proyek" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            <button type="submit" style="padding: 8px 16px; cursor: pointer;">Buat Proyek</button>
        </form>
    </fieldset>

    <!-- Daftar Proyek -->
    <h2>Daftar Proyek</h2>

    @if($projects->isEmpty())
        <p>Belum ada proyek. Silakan buat proyek baru di atas.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 700px;">
            <thead>
                <tr style="background: #f2f2f2;">
                    <th style="width: 60px;">ID</th>
                    <th>Nama Proyek</th>
                    <th style="width: 120px;">Jumlah Tugas</th>
                    <th style="width: 220px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                <tr>
                    <td style="text-align: center;">{{ $project->id }}</td>
                    <td>
                        <a href="{{ route('projects.show', $project) }}" style="font-weight: bold; text-decoration: none; color: #0066cc;">
                            {{ $project->name }}
                        </a>
                    </td>
                    <td style="text-align: center;">
                        {{ $project->tasks_count }}
                    </td>
                    <td>
                        <a href="{{ route('projects.show', $project) }}">Detail & Tugas</a> |
                        <a href="{{ route('projects.collaboration', $project) }}">Kolaborasi</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
