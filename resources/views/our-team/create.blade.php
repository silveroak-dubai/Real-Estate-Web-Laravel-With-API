@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.2.0/css/all.min.css">
@endpush

@section('content')
<form method="POST" id="form_data">
    @csrf
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 card-title">{{ $title }}</h4>
                </div>
                <div class="card-body">
                    <x-form.inputbox labelName="Full Name" name="full_name" required="required" placeholder="Enter Full Name"/>
                    <x-form.inputbox labelName="Position" name="position" required="required" placeholder="Enter Position"/>
                    <x-form.inputbox labelName="Experience" name="experience" required="required" placeholder="Enter Experience"/>
                    <x-form.selectbox labelName="Department" name="department_id" required="required">
                        <option value="">Select Department</option>
                        @forelse ($departments as $id=>$name)
                        <option value="{{ $id }}">{{ $name }}</option>
                        @empty

                        @endforelse
                    </x-form.selectbox>
                    <x-form.textarea labelName="Description" name="description" required="required" placeholder="Enter Description"></x-form.textarea>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 card-title">SEO Data</h4>
                </div>
                <div class="card-body">
                    <small class="d-block mb-3">Setup meta title & description to make your site easy to discovered on search engines such as Google</small>
                    <x-form.inputbox labelName="Meta Title" name="meta_title" placeholder="Enter title" optional="Meta titles with 50-60 characters, including spaces, for ideal Google search visibility"/>
                    <x-form.textarea labelName="Meta Description" name="meta_description" placeholder="Enter description" optional="Meta description with 155-160 characters, including spaces, for ideal Google search visibility"></x-form.textarea>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="card">
                <div class="card-header"><h4 class="card-title mb-0">Published</h4></div>
                <div class="card-body">
                    <x-form.selectbox required="required" name="status" labelName="Status">
                        @foreach (POST_STATUS as $key=>$value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </x-form.selectbox>
                    <div class="text-end">
                        <button type="button" id="save-btn" class="btn btn-sm btn-primary rounded-0"><span></span> Published</button>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 required">Specialized</h4>
                </div>
                <div class="card-body">
                    <ul class="m-0 o-0 list-unstyled" id="specialized">
                        @forelse ($specializeds as $id=>$name)
                        <li>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="radio" value="{{ $id }}" name="specialized_id" id="specialized-{{ $id }}">
                                <label class="form-check-label" for="specialized-{{ $id }}">{{ $name }}</label>
                            </div>
                        </li>
                        @empty

                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 required">Languages</h4>
                </div>
                <div class="card-body">
                    <ul class="m-0 o-0 list-unstyled" id="languages">
                        @forelse ($languages as $id=>$name)
                        <li>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="checkbox" value="{{ $id }}" name="languages[]" id="languages-{{ $id }}">
                                <label class="form-check-label" for="languages-{{ $id }}">{{ $name }}</label>
                            </div>
                        </li>
                        @empty

                        @endforelse
                    </ul>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 required">image</h4>
                </div>
                <div class="card-body">
                    <div>
                        <div id="image"></div>
                    </div>
                    <x-form.inputbox name="alt_text" groupClass="mt-3 mb-0" placeholder="Enter alt text for image"/>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="{{ asset('js/spartan-multi-image-picker-min.js') }}"></script>
<script>
    $('#image').spartanMultiImagePicker({
        fieldName: 'image',
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

    $('input[name="image"]').prop('required',true);
    $('.remove-files').on('click', function(){
        $(this).parents('.col-md-12').remove();
    });

    $(document).on('keyup keypress','#title',function(){
        var input_value = $(this).val();
        var value = input_value.toLowerCase().trim();
        var str = value.replace(/ +(?= )/g,'');
        var name = str.split(' ').join('-');
        $('#slug').val(name);
    });

    $(document).on('click','#save-btn',function(){
        var form = document.getElementById('form_data');
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url: "{{ route('app.our-teams.store') }}",
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
                $('#form_data').find('.error').remove();
                $('#form_data').find('.is-invalid').removeClass('is-invalid');
                if (response.status == false) {
                    $.each(response.errors,function(key,value){
                        $('#form_data #'+key).addClass('is-invalid');
                        $('#form_data #'+key).parent().append('<span class="text-danger error">'+value+'</span>');
                    });
                }else{
                    notification(response.status,response.message);
                    if (response.status == 'success') {
                        setInterval(() => {
                            window.location.href = "{{ route('app.our-teams.index') }}";
                        }, 1000);
                    }
                }
            }
        });
    });
</script>
@endpush
