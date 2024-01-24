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
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input id="title" type="text" placeholder="Title..."
                        class="form-control @error('title') is-invalid @enderror" name="title"
                        value="{{ old('title') ?? session('title') }}" autocomplete="title" autofocus>

                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input id="slug" type="text" placeholder="Slug..."
                        class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}"
                        autocomplete="slug" autofocus>

                    @error('slug')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                        rows="5" placeholder="Description..." autocomplete="description" autofocus>{{ old('description') ?? '' }}</textarea>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="thumbnail">Thumnail</label>
                    <div class="input-group row">
                        <div class="col-10">
                            <input id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                                type="text" name="thumbnail" style="width: 100%" placeholder="Thumbnail..."
                                value="{{ old('thumbnail') }}">
                        </div>
                        <div class="col-2">
                            <span class="input-group-btn block">
                                <a id="lfm" data-input="thumbnail" data-preview="holder"
                                    class="btn btn-primary btn-block">
                                    <i class="fa fa-picture-o"></i> Choose
                                </a>
                            </span>
                        </div>
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:150px;"></div>
                    @error('thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="summernote">Content</label>
                    <textarea id="summernote" name="content" class="form-control @error('content') is-invalid @enderror"
                        placeholder="Content...">{{ old('content') }}</textarea>
                    @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">Thêm bài viết</button>
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
