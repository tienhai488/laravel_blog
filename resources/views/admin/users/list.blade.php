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
                            <form action="{{ route('admin.users.index') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-4">
                                        <input id="name" type="text" class="form-control"
                                            value="{{ request()->name }}" name="name"
                                            placeholder="Nhập tên cần tìm kiếm..." spellcheck="false">
                                    </div>
                                    <div class="col-4">
                                        <input id="email" type="text" class="form-control"
                                            value="{{ request()->email }}" name="email"
                                            placeholder="Nhập email cần tìm kiếm ..." spellcheck="false">
                                    </div>
                                    <div class="col-2">
                                        <select id="status" name="status" class="form-control">
                                            <option value="">Tất cả trạng thái</option>
                                            @foreach (array_column(\App\Enum\UserStatusEnum::cases(), 'value') as $status)
                                                <option value="{{ $status }}" @selected("$status" == request()->status)>
                                                    {{ \App\Enum\UserStatusEnum::getDescription($status) }}
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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
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
                url: '{{ route('admin.users.data') }}',
                data: function(data) {
                    data.name = $('#name').val();
                    data.email = $('#email').val();
                    data.status = $('#status').val();
                },
            },
            order: [
                [4, 'desc']
            ],
            ordering: false,
            processing: true,
            serverSide: true,
            searching: false,
            pageLength: 3,
            paging: true,
            lengthChange: true,
            columns: [{
                    data: "name"
                },
                {
                    data: "email"
                },
                {
                    data: "address"
                },
                {
                    data: "status"
                },
                {
                    data: "created_at"
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
