@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.2.0/css/all.min.css">
    <style>
        #permission.tree, #permission.tree ul {
            margin:0 !important;
            padding:0 !important;
            list-style:none !important;
        }
        #permission.tree ul {
            margin-left:0.5em !important;
            position:relative;
        }
        #permission.tree ul ul {
            margin-left:.5em;
        }
        #permission.tree ul:before {
            content:"";
            display:block;
            width:0;
            position:absolute;
            top:0;
            bottom:0;
            left:0;
            border-left:1px solid;
            z-index: 1;
        }
        #permission.tree li {
            margin:0 0 10px 0;
            padding: .5rem 0 .5rem .5em;
            line-height:2em;
            font-weight:700;
            position:relative;
            border-left: 2px solid #038fde;
            box-shadow: 0 2px 5px rgba(0,0,0,0.5);
            background: #212529;
        }
        #permission.tree li:hover{
            cursor: move;
        }
        #permission.tree li li{
            margin:0;
            padding: 0 0 0 1em;
            line-height:2em;
            font-weight:700;
            position:relative;
            border-left: 0;
            box-shadow: none !important;
        }
        #permission.tree ul li:before {
            content:"";
            display:block;
            width:10px;
            height:0;
            border-top:1px solid;
            margin-top:-1px;
            position:absolute;
            top:1em;
            left:0
        }
        .indicator {
            margin-right:5px;
        }

        #permission.tree li .indicator{
            position: absolute;
            top: 12px;
            right: 20px;
            color: #ffffff;
            font-size: 18px;
            float: right;
            line-height: 25px;
            cursor: pointer;
        }
        #permission.tree li li .indicator{
            position: absolute;
            top: 0;
            right: 20px;
            color: #ffffff;
            font-size: 18px;
            float: right;
            line-height: 30px;
            cursor: pointer;
        }
    </style>
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

                        <x-form.inputbox labelName="Alt Text" name="alt_text" value="{{ $edit->alt_text ?? '' }}" required="required" placeholder="Enter Alt Text"/>

                        <x-form.selectbox labelName="Status" name="status" required="required">
                            <option value="">Select Status</option>
                            @foreach (STATUS as $key=>$value)
                            <option value="{{ $key }}" {{ $edit->status == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </x-form.selectbox>
                        <x-form.inputbox type="file" labelName="Image" name="image"/>
                        <input type="hidden" name="old_image" value="{{ $edit->image ?? '' }}">


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
