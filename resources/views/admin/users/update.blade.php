@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            @session('message')
                <div class="alert alert-info text-center">{{ session('message') }}</div>
            @endsession
            @if ($errors->any())
                <div class="alert alert-danger text-center">Vui lòng kiểm tra lại dữ liệu nhập vào!</div>
            @endif
            <form action="{{ route('admin.users.update', ['user' => $userUpdate]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-6">
                        <label for="last_name">Last Name </label>
                        <input id="last_name" type="text" placeholder="Last Name..."
                            class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                            value="{{ old('last_name') ?? $userUpdate->last_name }}" autocomplete="last_name" autofocus>

                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="first_name">First Name </label>
                        <input id="first_name" type="text" placeholder="First Name..."
                            class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                            value="{{ old('first_name') ?? $userUpdate->first_name }}" autocomplete="first_name" autofocus>

                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email </label>
                        <input id="email" type="text" placeholder="Email..."
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') ?? $userUpdate->email }}" autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="status">Status </label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            @foreach (array_column(\App\Enum\UserStatusEnum::cases(), 'value') as $status)
                                <option value="{{ $status }}" @selected("$status" == (old('status') ?? $userUpdate->status->value . ''))>
                                    {{ \App\Enum\UserStatusEnum::getDescription($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Address </label>
                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" cols="30"
                        rows="5">{{ old('address') ?? $userUpdate->address }}</textarea>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-block">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
