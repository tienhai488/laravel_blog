@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            @session('message')
                <div class="alert alert-success text-center">{{ session('message') }}</div>
            @endsession
            @session('error')
                <div class="alert alert-success text-center">{{ session('error') }}</div>
            @endsession
            @if ($errors->any())
                <div class="alert alert-danger text-center">Vui lòng kiểm tra lại dữ liệu nhập vào!</div>
            @endif
            <form action="{{ route('admin.profile') }}" method="post">
                @csrf
                <div class="row">
                    <x-form.input title="Last Name" name="last_name" type="text" placeholder="Last Name..."
                        value="{{ old('last_name') ?? $user->last_name }}" class="col-6" />
                    <x-form.input title="First Name" name="first_name" type="text" placeholder="First Name..."
                        value="{{ old('first_name') ?? $user->first_name }}" class="col-6" />
                </div>
                <x-form.input title="Email" name="email" type="text" placeholder="Email..."
                    value="{{ old('email') ?? $user->email }}" />

                <x-form.text-area title="Address" name="address" placeholder="Address..."
                    value="{{ old('address') ?? $user->address }}" />
                <button type="submit" class="btn btn-primary btn-block">Cập nhật thông tin</button>
            </form>
        </div>
    </div>
@endsection
