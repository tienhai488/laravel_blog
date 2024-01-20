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
            <form action="{{ route('auth.postForgotPassword') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">Địa chỉ Email </label>
                    <input id="email" type="text" placeholder="Nhập địa chỉ email để đặt lại mật khẩu..."
                        class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                        autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">Xác nhận</button>
                <hr>
                <p class="text-center">
                    <a href="{{ route('auth.login') }}">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
@endsection
