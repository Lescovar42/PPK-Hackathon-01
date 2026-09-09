<!DOCTYPE html>
<html>
<head>
    <title>Kolaborasi Proyek</title>
</head>
<body>

    <h1>Proyek: {{ $project->name }}</h1>

    <hr>

    <h2>Tambah Anggota</h2>

    <form method="POST" action="{{ route('projects.members.add', $project) }}">
        @csrf

        <select name="user_id">
            @foreach ($users as $user)
                <option value="{{ $user->id }}">
                    {{ $user->name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Tambah</button>
    </form>

    <hr>

    <h2>Anggota Proyek</h2>

    <ul>
        @foreach ($members as $member)
            <li>{{ $member->name }}</li>
        @endforeach
    </ul>

    <hr>

    <h2>Progress</h2>

    <p>
        {{ $completedTasks }} dari {{ $totalTasks }}
        tugas selesai ({{ $progress }}%).
    </p>

</body>
</html>