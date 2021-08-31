<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Larapid</title>
    <link href="{{ mix('/css/app.css', 'vendor/larapid') }}" rel="stylesheet" />
</head>
<body>
    @inertia

    <script src="{{ mix('/js/app.js', 'vendor/larapid') }}"></script>
</body>
</html>
