<div id="store_or_update_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close shadow-none" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
                <form id="store_or_update_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-form.inputbox type="file" name="files[]" labelName="File" required="required" multiple="multiple" optional="Please upload files in JPG, PNG, GIF, or PDF format. Maximum file size: 5MB."/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger rounded-0" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-info rounded-0" id="save-btn"></button>
            </div>
        </div>
    </div>
</div>

