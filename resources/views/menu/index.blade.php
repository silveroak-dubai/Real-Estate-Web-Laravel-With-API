@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')
    <link rel="stylesheet" href="{{ asset('css') }}/jquery.nestable.min.css">

    <style>
        .item-list,
        .info-box {
            padding: 10px;
        }

        .item-list-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .card-body p {
            margin-bottom: 5px;
        }

        .info-box {
            margin-bottom: 15px;
        }

        .item-list-footer {
            padding-top: 10px;
        }

        .btn-menu-select {
            padding: 4px 10px;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.7;
        }

        .menu-item-bar {
            background: #eee;
            padding: 5px 10px;
            border: 1px solid #d7d7d7;
            margin-bottom: 5px;
            width: 75%;
            cursor: move;
            display: block;
        }

        #serialize_output {
            display: none;
        }

        .menulocation label {
            font-weight: normal;
            display: block;
        }

        body.dragging,
        body.dragging * {
            cursor: move !important;
        }

        .dragged {
            position: absolute;
            z-index: 1;
        }

        ol.example li.placeholder {
            position: relative;
        }

        ol.example li.placeholder:before {
            position: absolute;
        }

        #menuitem {
            list-style: none;
        }

        #menuitem ul {
            list-style: none;
        }

        .input-box {
            padding: 10px;
            box-sizing: border-box;
        }

        .input-box .form-control {
            margin-bottom: 5px;
        }

        .menulocation label {
            font-weight: normal;
            display: block;
        }

        .dd-item>button {
            display: none;
        }
        .dd-handle {
            cursor: move;
            user-select: none;
            height: 40px;
            line-height: 40px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .accordion-button {
            padding: 14px 20px;
            border-radius: 0;
        }

        .accordion {
            --bs-accordion-border-radius: 0 !important;
        }

        .accordion-item:first-of-type>.accordion-header .accordion-button {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
        }

        .accordion-item:last-of-type {
            border-bottom-right-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
        .dd {
            max-width: 100%;
        }
        .dd-empty, .dd-item, .dd-placeholder {
            background: transparent;
        }
        .dd-handle{
            background: transparent !important;
        }
        button.edit-btn {
            height: 40px !important;
            min-width: 50px !important;
            background: transparent;
            border: 0;
        }
    </style>
@endpush

@section('content')
    @if (count($menus) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card rounded-0">
                    <div class="card-body">
                        <form action="{{ url('menus/manage') }}">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    Select a menu to edit:
                                </div>
                                <div class="me-2" style="min-width: 250px;">
                                    <div class="d-flex align-items-center">
                                        <select name="id" class="form-control form-control-sm rounded-0 shadow-none">
                                            <option value="">Select Menu</option>
                                            @foreach ($menus as $menu)
                                                @if ($desiredMenu != '')
                                                    <option value="{{ $menu->id }}" @if ($menu->id == $desiredMenu->id) selected @endif>
                                                        {{ $menu->title }}</option>
                                                @else
                                                    <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button class="btn btn-sm btn-primary btn-menu-select ms-2">Select</button>
                                    </div>
                                </div>
                                <div class="">
                                    or <a href="{{ url('menus/manage?id=new') }}">Create a new menu</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row" id="main-row">
        <div class="col-md-4 cat-form @if (request()->get('id') == 'new') disabled @endif">
            @include('menu.sidebar')
        </div>
        <div class="col-md-8 cat-view">
            <div class="card rounded-0">
                <div class="card-header">
                    <h4 class="card-title mb-0">Menu Structure</h4>
                </div>
                <div class="card-body">
                    @if (empty($desiredMenu))
                        <h4>Create New Menu</h4>
                        <form method="POST" action="{{ route('app.menus.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <x-form.inputbox name="menu_name" labelName="Menu Name" placeholder="Enter Menu Name"/>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <button class="btn btn-sm btn-primary mt-4">Create Menu</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div id="menu-content">
                            <div class="mb-3">
                                <p>Select categories, posts, department or add custom links to menus.</p>
                                @if ($desiredMenu != '')
                                    <div class="dd" id="menuitems">
                                        <ol class="dd-list accordion" id="accordionPanelsStayOpenExample">

                                            @if (!empty($menuitems))
                                                @forelse ($menuitems as $key => $item)
                                                    <li class="dd-item mt-2" data-id="{{ $item->id }}">
                                                        <div class="border rounded-0 w-100">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="dd-handle border-0 w-100">
                                                                    <i class="fa fa-arrows-alt"></i> {{ $item->title ?? '' }}
                                                                </div>

                                                                <button class="edit-btn" data-bs-toggle="collapse" data-bs-target="#collapseItem{{ $item->id }}">
                                                                    <i class="fa fa-caret-down"></i>
                                                                </button>
                                                            </div>

                                                            <div class="collapse" id="collapseItem{{ $item->id }}">
                                                                <div class="input-box">
                                                                    <form method="POST" action="{{ url('menus/update-menuitem', $item->id) }}">
                                                                        @csrf
                                                                        <x-form.inputbox labelName="Link Name" required="required" name="name" value="{{ $item->title ?? '' }}"/>

                                                                        <x-form.inputbox labelName="URL" required="required" name="slug" value="{{ $item->slug ?? '' }}"/>

                                                                        <x-form.inputbox labelName="Extra Classes" name="classes" value="{{ $item->classes ?? '' }}"/>

                                                                        <div class="form-check">
                                                                            <input type="checkbox" name="target" id="target-{{ $item->id }}" {{ $item->target == "_blank" ? 'checked' : '' }} value="_blank"  class="form-check-input shadow-none">
                                                                            <label class="form-check-label" for="target-{{ $item->id }}">Open in a new tab</label>
                                                                        </div>

                                                                        <div class="mt-2">
                                                                            <button type="submit" class="btn btn-sm btn-primary">Save</button>

                                                                            <a href="{{ url('menus/delete-menuitem', [$item->id, $key]) }}" class="btn btn-sm btn-danger">Delete</a>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @if (isset($item->children))
                                                            <ol class="dd-list mt-2">
                                                                @foreach ($item->children as $in => $data)
                                                                    <li class="dd-item mt-2" data-id="{{ $data->id }}">
                                                                        <div class="border rounded-0 w-100">
                                                                            <div class="d-flex align-items-center justify-content-between">
                                                                                <div class="dd-handle border-0 w-100">
                                                                                    <i class="fa fa-arrows-alt"></i> {{ $data->name ?? $data->title }}
                                                                                </div>

                                                                                <button class="edit-btn" data-bs-toggle="collapse" data-bs-target="#collapseChild{{ $data->id }}">
                                                                                    <i class="fa fa-caret-down"></i>
                                                                                </button>
                                                                            </div>

                                                                            <div class="collapse" id="collapseChild{{ $data->id }}">
                                                                                <div class="input-box">
                                                                                    <form method="POST" action="{{ url('update-menuitem', $data->id) }}">
                                                                                        @csrf
                                                                                        <x-form.inputbox labelName="Link Name" required="required" name="name" value="{{ $data->name ?? $data->title }}"/>

                                                                                        <x-form.inputbox labelName="URL" required="required" name="slug" value="{{ $data->slug }}"/>

                                                                                        <x-form.inputbox labelName="Extra Classes" name="classes" value="{{ $data->classes ?? '' }}"/>

                                                                                        <div class="form-check">
                                                                                            <input type="checkbox" name="target" id="target-{{ $data->id }}" value="_blank" @if ($data->target == '_blank') checked @endif class="form-check-input shadow-none">
                                                                                            <label class="form-check-label" for="target-{{ $data->id }}">Open in a new tab</label>
                                                                                        </div>

                                                                                        <div class="mt-2">
                                                                                            <button type="submit" class="btn btn-sm btn-primary">Save</button>

                                                                                            <a href="{{ url('menus/delete-menuitem', [$data->id, $key, $in]) }}" class="btn btn-sm btn-danger">Delete</a>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ol>
                                                        @endif
                                                    </li>
                                                @empty

                                                @endforelse
                                            @endif
                                        </ol>

                                    </div>
                                @endif
                            </div>
                            @if ($desiredMenu != '')
                                <div class="d-flex align-items-center">
                                    <p class="me-3">Display Menu Location:</p>
                                    <div class="form-check">
                                        <input class="form-check-input shadow-none" value="1"  @if ($desiredMenu->location == 1) checked @endif type="checkbox" name="location" id="menu-location">
                                        <label class="form-check-label" for="menu-location">Primary Menu</label>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button class="btn btn-sm btn-primary" id="saveMenu">Save Menu</button>

                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deleteMenu()" data-id="{{ $desiredMenu->id }}">Delete Menu</button>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="serialize_output">
        @if ($desiredMenu)
            {{ $desiredMenu->content }}
        @endif
    </div>

    @if ($desiredMenu)
        <input type="hidden" id="menu_id" value="{{ $desiredMenu->id }}">
    @endif
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>

<script>
    $(document).on('click','#select-all-categories',function(){
        $('#categories-list :checkbox').prop('checked', this.checked);
    });

    $(document).on('click','#select-all-posts',function(){
        $('#posts-list :checkbox').prop('checked', this.checked);
    });

    $(document).on('click','#select-all-department',function(){
        $('#department-list :checkbox').prop('checked', this.checked);
    });

    @if($desiredMenu)
        $(document).on('click','#add-categories',function(){
            var menu_id = $('input#menu_id').val();
            var ids = [];
            $('input[name="select-category[]"]:checked').each(function(){
                ids.push($(this).val());
            });
            if (ids.length == 0) {
                Swal.fire({
                    type:'error',
                    title:'Error',
                    text:'Please checked at least one of categories!',
                    icon: 'warning',
                });
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ route('app.menus.add.categories') }}",
                    data: {
                        _token: _token,
                        menuId: menu_id,
                        ids: ids
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 'success') {
                            notification(response.status,response.message)
                            window.location.reload();
                            updateSerializedOutput();
                        }else{
                            Swal.fire('Oops...', response.message, "error");
                        }
                    },
                    error: function (xhr, ajaxOption, thrownError) {
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                    }
                });
            }
        });

        $(document).on('click','#add-posts',function(){
            var menuId = $('input#menu_id').val();
            var ids = [];
            $('input[name="select-post[]"]:checked').each(function(){
                ids.push($(this).val());
            });

            if (ids.length == 0) {
                Swal.fire({
                    type:'error',
                    title:'Error',
                    text:'Please checked at least one of posts!',
                    icon: 'warning',
                });
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ route('app.menus.add.posts') }}",
                    data: {
                        _token: _token,
                        menuId: menuId,
                        ids: ids
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 'success') {
                            notification(response.status,response.message)
                            window.location.reload();
                            updateSerializedOutput();
                        }else{
                            Swal.fire('Oops...', response.message, "error");
                        }
                    },
                    error: function (xhr, ajaxOption, thrownError) {
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                    }
                });
            }
        });

        $(document).on('click','#add-department',function(){
            var menuId = $('input#menu_id').val();
            var ids = [];
            $('input[name="select-department[]"]:checked').each(function(){
                ids.push($(this).val());
            });

            if (ids.length == 0) {
                Swal.fire({
                    type:'error',
                    title:'Error',
                    text:'Please checked at least one of departments!',
                    icon: 'warning',
                });
            }else{
                $.ajax({
                    type: "POST",
                    url: "{{ route('app.menus.add.departments') }}",
                    data: {
                        _token: _token,
                        menuId: menuId,
                        ids: ids
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.status == 'success') {
                            notification(response.status,response.message)
                            window.location.reload();
                            updateSerializedOutput();
                        }else{
                            Swal.fire('Oops...', response.message, "error");
                        }
                    },
                    error: function (xhr, ajaxOption, thrownError) {
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                    }
                });
            }
        });

        $(document).on('click','#add-custom-link',function(){
            var form = document.getElementById('custom_menu_form');
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                url: "{{ route('app.menus.add.customs') }}",
                data: formData,
                dataType: 'JSON',
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status == false){
                        $('#custom_menu_form').find('.error').remove();
                        $.each(response.data.errors,function(key,value){
                            $('#custom_menu_form #'+key).parent().append('<small class="text-danger error d-block">'+value+'</small>')
                        });
                    }

                    if(response.status == 'success'){
                        notification(response.status,response.message);
                        updateSerializedOutput();
                        window.location.reload();
                    }

                    if(response.status == 'error'){
                        notification(response.status,response.message);
                    }
                }
            });
        });

        $(document).on('click','#saveMenu',function(){
            var menuid = $('input#menu_id').val();
            var location = $('input[name="location"]:checked').val();
            var newText = $("#serialize_output").text();
            var data = JSON.parse($("#serialize_output").text());
            $.ajax({
                type: "POST",
                url: "{{ route('app.menus.update-with.items') }}",
                data: {
                    _token: _token,
                    menuid: menuid,
                    data: data,
                    location: location
                },
                dataType: 'JSON',
                success: function(response) {
                    notification(response.status, response.message);
                    if(response.status == 'success'){
                        setInterval(() => {
                            window.location.reload();
                        }, 1000);
                    }
                }
            })
        });

        function deleteMenu() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure to delete menu?',
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
                        url: url,
                        type: "POST",
                        data: {id:id,_token:_token},
                        dataType: "JSON",
                    }).done(function (response) {
                        if (response.status == "success") {
                            Swal.fire("Deleted", response.message, "success").then(function () {
                                window.location.href = "{{ route('app.menus.index') }}";
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
        }
    @endif

    $(document).ready(function() {
        $('#menuitems').nestable({
            maxDepth: 2 // Adjust this as per your requirement
        }).on('change', function() {
            updateSerializedOutput();
        });
    });

    function updateSerializedOutput() {
        var serialized = $('#menuitems').nestable('serialize');
        $("#serialize_output").text(JSON.stringify(serialized));
        console.log(JSON.stringify(serialized)); // You can send this to your backend if needed
    }
</script>
@endpush
