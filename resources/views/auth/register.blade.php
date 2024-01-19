@extends('layouts.client')

@section('content')
    <div class="row">
        <div class="col-6" style="margin: 20px auto;">
            <h1 class="text-center">{{ $title }}</h1>
            @session('message')
                <div class="alert alert-info text-center">{{ session('message') }}</div>
            @endsession
            @if ($errors->any())
                <div class="alert alert-danger text-center">Vui lòng kiểm tra lại dữ liệu nhập vào!</div>
            @endif
            <form action="{{ route('auth.postRegister') }}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-6">
                        <label for="last_name">Last Name (*)</label>
                        <input id="last_name" type="text" placeholder="Last Name..."
                            class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                            value="{{ old('last_name') }}" autocomplete="last_name" autofocus>

                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="first_name">First Name (*)</label>
                        <input id="first_name" type="text" placeholder="First Name..."
                            class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                            value="{{ old('first_name') }}" autocomplete="first_name" autofocus>

                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email (*)</label>
                    <input id="email" type="text" placeholder="Email..."
                        class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"
                        autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password (*)</label>
                    <input id="password" type="password" placeholder="Password..."
                        class="form-control @error('password') is-invalid @enderror" name="password"
                        value="{{ old('password') }}" autocomplete="password" autofocus>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password (*)</label>
                    <input id="confirm_password" type="password" placeholder="Confirm Password..."
                        class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password"
                        value="{{ old('confirm_password') }}" autocomplete="confirm_password" autofocus>

                    @error('confirm_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input id="address" type="text" placeholder="Address..."
                        class="form-control @error('address') is-invalid @enderror" name="address"
                        value="{{ old('address') }}" autocomplete="address" autofocus>

                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">Đăng kí</button>
                <hr>
                <p class="text-center">
                    <a href="{{ route('auth.login') }}">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
@endsection
