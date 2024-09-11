@extends('layouts.app')
@section('title',$siteTitle)
@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-12 col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 card-title">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="blog_form">
                        @csrf
                        <input type="hidden" name="update_id" id="update_id">

                        <x-form.inputbox labelName="Title" name="title" required="required" placeholder="Enter title"/>
                        <x-form.inputbox labelName="Slug" name="slug" required="required" placeholder="Enter slug"/>
                        <x-form.textarea labelName="Short Description" name="short_description" required="required" placeholder="Enter Short Description"></x-form.textarea>
                        <x-form.selectbox labelName="Is Comment" name="is_comment" required="required">
                            @foreach (ENABLED_DISABLED as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-form.selectbox>
                        <x-form.selectbox labelName="Status" name="status" required="required">
                            @foreach (STATUS as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-form.selectbox>
                        <x-form.textarea labelName="Description" name="description" required="required" placeholder="Enter Description"></x-form.textarea>
                        <x-form.inputbox labelName="Published Date" name="published_date" required="required" placeholder="YYYY-MM-DD"/>
                        <x-form.inputbox type="file" labelName="Image" name="image" required="required"/>
                        <x-form.inputbox labelName="Meta Title" name="meta_title" placeholder="Enter title"/>
                        <x-form.textarea labelName="Meta Description" name="meta_description" placeholder="Enter description"></x-form.textarea>
                    </form>

                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-sm btn-primary rounded-0" id="save-btn"><span></span> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).on('keyup keypress','#title',function(){
        var input_value = $(this).val();
        var value = input_value.toLowerCase().trim();
        // Remove extra spaces and special characters, allow only alphanumeric and spaces
        var str = value.replace(/[^a-z0-9 ]/g, '').replace(/ +(?= )/g, '');

        // Replace spaces with hyphens
        var name = str.split(' ').join('-');
        $('#slug').val(name);
    });

    $(document).on('click','#save-btn',function(){
        var form = document.getElementById('blog_form');
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url: "{{ route('app.blogs.store') }}",
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function(){
                $('#save-btn span').addClass('spinner-border spinner-border-sm text-light');
            },
            complete: function(){
                $('#save-btn span').removeClass('spinner-border spinner-border-sm text-light');
            },
            success: function (response) {
                $('#blog_form').find('.error').remove();
                $('#blog_form').find('.is-invalid').removeClass('is-invalid');
                if (response.status == false) {
                    $.each(response.errors,function(key,value){
                        $('#blog_form #'+key).addClass('is-invalid');
                        $('#blog_form #'+key).parent().append('<small class="text-danger d-block error">'+value+'</small>');
                    });
                }else{
                    notification(response.status,response.message);
                    if (response.status == 'success') {
                        setInterval(() => {
                            window.location.href = "{{ route('app.blogs.index') }}";
                        }, 1000);
                    }
                }
            }
        });
    });
</script>
@endpush
