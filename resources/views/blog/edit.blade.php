@extends('layouts.app')
@section('title',$siteTitle)
@push('styles')

@endpush

@section('content')
<form method="POST" id="blog_form">
    @csrf
    <input type="hidden" name="update_id" value="{{ $edit->id }}">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 card-title">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <x-form.inputbox labelName="Title" value="{{ $edit->title }}" name="title" required="required" placeholder="Enter title"/>
                    <x-form.inputbox labelName="Slug" value="{{ $edit->slug }}" name="slug" required="required" placeholder="Enter slug"/>
                    <x-form.textarea labelName="Short Description" value="{{ $edit->short_description }}" name="short_description" required="required" placeholder="Enter Short Description"></x-form.textarea>
                    <x-form.textarea labelName="Description" name="description" value="{{ $edit->description }}" required="required" placeholder="Enter Description"></x-form.textarea>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 card-title">SEO Data</h4>
                </div>
                <div class="card-body">
                    <small class="d-block mb-3">Setup meta title & description to make your site easy to discovered on search engines such as Google</small>
                    <x-form.inputbox labelName="Meta Title" name="meta_title" value="{{ $edit->meta_title ?? '' }}" placeholder="Enter title" optional="Meta titles with 50-60 characters, including spaces, for ideal Google search visibility"/>
                    <x-form.textarea labelName="Meta Description" value="{{ $edit->meta_description ?? '' }}" name="meta_description" placeholder="Enter description" optional="Meta description with 155-160 characters, including spaces, for ideal Google search visibility"></x-form.textarea>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Published</h4>
                </div>
                <div class="card-body">
                    <x-form.selectbox required="required" name="status" labelName="Status">
                        @foreach (POST_STATUS as $key=>$value)
                        <option value="{{ $key }}" {{ $edit->status == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </x-form.selectbox>
                    <x-form.selectbox required="required" name="visibility" labelName="Visibility">
                        @foreach (VISIBILITY as $key=>$value)
                        <option value="{{ $key }}" {{ $edit->visibility == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </x-form.selectbox>
                    <x-form.inputbox required="required" value="{{ $edit->published_date }}" labelName="Publish immediately" name="published_date" placeholder="YYYY-MM-DD"/>

                    <div class="text-end">
                        <button type="button" id="save-btn" class="btn btn-sm btn-primary rounded-0"><span></span> Update</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 required">Categories</h4>
                </div>
                <div class="card-body">
                    <ul class="m-0 o-0 list-unstyled">
                        @forelse ($categories as $id=>$name)
                        <li>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="checkbox" value="{{ $id }}" name="category[]" id="category-{{ $id }}" {{ in_array($id, $selectedCategories) ? 'checked' : '' }}>
                                <label class="form-check-label" for="category-{{ $id }}">{{ $name }}</label>
                            </div>
                        </li>
                        @empty
                        <li>No categories available.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 required">Feature image</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div id="feature_image"></div>
                        <input type="hidden" name="old_feature_image" id="old_feature_image" value="{{ $edit->feature_image ?? '' }}">
                    </div>
                    <x-form.inputbox name="alt_text" groupClass="mt-3 mb-0" value="{{ $edit->alt_text ?? '' }}" placeholder="Enter alt text for feature image"/>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('js/spartan-multi-image-picker-min.js') }}"></script>

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

    $('#feature_image').spartanMultiImagePicker({
        fieldName: 'feature_image',
        maxCount: 1,
        rowHeight: '200px',
        groupClassName: 'col-md-12 com-sm-12 com-xs-12 mb-0',
        maxFileSize: '',
        dropFileLabel: 'Drop Here',
        allowExt: 'png|jpg|jpeg',
        onExtensionErr: function(index, file){
            Swal.fire({icon:'error',title:'Oops...',text: 'Only png,jpg,jpeg file format allowed!'});
        },
        onSizeErr : function(index, file){
			console.log(index, file,  'file size too big');
			Swal.fire({icon:'error',title:'Oops...',text: 'file size too big!'});
		}
    });

    $('input[name="feature_image"]').prop('required',true);
    $('.remove-files').on('click', function(){
        $(this).parents('.col-md-12').remove();
    });

    flatpickr('#published_date',{
        minDate: 'today',
        enableTime: false,
        dateFormat: "Y-m-d",
    });

    $(document).on('click','#save-btn',function(){
        var form = document.getElementById('blog_form');
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url: "{{ route('app.posts.store') }}",
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
                        toastr_alert('error',value);
                        $('#blog_form #'+key).addClass('is-invalid');
                        $('#blog_form #'+key).parent().append('<small class="text-danger d-block error">'+value+'</small>');
                    });
                }else{
                    notification(response.status,response.message);
                    if (response.status == 'success') {
                        setInterval(() => {
                            window.location.href = "{{ route('app.posts.index') }}";
                        }, 1000);
                    }
                }
            }
        });
    });

    @if($edit->feature_image)
        $('#blog_form #feature_image img.spartan_image_placeholder').css('display','none');
        $('#blog_form #feature_image .spartan_remove_row').css('display','none');
        $('#blog_form #feature_image .img_').css('display','block');
        $('#blog_form #feature_image .img_').attr('src',"{{ asset('uploads/'.BLOG_PATH.$edit->feature_image) }}");
    @endif
</script>
@endpush
