<div class="modal fade" id="store_or_update_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-1">
            <div class="modal-header py-1">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="btn-close shadow-none" style="font-size: 10px;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="store_or_update_form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <x-form.inputbox type="file" name="files[]" labelName="File" required="required" multiple="multiple" optional="Please upload files in JPG, PNG, JPEG, GIF, PDF, or MP4 format. Maximum file size: 5MB."/>
                </form>
                <div class="text-end">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-info rounded-0" id="save-btn"></button>
                </div>
            </div>
        </div>
    </div>
</div>

