@extends('layouts.client')

@section('content')
    <div class="row">
        <div class="col-8" style="margin: 20px auto;">
            <h1>{{ $title ?? 'Danh sách' }}</h1>
            <hr>
            <div class="container mt-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="" style="font-weight: 500">{{ $post->title }}</h2>
                        <p class="card-subtitle text-muted">@datetime($post->publish_date)</p>
                        <p class="card-text">{{ $post->description }}</p>
                        <hr>
                        <div class="card-text">{!! $post->content !!}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
