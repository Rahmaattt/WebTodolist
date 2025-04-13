<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['subject'] }}</title>
</head>
<body>
    <h1>Halo, {{ $data['name'] }}!</h1>
    <p>{{ $data['message'] }}</p>
    <hr>
    <p><strong>ID Task:</strong> {{ $data['id_task'] }}</p>
    <p><strong>Keterangan:</strong> {{ $data['keterangan_task'] }}</p>
    <p><strong>Deadline:</strong> {{ $data['deadline'] }}</p>
</body>
</html>