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
                <div class="form-group">
                    <label for="email">Email </label>
                    <input id="email" type="text" placeholder="Email..."
                        class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ request()->email }}" autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password </label>
                    <input id="password" type="password" placeholder="Password..."
                        class="form-control @error('password') is-invalid @enderror" name="password" value=""
                        autocomplete="password" autofocus>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password </label>
                    <input id="confirm_password" type="password" placeholder="Confirm Password..."
                        class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password"
                        value="" autocomplete="confirm_password" autofocus>

                    @error('confirm_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">Đổi mật khẩu</button>
                <hr>
                <p class="text-center">
                    <a href="{{ route('auth.login') }}">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
@endsection
