<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>نشرة بريدية</title>
</head>
<body style="direction: rtl; font-family: Arial, sans-serif;">
    <h2>نشرة بريدية جديدة من ميم </h2>

    <p>{{ $content }}</p>

    @if ($image)
        <p><img src="{{ asset('storage/' . $image) }}" style="max-width: 100%; height: auto;"></p>
    @endif

    @if ($link)
        <p><a href="{{ $link }}" style="color: blue;">اضغط هنا للمزيد</a></p>
    @endif
</body>
</html>
