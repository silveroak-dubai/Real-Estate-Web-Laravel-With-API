<div class="modal fade" id="store_or_update_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-1">
            <div class="modal-header py-1">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="btn-close shadow-none" style="font-size: 10px;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="store_or_update_form" method="POST">
                    @csrf
                    <input type="hidden" id="update_id" name="update_id">
                    <x-form.inputbox labelName="Name" name="name" placeholder="Enter department" required="required"/>
                    <x-form.inputbox labelName="Slug" name="slug" placeholder="Enter slug" required="required" optional="The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens."/>
                    <x-form.selectbox labelName="Status" name="status" required="required">
                        @foreach (STATUS as $key=>$value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-form.selectbox>
                    <x-form.inputbox labelName="Meta Title" name="meta_title" placeholder="Enter title" optional="Meta titles with 50-60 characters, including spaces, for ideal Google search visibility"/>
                    <x-form.textarea labelName="Meta Description" name="meta_description" placeholder="Enter description" optional="Meta description with 155-160 characters, including spaces, for ideal Google search visibility"></x-form.textarea>
                </form>
                <div class="text-end">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-btn"></button>
                </div>
            </div>
        </div>
    </div>
</div>
