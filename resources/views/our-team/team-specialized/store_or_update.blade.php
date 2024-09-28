<div class="modal fade" id="store_or_update_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-1">
            <div class="modal-header py-1">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="btn-close shadow-none" style="font-size: 10px;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="store_or_update_form" method="POST">
                    @csrf
                    <input type="hidden" id="update_id" name="update_id">
                    <x-form.inputbox labelName="Name" name="name" placeholder="Enter specialized name"/>
                    <x-form.selectbox labelName="Status" name="status" required="required">
                        @foreach (STATUS as $key=>$value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-form.selectbox>
                </form>
                <div class="text-end">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-btn"></button>
                </div>
            </div>
        </div>
    </div>
</div>
