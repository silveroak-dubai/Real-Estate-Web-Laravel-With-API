@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 card-title d-flex align-items-center justify-content-between">{{ $title }}
                        @if(permission('testimonial-create'))
                        <button type="button" onclick="showFormModal('New Testimonial','Save')" class="btn btn-sm btn-primary rounded-1"><i class="fa fa-plus fa-sm"></i> Add Testimonial</button>
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-sm table-striped table-bordered table table-hover mb-0" id="blog_table">
                            <thead>
                                @if(permission('testimonial-bulk-delete'))
                                <th>
                                    <div class="form-checkbox">
                                        <input type="checkbox" class="form-check-input" id="select_all" onclick="select_all()">
                                        <label class="form-check-label" for="select_all"></label>
                                    </div>
                                </th>
                                @endif
                                <th>SL</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Role</th>
                                <th>Rating</th>
                                <th>Feedback</th>
                                @if(permission('testimonial-status'))
                                <th>Status</th>
                                @endif
                                <th>Created By</th>
                                <th>Created At</th>
                                @if(permission('testimonial-delete') || permission('testimonial-edit'))
                                <th class="text-end">Action</th>
                                @endif
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(permission('testimonial-create') || permission('testimonial-edit'))
    @include('testimonial.store_or_update')
    @endif
@endsection

@push('scripts')
<script>
    table = $('#blog_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [], //Initial no order
        bInfo: true, //TO show the total number of data
        bFilter: false, //For datatable default search box show/hide
        ordering: false,
        lengthMenu: [
            [5, 10, 15, 25, 50, 100, -1],
            [5, 10, 15, 25, 50, 100, "All"]
        ],
        pageLength: "{{ TABLE_PAGE_LENGTH }}", //number of data show per page
        ajax: {
            url: "{{ route('app.testimonials.index') }}",
            type: "GET",
            dataType: "JSON",
            data: function(d) {
                d._token = _token;
                d.search = $('input[name="search_here"]').val();
            },
        },
        columns: [
            @if(permission('testimonial-bulk-delete'))
            {data: 'bulk_check'},
            @endif
            {data: 'DT_RowIndex'},
            {data: 'image'},
            {data: 'name'},
            {data: 'role'},
            {data: 'rating'},
            {data: 'feedback'},
            @if(permission('testimonial-status'))
            {data: 'status'},
            @endif
            {data: 'created_by'},
            {data: 'created_at'},
            @if(permission('testimonial-delete') || permission('testimonial-view') || permission('testimonial-edit'))
            {data: 'action'}
            @endif
        ],
        language: {
            processing: '<div class="text-center"><img src="{{ asset("img/table-loading.svg") }}"></div>',
            emptyTable: '<strong class="text-danger">No Data Found</strong>',
            infoEmpty: '',
            zeroRecords: '<strong class="text-danger">No Data Found</strong>',
            oPaginate: {
                sPrevious: "Previous", // This is the link to the previous page
                sNext: "Next", // This is the link to the next page
            },
            lengthMenu: `<div class='d-flex align-items-center w-100'>_MENU_
                    <div class="d-flex align-items-center">
                        <button type='button' style='min-width: 115px;' class='btn btn-sm btn-danger d-none rounded-0 delete_btn ms-2 px-3' onclick='multi_delete()'>Bulk Delete</button>

                        <input name='search_here' class='form-control-sm form-control ms-2 rounded-0 shadow-none' placeholder="Search here..." autocomplete="off"/>
                    </div>
                </div>`,
        }
    });

    @permission('testimonial-create')
    $(document).on('click', '#save-btn', function(){
        var id = $('input#update_id').val();
        var form = document.getElementById('store_or_update_form');
        var formData = new FormData(form);
        var url = "{{ route('app.testimonials.store-or-update') }}";
        var method;
        if (id) {
            method = 'update';
        }else{
            method = 'add';
        }
        store_or_update_data(method,url,formData);
    });
    @endpermission

    @permission('testimonial-edit')
    $(document).on('click','.edit_data',function(){
        let id = $(this).data('id');
        $('#store_or_update_form')[0].reset();
        $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
        $('#store_or_update_form').find('.error').remove();
        if (id) {
            $.ajax({
                url: "{{ route('app.testimonials.edit') }}",
                type: "POST",
                data: {id: id,_token:_token},
                dataType: "JSON",
                success: function (data) {
                    $('#store_or_update_form #update_id').val(data.data.id);
                    $('#store_or_update_form #old_image').val(data.data.image);
                    $('#store_or_update_form #name').val(data.data.name);
                    $('#store_or_update_form #role').val(data.data.role);
                    $('#store_or_update_form #rating').val(data.data.rating);
                    $('#store_or_update_form #feedback').val(data.data.feedback);
                    $('#store_or_update_form #status').val(data.data.status);
                    popup_modal.show();
                    $('#store_or_update_modal .modal-title').html(
                        '<span>Edit - ' + data.data.name + '</span>');
                    $('#store_or_update_modal #save-btn').html('<span></span> Update');

                },
                error: function (xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        }
    });
    @endpermission

    @if(permission('testimonial-delete'))
    // single delete
    $(document).on('click', '.delete_data', function () {
        let id   = $(this).data('id');
        let name = $(this).data('name');
        let row  = table.row($(this).parent('tr'));
        let url  = "{{ route('app.testimonials.delete') }}";
        delete_data(id,url,row,name);
    });
    @endif

    @if (permission('testimonial-bulk-delete'))
    // multi delete
    function multi_delete(){
        let ids = [];
        let rows;
        $('.select_data:checked').each(function(){
            ids.push($(this).val());
            rows = table.rows($('.select_data:checked').parents('tr'));
        });

        if(ids.length == 0){
            Swal.fire({
                type:'error',
                title:'Error',
                text:'Please checked at least one row of table!',
                icon: 'warning',
            });
        }else{
            let url = "{{ route('app.testimonials.bulk-delete') }}";
            bulk_delete(ids,url,rows);
        }
    }
    @endif

    @if(permission('testimonial-status'))
    // status changes
    $(document).on('click','.change_status', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var status = $(this).data('status');
        var url = "{{ route('app.testimonials.status-change') }}"
        change_status(id,status,name,url);
    });
    @endif
</script>
@endpush

