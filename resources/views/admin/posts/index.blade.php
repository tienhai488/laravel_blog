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
                                        <input id="title" type="text" class="form-control"
                                            value="{{ request()->title }}" name="title"
                                            placeholder="Nhập tiêu cần tìm kiếm..." spellcheck="false">
                                    </div>
                                    <div class="col-4">
                                        <input id="email" type="text" class="form-control"
                                            value="{{ request()->email }}" name="email"
                                            placeholder="Nhập email cần tìm kiếm ..." spellcheck="false">
                                    </div>
                                    <div class="col-2">
                                        <select id="status" name="status" class="form-control">
                                            <option value="">Tất cả trạng thái</option>
                                            @foreach (array_column(\App\Enum\PostStatusEnum::cases(), 'value') as $status)
                                                <option value="{{ $status }}" @selected("$status" == request()->status)>
                                                    {{ \App\Enum\PostStatusEnum::getDescription($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-primary btn-block btn-filter">
                                            Tìm kiếm
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="card">
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered table-hover ">
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
        let dataTable = new DataTable('#datatable', {
            ajax: {
                url: '{{ route('admin.posts.data') }}',
                data: function(data) {
                    data.title = $('#title').val();
                    data.email = $('#email').val();
                    data.status = $('#status').val();
                },
            },
            ordering: false,
            processing: true,
            serverSide: true,
            searching: false,
            pageLength: 2,
            paging: true,
            lengthChange: true,
            responsive: true,
            columns: [{
                    data: "title"
                },
                {
                    data: "thumbnail"
                },
                {
                    data: "author"
                },
                {
                    data: "status"
                },
                {
                    data: "description"
                },
                {
                    data: "publish_date"
                },
                {
                    data: "created_at"
                },
                {
                    data: "show"
                },
                {
                    data: "edit"
                },
            ],
        });

        let btnFilter = document.querySelector('.btn-filter');
        btnFilter.onclick = (e) => {
            e.preventDefault();
            dataTable.ajax.reload();
        }
    </script>
@endsection
