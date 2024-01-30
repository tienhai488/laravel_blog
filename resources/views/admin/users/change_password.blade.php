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
            <form action="{{ route('admin.change_password') }}" method="post">
                @csrf
                <x-form.input title="Mật khẩu của bạn" placeholder="Nhập mật khẩu của bạn..." name="password_old"
                    type="password" value="" />

                <x-form.input title="Mật khẩu mới" placeholder="Nhập mật khẩu mới..." name="password_new" type="password"
                    value="" />
                <x-form.input title="Xác nhận mật khẩu" placeholder="Xác nhận mật khẩu..." name="password_confirmation"
                    type="password" value="" />

        </div>
        <button type="submit" class="btn btn-primary btn-block">Đổi mật khẩu</button>
        </form>
    </div>
    </div>
@endsection
