@extends('layouts.client')

@section('content')
    <div class="row">
        <div class="col-8" style="margin: 20px auto;">
            <h1>{{ $title ?? 'Danh sách' }}</h1>
            <hr>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus pr-1"></i>
                Thêm bài viết
            </a>
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
                                    <a href="{{ route('users.delete_all_post') }}" class="btn btn-danger"
                                        data-confirm-delete="true">
                                        Xóa tất cả bài viết
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered table-hover ">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Thumbnail</th>
                                                <th>Status</th>
                                                <th>Description</th>
                                                <th>Publish Date</th>
                                                <th>Created Date</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Title</th>
                                                <th>Thumbnail</th>
                                                <th>Status</th>
                                                <th>Description</th>
                                                <th>Publish Date</th>
                                                <th>Created Date</th>
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
    <x-modal.confirm title="Xóa bài viết" content="Bạn có chắc chắn muốn xóa?" />
@endsection

@section('script')
    <script>
        let dataTable = new DataTable('#datatable', {
            ajax: '{{ route('admin.posts.data_client') }}',
            ordering: false,
            processing: true,
            serverSide: true,
            searching: false,
            pageLength: 2,
            paging: true,
            lengthChange: true,
            columns: [{
                    data: "title"
                },
                {
                    data: "thumbnail"
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
                    data: "edit"
                },
                {
                    data: "delete"
                },
            ],
        });

        const onOutsideModalDelete = (event) => {
            const ignoreClickOnMeElement = document.querySelector(".form-main-modal-delete");
            const isClickInsideElement = ignoreClickOnMeElement.contains(event.target);
            if (!isClickInsideElement) {
                offModalDelete();
            }
        };

        const onModalDelete = (event) => {
            $url = event.target.dataset.deleteUrl;
            const form = document.querySelector(".container-form-modal-delete");
            form.classList.add("active");
            document.querySelector('#form-modal-delete').action = $url;
        };


        const offModalDelete = () => {
            event.preventDefault();
            const modalDelete = document.querySelector(".container-form-modal-delete");
            modalDelete.classList.remove("active");
        };
    </script>
@endsection
