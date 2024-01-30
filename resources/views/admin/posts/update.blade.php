@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12" style="margin: 0 auto;">
            @session('message')
                <div class="alert alert-success text-center">{{ session('message') }}</div>
            @endsession
            @session('error')
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endsession
            @if ($errors->any())
                <div class="alert alert-danger text-center">Vui lòng kiểm tra lại dữ liệu nhập vào!</div>
            @endif
            <form action="{{ route('admin.posts.update', ['post' => $post]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-form.input title="Title" placeholder="Title..." name="title" value="{{ old('title') ?? $post->title }}"
                    type="text" />

                <x-form.input title="Slug" placeholder="Slug..." name="slug" value="{{ old('slug') ?? $post->slug }}"
                    type="text" />



                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        @foreach (array_column(\App\Enum\PostStatusEnum::cases(), 'value') as $status)
                            <option value="{{ $status }}" @selected("$status" == (old('status') ?? $post->status->value . ''))>
                                {{ \App\Enum\PostStatusEnum::getDescription($status) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <x-form.text-area title="Description" name="description" placeholder="Description..."
                    value="{{ old('description') ?? $post->description }}" />

                <x-form.input title="Thumnail" placeholder="" name="thumbnail" value="" type="file" />

                <div class="form-group">
                    <label for="summernote">Content</label>
                    <textarea id="summernote" name="content" class="form-control @error('content') is-invalid @enderror"
                        placeholder="Content...">{{ old('content') ?? $post->content }}</textarea>
                    @error('content')
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

@section('script')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Content...',
                height: 200
            });
        });
        $('#lfm').filemanager('image');
    </script>
@endsection

@section('style')
    <style>
        #holder img {
            height: 10rem !important;
        }

        .invalid-feedback {
            display: block !important;
        }
    </style>
@endsection
