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
                        @permission('blog-create')
                        <a href="{{ url('menus/manage?id=new') }}" class="btn btn-sm btn-primary rounded-1"><i class="fa fa-plus fa-sm"></i> Add Menu</a>
                        @endpermission
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table-sm table-striped table-bordered table table-hover mb-0" id="menu_table">
                            <thead>
                                <th>SL</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Created By</th>
                                <th>Created Date</th>
                                @if(permission('blog-delete') || permission('blog-view') || permission('blog-edit'))
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
    table = $('#menu_table').DataTable({
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
            url: "{{ route('app.menus.index') }}",
            type: "GET",
            dataType: "JSON",
            data: function(d) {
                d._token = _token;
                d.search = $('input[name="search_here"]').val();
            },
        },
        columns: [
            {data: 'DT_RowIndex'},
            {data: 'title'},
            {data: 'location'},
            {data: 'created_by'},
            {data: 'created_at'},
            @if(permission('blog-delete') || permission('blog-view') || permission('blog-edit'))
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
                        <input name='search_here' class='form-control-sm form-control ms-2 rounded-0 shadow-none' placeholder="Enter Menu Title" autocomplete="off"/>
                    </div>`,
        }
    });

    @permission('blog-delete')
    // single delete
    $(document).on('click', '.delete_data', function () {
        let id   = $(this).data('id');
        let name = $(this).data('name');
        let row  = table.row($(this).parent('tr'));
        let url  = "{{ route('app.menus.delete') }}";
        delete_data(id,url,row,name);
    });
    @endpermission

</script>
@endpush

