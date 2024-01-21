<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? '' }} - TienHai</title>
    {{-- <link rel="stylesheet" href="{{ asset('assets/client/css/bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style.css') }}"> --}}
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/css/bootstrap4.min.css', 'resources/js/app.js', 'resources/js/bootstrap4.min.js'])
</head>

<body>
    @include('sweetalert::alert')
    @include('layouts.navbar')
    @yield('content')
</body>

{{-- <script src="{{ asset('assets/client/js/bootstrap4.min.js') }}"></script> --}}
@yield('script')

</html>
