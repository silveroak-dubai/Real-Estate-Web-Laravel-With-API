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
                        @permission('our-bank-create')
                        <a href="{{ route('app.our-banks.create') }}" class="btn btn-sm btn-primary rounded-1">Add Our Bank</a>
                        @endpermission
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-sm table-striped table-bordered table table-hover mb-0" id="blog_table">
                            <thead>
                                @permission('our-bank-bulk-delete')
                                <th>
                                    <div class="form-checkbox">
                                        <input type="checkbox" class="form-check-input" id="select_all" onclick="select_all()">
                                        <label class="form-check-label" for="select_all"></label>
                                    </div>
                                </th>
                                @endpermission
                                <th>SL</th>
                                <th>Image</th>
                                <th>Alt Text</th>
                                @permission('our-bank-status')
                                <th>Status</th>
                                @endpermission
                                <th>Created By</th>
                                <th>Created At</th>
                                @if(permission('our-bank-delete') || permission('our-bank-view') || permission('our-bank-edit'))
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
            url: "{{ route('app.our-banks.index') }}",
            type: "GET",
            dataType: "JSON",
            data: function(d) {
                d._token = _token;
                d.search = $('input[name="search_here"]').val();
            },
        },
        columns: [
            @permission('our-bank-bulk-delete')
            {data: 'bulk_check'},
            @endpermission
            {data: 'DT_RowIndex'},
            {data: 'image'},
            {data: 'alt_text'},
            @permission('our-bank-status')
            {data: 'status'},
            @endpermission
            {data: 'created_by'},
            {data: 'created_at'},
            @if(permission('our-bank-delete') || permission('our-bank-view') || permission('our-bank-edit'))
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

    @permission('our-bank-delete')
    // single delete
    $(document).on('click', '.delete_data', function () {
        let id   = $(this).data('id');
        let name = $(this).data('name');
        let row  = table.row($(this).parent('tr'));
        let url  = "{{ route('app.our-banks.delete') }}";
        delete_data(id,url,row,name);
    });
    @endpermission

    @permission('our-bank-bulk-delete')
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
            let url = "{{ route('app.our-banks.bulk-delete') }}";
            bulk_delete(ids,url,rows);
        }
    }
    @endpermission

    @permission('our-bank-status')
    // status changes
    $(document).on('click','.change_status', function(){
        var id = $(this).data('id');
        var name = $(this).data('name');
        var status = $(this).data('status');
        var url = "{{ route('app.our-banks.status-change') }}"
        change_status(id,status,name,url);
    });
    @endpermission
</script>
@endpush

