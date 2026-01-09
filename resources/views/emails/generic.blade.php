<html>
<body>
    <h2>{{ $data['subject'] ?? 'Notification' }}</h2>
    <p>{!! nl2br(e($data['body'] ?? '')) !!}</p>
</body>
</html>
