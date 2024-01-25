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
            <form action="{{ route('admin.changePassword') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="password_old">Mật khẩu của bạn </label>
                    <input id="password_old" type="password" placeholder="Nhập mật khẩu của bạn..."
                        class="form-control @error('password_old') is-invalid @enderror" name="password_old" value=""
                        autocomplete="password_old" autofocus>

                    @error('password_old')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_new">Mật khẩu mới </label>
                    <input id="password_new" type="password" placeholder="Nhập mật khẩu mới ..."
                        class="form-control @error('password_new') is-invalid @enderror" name="password_new" value=""
                        autocomplete="password_new" autofocus>

                    @error('password_new')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu </label>
                    <input id="confirm_password" type="password" placeholder="Xác nhận mật khẩu..."
                        class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password"
                        value="" autocomplete="confirm_password" autofocus>

                    @error('confirm_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">Đổi mật khẩu</button>
            </form>
        </div>
    </div>
@endsection
