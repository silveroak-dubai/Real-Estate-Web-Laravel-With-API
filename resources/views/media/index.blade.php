@extends('layouts.new_app')
@section('site_title', $site_title)
@push('styles')
    <style>
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 16px;
        }
        .h-100{
            height: 100%;
        }
        .media-item {
            position: relative;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s;
            max-height: 130px;
            height: 130px;
        }

        .media-item:hover {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        .media-item:hover .media-info {
            bottom: 0;
        }
        .media-item img {
            width: 100%;
            height: 100%;
        }

        .media-info {
            position: absolute;
            bottom: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            padding: 6px 10px;
            background: rgb(68 68 68 / 90%);
            transition: all .5s;
        }

        .media-info h3 {
            font-size: 16px;
            margin: 0;
        }

        .media-info p {
            margin: 5px 0;
            font-size: 14px;
            color: #e2e2e2;
        }

        .bg-transparent{
            background: transparent;
        }
        .position-relative{
            position: relative;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">{{ $title }}</h4>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-sm btn-primary rounded-0" onclick="showFormModal('Upload File', 'Save')"><i class="fa fa-plus fa-sm"></i> Upload File</button>
                    </div>
                </div>
                <div class="box-body position-relative">
                    <div class="preloader-media text-center"><span></span></div>
                    <div class="media-grid">

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('media.modal')

@endsection

@push('scripts')
    <script>
        // update or create type
        $(document).on('click','button#save-btn',function(){
            var form = document.getElementById('store_or_update_form');
            var formData = new FormData(form);
            var url = "{{ route('app.medias.store') }}";
            $.ajax({
                url: url,
                type: "POST",
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
                success: function (data) {
                    $('#store_or_update_form').find('.error').remove();
                    if (data.status == false) {
                        $.each(data.errors, function (key, value) {
                            $('#store_or_update_form input[type="file"]').parent().append(
                                '<small class="error text-danger">' + value + '</small>');
                        });
                    } else {
                        notification(data.status, data.message);
                        if (data.status == 'success') {
                            $('#store_or_update_modal').modal('hide');
                            mediaFileRender();
                        }
                    }
                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        });

        $(document).on('click','#delete-btn',function(){
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure to delete file?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Confirm',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('app.medias.delete') }}",
                        type: "POST",
                        data: {id:id,_token:_token},
                        dataType: "JSON",
                    }).done(function (response) {
                        if (response.status == "success") {
                            Swal.fire("Deleted", response.message, "success").then(function () {
                                mediaFileRender();
                            });
                        }

                        if (response.status == "error") {
                            Swal.fire('Oops...', response.message, "error");
                        }
                    }).fail(function () {
                        Swal.fire('Oops...', "Somthing went wrong with ajax!", "error");
                    });
                }
            });
        });

        function mediaFileRender(){
            $.ajax({
                type: "POST",
                url: "{{ route('app.medias.render') }}",
                data: {_token:_token},
                dataType: "JSON",
                beforeSend: function(){
                    $('.preloader-media span').addClass('spinner-border text-light');
                },
                complete: function(){
                    $('.preloader-media span').removeClass('spinner-border text-light');
                },
                success: function (response) {
                    $('.box-body .media-grid').html('');
                    $('.box-body .media-grid').append(response);
                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        }

        mediaFileRender();

    </script>
@endpush
