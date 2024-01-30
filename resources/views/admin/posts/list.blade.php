@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12" style="margin: 0 auto;">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            @session('message')
                                <div class="alert alert-success text-center">{{ session('message') }}</div>
                            @endsession
                            @session('error')
                                <div class="alert alert-danger text-center">{{ session('error') }}</div>
                            @endsession
                            <form action="{{ route('admin.posts.index') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-4">
                                        <input type="text" class="form-control" value="{{ request()->title }}"
                                            name="title" placeholder="Nhập tiêu cần tìm kiếm...">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" value="{{ request()->email }}"
                                            name="email" placeholder="Nhập email cần tìm kiếm ...">
                                    </div>
                                    <div class="col-2">
                                        <select name="status" class="form-control">
                                            <option value="">Tất cả trạng thái</option>
                                            @foreach (array_column(\App\Enum\PostStatusEnum::cases(), 'value') as $status)
                                                <option value="{{ $status }}" @selected("$status" == request()->status)>
                                                    {{ \App\Enum\PostStatusEnum::getDescription($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-primary btn-block">
                                            Tìm kiếm
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="card">
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover ">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Thumbnail</th>
                                                <th>Author</th>
                                                <th>Status</th>
                                                <th>Description</th>
                                                <th>Publish Date</th>
                                                <th>Created Date</th>
                                                <th>Show</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($posts->count() > 0)
                                                @foreach ($posts as $key => $item)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('posts.show', ['post' => $item]) }}">
                                                                {{ $item->title }}
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <img style="width: 200px" src="{{ $item->thumbnail }}"
                                                                alt="{{ $item->slug }}">
                                                        </td>
                                                        <td>
                                                            {{ $item->user->name }} ({{ $item->user->email }})
                                                        </td>
                                                        <td class="text-center">
                                                            {{ getButtonPostStatus($item) }}
                                                        </td>
                                                        <td>{{ $item->description }}</td>
                                                        <td>
                                                            @if (empty($item->publish_date))
                                                                {{ 'PENDING' }}
                                                            @else
                                                                @datetime($item->publish_date)
                                                            @endif
                                                        </td>
                                                        <td> {{ $item->created_at }} </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('posts.show', ['post' => $item]) }}"
                                                                class="btn btn-primary">
                                                                <i class="far fa-file-alt"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('admin.posts.update', ['post' => $item]) }}"
                                                                class="btn btn-warning">
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Title</th>
                                                <th>Thumbnail</th>
                                                <th>Author</th>
                                                <th>Status</th>
                                                <th>Description</th>
                                                <th>Publish Date</th>
                                                <th>Created Date</th>
                                                <th>Show</th>
                                                <th>Edit</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "pageLength": 3,
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
