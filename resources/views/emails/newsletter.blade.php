<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
<body>
    <h1>{{ $title }}</h1>
    @if(isset($image))
        <img src="{{ $message->embed($image->getRealPath()) }}" alt="Newsletter Image">
    @endif
    <p>{{ $content }}</p>
</body>
</html>
