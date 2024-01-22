@extends('layouts.client')

@section('content')
    <div class="row">
        <div class="col-8" style="margin: 20px auto;">
            <h1>{{ $title ?? 'Danh sách' }}</h1>
            @session('message')
                <div class="alert alert-success text-center">{{ session('message') }}</div>
            @endsession
            @session('error')
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endsession
            @if ($errors->any())
                <div class="alert alert-danger text-center">Vui lòng kiểm tra lại dữ liệu nhập vào!</div>
            @endif
            <form action="{{ route('auth.postLogin') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" placeholder="Email..."
                        class="form-control @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') ?? session('email') }}" autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" placeholder="Password..."
                        class="form-control @error('password') is-invalid @enderror" name="password"
                        value="{{ old('password') }}" autocomplete="password" autofocus>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                <hr>
                <p class="text-center">
                    <a href="{{ route('auth.forgotPassword') }}">Quên mật khẩu</a>
                </p>
            </form>
        </div>
    </div>
@endsection
