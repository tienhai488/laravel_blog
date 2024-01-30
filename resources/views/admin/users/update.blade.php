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
                    <x-form.input title="Last Name" name="last_name" type="text" placeholder="Last Name..."
                        value="{{ old('last_name') ?? $userUpdate->last_name }}" class="col-6" />
                    <x-form.input title="First Name" name="first_name" type="text" placeholder="First Name..."
                        value="{{ old('first_name') ?? $userUpdate->first_name }}" class="col-6" />
                    <x-form.input title="Email" name="email" type="text" placeholder="Email..."
                        value="{{ old('email') ?? $userUpdate->email }}" class="col-6" />

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

                <x-form.text-area title="Address" name="address" placeholder="Address..."
                    value="{{ old('address') ?? $userUpdate->address }}" />

                <button type="submit" class="btn btn-primary btn-block">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection
