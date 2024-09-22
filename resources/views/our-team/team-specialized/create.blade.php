@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.2.0/css/all.min.css">
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
                        <input type="hidden" name="update_id" id="update_id">

                        <x-form.inputbox labelName="Name" name="name" required="required" placeholder="Enter Name"/>

                        <x-form.selectbox labelName="Status" name="status" required="required">
                            @foreach (STATUS as $key=>$value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-form.selectbox>

                        {{-- <x-form.inputbox type="file" labelName="Image" name="image" required="required"/> --}}
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
        var str = value.replace(/ +(?= )/g,'');
        var name = str.split(' ').join('-');
        $('#slug').val(name);
    });

    $(document).on('click','#save-btn',function(){
        var form = document.getElementById('form_data');
        var formData = new FormData(form);

        $.ajax({
            type: "POST",
            url: "{{ route('app.team-specializeds.store') }}",
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
                            window.location.href = "{{ route('app.team-specializeds.index') }}";
                        }, 1000);
                    }
                }
            }
        });
    });
</script>
@endpush
