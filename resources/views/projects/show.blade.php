<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Proyek: {{ $project->name }} - Jara</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 40px; line-height: 1.6;">

    <p>
        <a href="{{ route('projects.index') }}">&larr; Kembali ke Daftar Proyek</a> |
        <a href="{{ route('projects.collaboration', $project) }}">👥 Kolaborasi & Progress</a>
    </p>

    <h1>Proyek: {{ $project->name }}</h1>

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

    <!-- Form Tambah Tugas Baru -->
    <fieldset style="margin-bottom: 25px; padding: 15px; max-width: 500px;">
        <legend><strong>Tambah Tugas Baru</strong></legend>
        <form action="{{ route('tasks.store', $project) }}" method="POST">
            @csrf
            <div style="margin-bottom: 10px;">
                <label for="name">Nama Tugas:</label><br>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama tugas" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            <div style="margin-bottom: 10px;">
                <label for="deadline">Deadline:</label><br>
                <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}" style="width: 100%; padding: 8px; box-sizing: border-box;">
            </div>
            <button type="submit" style="padding: 8px 16px; cursor: pointer;">Tambah Tugas</button>
        </form>
    </fieldset>

    <!-- Daftar Tugas Proyek -->
    <h2>Daftar Tugas</h2>

    @if($tasks->isEmpty())
        <p>Belum ada tugas untuk proyek ini. Silakan tambahkan tugas di atas.</p>
    @else
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 800px;">
            <thead>
                <tr style="background: #f2f2f2;">
                    <th style="width: 130px;">Status</th>
                    <th>Nama Tugas</th>
                    <th style="width: 130px;">Deadline</th>
                    <th style="width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr style="{{ $task->is_done ? 'background-color: #f9f9f9;' : '' }}">
                    <td style="text-align: center;">
                        @if($task->is_done)
                            <span style="color: green; font-weight: bold;">✓ Selesai</span>
                        @else
                            <span style="color: orange; font-weight: bold;">⏳ Belum Selesai</span>
                        @endif
                    </td>
                    <td style="{{ $task->is_done ? 'text-decoration: line-through; color: #888;' : 'font-weight: 500;' }}">
                        {{ $task->name }}
                    </td>
                    <td style="text-align: center;">
                        {{ $task->deadline ? $task->deadline->format('Y-m-d') : '-' }}
                    </td>
                    <td style="text-align: center;">
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" style="padding: 4px 10px; cursor: pointer;">
                                {{ $task->is_done ? 'Batal Selesai' : 'Tandai Selesai' }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>