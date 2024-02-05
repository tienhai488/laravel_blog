<div class="container-form container-form-modal-delete" onclick="onOutsideModalDelete(event)">
    <div class="container form-main-modal-delete border"
        style="max-width: 400px; padding: 30px 20px; border-radius: 20px; margin: 0 auto;background-color: white;">
        <div class="form">
            <h4 class="text-center"><strong>{{ $title }}</strong></h4>
            <h5 class="text-center mt-3">{{ $content }}</h5>
            <hr>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" onclick="offModalDelete()">Hủy</button>
                <form action="" method="post" id="form-modal-delete">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger ml-3">Đồng ý</button>
                </form>

            </div>
        </div>
    </div>
</div>
