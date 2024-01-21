@extends('layouts.client')

@section('content')
    <div class="row">
        <div class="col-8" style="margin: 20px auto;">
            <h1>{{ $title ?? 'Danh sách' }}</h1>
            <hr>
            <a href="" class="btn btn-primary"><i class="fas fa-plus pr-1"></i>Thêm bài viết</a>
            <hr>
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
                            <div class="card">
                                <div class="card-header">
                                    <a href="{{ route('users.deleteAllPost') }}" class="btn btn-danger"
                                        data-confirm-delete="true">
                                        Xóa tất cả bài viết
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover ">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Thumbnail</th>
                                                <th>Description</th>
                                                <th>Publish Date</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($posts->count() > 0)
                                                @foreach ($posts as $key => $item)
                                                    <tr>
                                                        <td>
                                                            <a
                                                                href="{{ route('posts.show', ['post' => $item]) }}">{{ $item->title }}</a>
                                                        </td>
                                                        <td>{{ $item->thumbnail }}</td>
                                                        <td>{{ $item->description }}</td>
                                                        <td>
                                                            @if (empty($item->publish_date))
                                                                {{ 'PENDING' }}
                                                            @else
                                                                @datetime($item->publish_date)
                                                            @endif
                                                        </td>
                                                        <td> @datetime($item->created_at) </td>
                                                        <td class="text-center">
                                                            {{ getButtonPostStatus($item->status) }}
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('posts.edit', ['post' => $item]) }}"
                                                                class="btn btn-warning">
                                                                <i class="far fa-edit"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="{{ route('posts.destroy', ['post' => $item]) }}"
                                                                class="btn btn-danger" data-confirm-delete="true">
                                                                <i style="pointer-events: none" class="fas fa-trash">
                                                                </i>
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
                                                <th>Description</th>
                                                <th>Publish Date</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
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
