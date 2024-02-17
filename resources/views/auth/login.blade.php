@extends('layouts.client')

@section('content')
    <div class="row">
        <div class="col-6" style="margin: 20px auto;">
            <h1 class="text-center">{{ $title }}</h1>
            @session('message')
                <div class="alert alert-success text-center">{{ session('message') }}</div>
            @endsession
            @session('error')
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endsession
            @if ($errors->any())
                <div class="alert alert-danger text-center">Vui lòng kiểm tra lại dữ liệu nhập vào!</div>
            @endif
            <form action="{{ route('auth.login') }}" method="post">
                @csrf
                <x-form.input title="Email" name="email" type="text" placeholder="Email..."
                    value="{{ old('email') ?? session('email') }}" />
                <x-form.input title="Password" name="password" type="password" placeholder="Password..." value="" />
                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            @checked(old('remember'))>
                        <label class="form-check-label" for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                    Đăng nhập
                </button>
                <hr>
                <p class="text-center">
                    <a href="{{ route('auth.forgot_password') }}">Quên mật khẩu</a>
                </p>
            </form>
        </div>
    </div>
@endsection
