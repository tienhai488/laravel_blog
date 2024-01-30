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
                                        <input type="text" class="form-control" value="{{ request()->name }}"
                                            name="name" placeholder="Nhập tên cần tìm kiếm...">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" value="{{ request()->email }}"
                                            name="email" placeholder="Nhập email cần tìm kiếm ...">
                                    </div>
                                    <div class="col-2">
                                        <select name="status" class="form-control">
                                            <option value="">Tất cả trạng thái</option>
                                            @foreach (array_column(\App\Enum\UserStatusEnum::cases(), 'value') as $status)
                                                <option value="{{ $status }}" @selected("$status" == request()->status)>
                                                    {{ \App\Enum\UserStatusEnum::getDescription($status) }}
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
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($users->count() > 0)
                                                @foreach ($users as $key => $item)
                                                    <tr>
                                                        <td>
                                                            {{ $item->name }}
                                                        </td>
                                                        <td>
                                                            {{ $item->email }}
                                                        </td>
                                                        <td>
                                                            {{ $item->address }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ getButtonUserStatus($item) }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $item->created_at }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($user->id != $item->id)
                                                                <a href="{{ route('admin.users.update', ['user' => $item]) }}"
                                                                    class="btn btn-warning">
                                                                    <i class="far fa-edit"></i>
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
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
