@extends('layouts.client')

@section('content')
    @csrf
    <div class="row">
        <div class="col-8" style="margin: 20px auto;">
            <h1>{{ $title ?? 'Danh sách' }}</h1>
            <hr>
            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus pr-1"></i>
                Thêm bài viết
            </a>
            <hr>
            <form action="{{ route('admin.posts.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <input id="title" type="text" class="form-control" value="{{ request()->title }}"
                            name="title" placeholder="Nhập tiêu cần tìm kiếm..." spellcheck="false">
                    </div>
                    <div class="col-3">
                        <select id="status" name="status" class="form-control">
                            <option value="">Tất cả trạng thái</option>
                            @foreach (array_column(\App\Enum\PostStatusEnum::cases(), 'value') as $status)
                                <option value="{{ $status }}" @selected("$status" == request()->status)>
                                    {{ \App\Enum\PostStatusEnum::getDescription($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary btn-block btn-filter">
                            Tìm kiếm
                        </button>
                    </div>
                </div>
            </form>
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
                                    <button class="btn btn-danger btn-delete"
                                        data-delete-url="{{ route('users.delete_all_post') }}"
                                        data-delete-type="delete-all-post" onclick="onModalDeleteAllPost(event)">
                                        Xóa tất cả bài viết
                                    </button>
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
            ajax: {
                url: '{{ route('admin.posts.data_client') }}',
                data: function(data) {
                    data.title = $('#title').val();
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

        let btnFilter = document.querySelector('.btn-filter');
        btnFilter.onclick = (e) => {
            e.preventDefault();
            dataTable.ajax.reload();
        }

        const onOutsideModalDelete = (event) => {
            const ignoreClickOnMeElement = document.querySelector(".form-main-modal-delete");
            const isClickInsideElement = ignoreClickOnMeElement.contains(event.target);
            if (!isClickInsideElement) {
                offModalDelete();
            }
        };

        const onModalDelete = (event) => {
            let url = event.target.dataset.deleteUrl;
            let type = event.target.dataset.deleteType;
            const form = document.querySelector(".container-form-modal-delete");
            form.classList.add("active");
            document.querySelector('.btn-submit-delete').dataset.deleteUrl = url;
            document.querySelector('.btn-submit-delete').dataset.deleteType = type;
        };

        const onModalDeletePost = (event) => {
            onModalDelete(event);
            let title = "Xóa bài viết";
            let content = "Bạn có chắc chắn muốn xóa bài viết?";
            handleContentModal(title, content);
        }

        const onModalDeleteAllPost = (event) => {
            onModalDelete(event);
            let title = "Xóa tất cả bài viết";
            let content = "Bạn có chắc chắn muốn xóa tất cả bài viết?";
            handleContentModal(title, content);
        }

        const offModalDelete = () => {
            const modalDelete = document.querySelector(".container-form-modal-delete");
            modalDelete.classList.remove("active");
        };

        const handleContentModal = (title, content) => {
            let form = document.querySelector(".container-form-modal-delete");
            form.querySelector('.title').innerHTML = `<strong>${title}</strong>`;
            form.querySelector('.content').innerHTML = content;
        }

        const onSubmitDelete = async (event) => {
            let url = event.target.dataset.deleteUrl;
            let type = event.target.dataset.deleteType;
            let message = type == 'delete-all-post' ? 'tất cả ' : '';

            let response = await fetch(url, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-Token": $('input[name="_token"]').val()
                },
                method: 'DELETE',
            });
            let jsonData = await response.json();
            if (jsonData.result > 0) {
                offModalDelete();

                await dataTable.ajax.reload();

                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: `Xóa ${message} bài viết thành công!`,
                    showConfirmButton: false,
                    timer: 1500
                });
            } else {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: `Xóa ${message}bài viết không thành công!`,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    </script>
@endsection
