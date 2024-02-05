@extends('layouts.client')

@section('content')
    <div class="row">
        <div class="col-8" style="margin: 20px auto;">
            <h1>{{ $title ?? 'Danh sách' }}</h1>
            <hr>
            <div class="container">
                <div class="row">
                    @foreach ($posts as $item)
                        <a href="{{ route('news.detail', ['post' => $item]) }}">
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="{{ $item->thumbnail }}" class="card-img-top" alt="{{ $item->title }}">
                                    <div class="card-body">
                                        <a href="{{ route('news.detail', ['post' => $item]) }}">
                                            <h5 class="card-title">{{ $item->title }}</h5>
                                        </a>
                                        <p class="card-text">{{ $item->description }}</p>
                                        <p class="card-text"><small class="text-muted">@datetime($item->publish_date)</small></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach

                    @if ($posts->count() == 0)
                        <h3 class="text-center">Chưa có bài viết nào!</h3>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@section('style')
    <style>
        .card {
            margin-bottom: 20px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            color: black !important;
            font-weight: bold;
        }

        .card-title:hover {
            text-decoration: underline;
            color: #007BFF !important;
        }

        .card-text {
            font-size: 14px;
        }

        .text-muted {
            color: #6c757d;
        }
    </style>
@endsection
