<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kolaborasi Proyek: {{ $project->name }} - Jara</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 40px; line-height: 1.6;">

    <p>
        <a href="{{ route('projects.show', $project) }}">&larr; Kembali ke Detail Proyek ({{ $project->name }})</a> |
        <a href="{{ route('projects.index') }}">Daftar Proyek</a>
    </p>

    <h1>Kolaborasi Proyek: {{ $project->name }}</h1>

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

    <hr style="margin: 20px 0;">

    <h2>Progress Penyelesaian</h2>
    <p style="font-size: 16px;">
        <strong>{{ $completedTasks }}</strong> dari <strong>{{ $totalTasks }}</strong>
        tugas selesai (<strong>{{ $progress }}%</strong>).
    </p>

    <hr style="margin: 20px 0;">

    <h2>Tambah Anggota</h2>
    @if($users->isEmpty())
        <p>Belum ada pengguna terdaftar dalam sistem.</p>
    @else
    <form method="POST" action="{{ route('projects.members.add', $project) }}">
        @csrf
        <div style="margin-bottom: 10px;">
            <label for="user_id">Pilih Pengguna:</label><br>
            <select name="user_id" id="user_id" style="padding: 6px; min-width: 200px;">
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" style="padding: 6px 14px; cursor: pointer;">Tambah Anggota</button>
    </form>
    @endif

    <hr style="margin: 20px 0;">

    <h2>Anggota Proyek Saat Ini</h2>
    @if($members->isEmpty())
        <p>Belum ada anggota yang ditambahkan ke proyek ini.</p>
    @else
        <ul>
            @foreach ($members as $member)
                <li>{{ $member->name }} ({{ $member->email }})</li>
            @endforeach
        </ul>
    @endif

</body>
</html>