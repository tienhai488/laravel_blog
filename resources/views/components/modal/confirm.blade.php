<div class="container-form container-form-modal-delete" onclick="onOutsideModalDelete(event)">
    <div class="container form-main-modal-delete border"
        style="max-width: 400px; padding: 30px 20px; border-radius: 20px; margin: 0 auto;background-color: white;">
        <div class="form">
            <h4 class="text-center title"><strong>{{ $title }}</strong></h4>
            <h5 class="text-center mt-3 content">{{ $content }}</h5>
            <hr>
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary" onclick="offModalDelete()">Hủy</button>
                <button class="btn btn-danger ml-3 btn-submit-delete" onclick="onSubmitDelete(event)">Đồng ý</button>
            </div>
        </div>
    </div>
</div>
