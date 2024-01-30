@extends('layouts.client')

@section('content')
    <div class="row">
        <div class="col-6" style="margin: 20px auto;">
            <h1 class="text-center">{{ $title }}</h1>
            @session('message')
                <div class="alert alert-success text-center">{{ session('message') }}</div>
            @endsession
            @session('error')
                <div class="alert alert-success text-danger">{{ session('error') }}</div>
            @endsession
            @error('token')
                <div class="alert alert-danger text-center">{{ $message }}</div>
            @enderror
            @if ($errors->any())
                <div class="alert alert-danger text-center">Vui lòng kiểm tra lại dữ liệu nhập vào!</div>
            @endif
            <form action="{{ route('password.update') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <x-form.input title="Email" placeholder="Email..." name="email" value="{{ request()->email }}"
                    type="text" />

                <x-form.input title="Password" placeholder="Password..." name="password" value="" type="password" />

                <x-form.input title="Confirm Password" placeholder="Confirm Password..." name="password_confirmation"
                    value="" type="password" />

                <button type="submit" class="btn btn-primary btn-block">Đổi mật khẩu</button>
                <hr>
                <p class="text-center">
                    <a href="{{ route('auth.login') }}">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
@endsection
