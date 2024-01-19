<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? '' }} - TienHai</title>
    <link rel="stylesheet" href="{{ asset('assets/client/css/bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style.css') }}">
</head>

<body>
    @include('sweetalert::alert')
    @yield('content')
</body>

<script src="{{ asset('assets/client/js/bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('script')

</html>
