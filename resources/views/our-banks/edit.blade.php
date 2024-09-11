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
                    <form method="POST" id="form_data">
                        @csrf
                        <input type="hidden" name="update_id" id="update_id" value="{{ $edit->id }}">
                        <x-form.inputbox type="file" labelName="Image" name="image"/>
                        <input type="hidden" name="old_image" value="{{ $edit->image ?? '' }}">
                        <x-form.inputbox labelName="Alt Text" name="alt_text" value="{{ $edit->alt_text ?? '' }}" required="required" placeholder="Enter Alt Text"/>
                        <x-form.selectbox labelName="Status" name="status" required="required">
                            <option value="">Select Status</option>
                            @foreach (STATUS as $key=>$value)
                            <option value="{{ $key }}" {{ $edit->status == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </x-form.selectbox>
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
<script src="{{ asset('js') }}/tree.js"></script>
<script>
    $('#permission').treed(); //intialized tree js

    $(document).on('click','#save-btn',function(){
        var form = document.getElementById('form_data');
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url: "{{ route('app.our-banks.store') }}",
            data: formData,
            dataType: "JSON",
            contentType: false,
            processData: false,
            cache: false,
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
                            // window.location.href = "{{ route('app.our-banks.index') }}";
                        }, 1000);
                    }
                }
            }
        });
    });
</script>
@endpush
