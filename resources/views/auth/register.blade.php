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
            <form action="{{ route('auth.register') }}" method="post">
                @csrf
                <div class="row">
                    <x-form.input title="Last Name" name="last_name" type="text" placeholder="Last Name..."
                        value="{{ old('last_name') }}" class="col-6" />
                    <x-form.input title="First Name" name="first_name" type="text" placeholder="First Name..."
                        value="{{ old('first_name') }}" class="col-6" />
                </div>
                <x-form.input title="Email" name="email" type="text" placeholder="Email..."
                    value="{{ old('email') }}" />

                <x-form.input title="Password" placeholder="Password..." name="password" type="password"
                    value="{{ old('password') }}" />

                <x-form.input title="Confirm Password" placeholder="Confirm Password..." name="password_confirmation"
                    value="" type="password" />

                <button type="submit" class="btn btn-primary btn-block">Đăng kí</button>
                <hr>
                <p class="text-center">
                    <a href="{{ route('auth.login') }}">Đăng nhập</a>
                </p>
            </form>
        </div>
    </div>
@endsection
