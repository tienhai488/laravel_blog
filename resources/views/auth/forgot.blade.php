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
            <form action="{{ route('auth.forgot_password') }}" method="post">
                @csrf
                <x-form.input title="Địa chỉ Emai" placeholder="Nhập địa chỉ email để đặt lại mật khẩu..." name="email"
                    value="{{ old('email') }}" type="text" />

                <button type="submit" class="btn btn-primary btn-block">Xác nhận</button>
                <hr>
                <p class="text-center">
                    <a href="{{ route('auth.login') }}">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
@endsection
