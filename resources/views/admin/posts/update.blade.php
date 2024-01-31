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

                <div class="form-group">
                    <label for="thumbnail">Thumnail</label>
                    <div class="input-group row">
                        <div class="col-10">
                            <input id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror"
                                type="text" name="thumbnail" style="width: 100%"
                                value="{{ old('thumbnail') ?? $thumbnail }}" placeholder="Thumbnail..." spellcheck="false">
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

        let thumbnail = document.querySelector('#thumbnail');
        let holder = document.querySelector('#holder');

        let img_thumbnail = document.createElement("img");

        if (thumbnail.value != '') {
            img_thumbnail.src = thumbnail.value;
            img_thumbnail.style.height = "5rem";
            holder.appendChild(img_thumbnail);
        }
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
