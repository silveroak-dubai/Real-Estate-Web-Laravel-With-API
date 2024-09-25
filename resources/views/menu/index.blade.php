@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')
<style>
    .item-list,
    .info-box {
        background: #fff;
        padding: 10px;
    }

    .item-list-body {
        max-height: 300px;
        overflow-y: scroll;
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

    .accordion-header a {
        display: block;
    }

    .form-inline {
        display: inline;
    }

    .form-inline select {
        padding: 4px 10px;
    }

    .btn-menu-select {
        padding: 4px 10px
    }

    .disabled {
        pointer-events: none;
        opacity: 0.7;
    }

    ul {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }

    .menu-item-bar {
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
        width: 75%;
        background: #fff;
        padding: 10px;
        box-sizing: border-box;
        margin-bottom: 5px;
    }

    .input-box .form-control {
        width: 50%
    }

    .menulocation label {
        font-weight: normal;
        display: block;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0 card-title d-flex align-items-center justify-content-between">{{ $title }}</h4>
            </div>
            <div class="card-body">
                <div class="content info-box">
                    @if(count($menus) > 0)
                    Select a menu to edit:
                    <form action="{{ url('manage-menus') }}" class="form-inline">
                        <select name="id">
                            @foreach($menus as $menu)
                            @if($desiredMenu != '')
                            <option value="{{ $menu->id }}" @if($menu->id == $desiredMenu->id) selected
                                @endif>{{ $menu->title }}</option>
                            @else
                            <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                            @endif
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-default btn-menu-select">Select</button>
                    </form>
                    or <a href="{{ url('manage-menus?id=new') }}">Create a new menu</a>.
                    @endif
                </div>

                <div class="row" id="main-row">
                    <div class="col-sm-3 cat-form @if(count($menus) == 0) disabled @endif">
                        <h3><span>Add Menu Items</span></h3>

                        <div class="accordion" id="menu-items">
                            <div class="accordion-item">
                                <div class="accordion-header" id="categories-list">
                                    <button type="button" class="accordion-button shadow-none py-2"
                                        data-bs-toggle="collapse" data-bs-target="#category-btn" aria-expanded="true"
                                        aria-controls="category-btn">Categories <span
                                            class="caret pull-right"></span></button>
                                </div>
                                <div class="accordion-collapse collapse show" aria-labelledby="categories-list"
                                    data-bs-parent="#menu-items" id="category-btn">
                                    <div class="card-body">
                                        <div class="item-list-body">
                                            @foreach($categories as $cat)
                                            <p><input type="checkbox" name="select-category[]" value="{{ $cat->id }}">
                                                {{ $cat->name }}</p>
                                            @endforeach
                                        </div>
                                        <div class="item-list-footer">
                                            <label class="btn btn-sm btn-default"><input type="checkbox"
                                                    id="select-all-categories"> Select All</label>
                                            <button type="button" class="pull-right btn btn-default btn-sm"
                                                id="add-categories">Add to Menu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <button type="button" class="accordion-button shadow-none py-2"
                                        data-bs-toggle="collapse" data-bs-target="#post-btn" aria-expanded="true"
                                        aria-controls="post-btn">Posts <span class="caret pull-right"></span></button>
                                </div>
                                <div class="accordion-collapse collapse show" aria-labelledby="categories-list"
                                    data-bs-parent="#menu-items" id="post-btn">
                                    <div class="card-body">
                                        <div class="item-list-body">
                                            @foreach($posts as $post)
                                            <p><input type="checkbox" name="select-post[]" value="{{ $post->id }}">
                                                {{ $post->title }}</p>
                                            @endforeach
                                        </div>
                                        <div class="item-list-footer">
                                            <label class="btn btn-sm btn-default"><input type="checkbox"
                                                    id="select-all-posts"> Select All</label>
                                            <button type="button" id="add-posts"
                                                class="pull-right btn btn-default btn-sm">Add to Menu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <div class="accordion-header">
                                    <button type="button" class="accordion-button shadow-none py-2"
                                        data-bs-toggle="collapse" data-bs-target="#custom-btn" aria-expanded="true"
                                        aria-controls="custom-btn">Custom
                                        Links <span class="caret pull-right"></span></button>
                                </div>
                                <div class="accordion-collapse collapse show" aria-labelledby="categories-list"
                                    data-bs-parent="#menu-items" id="custom-btn">
                                    <div class="card-body">
                                        <div class="item-list-body">
                                            <x-form.inputbox labelName="URL" name="url" required="required" />
                                            <x-form.inputbox labelName="Link Text" name="link_text"
                                                required="required" />
                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="pull-right btn btn-default btn-sm"
                                                id="add-custom-link">Add to Menu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9 cat-view">
                        <h3><span>Menu Structure</span></h3>
                        @if($desiredMenu == '')
                        <h4>Create New Menu</h4>
                        <form method="post" action="{{ url('create-menu') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-8">
                                    <x-form.inputbox labelName="Name" name="title" placeholder="Enter Menu Name" />
                                </div>
                                <div class="col-sm-4 text-right">
                                    <button class="btn btn-sm btn-primary mt-4">Create Menu</button>
                                </div>
                            </div>
                        </form>
                        @else
                        <div id="menu-content">
                            <p>Select categories, pages or add custom links to menus.</p>
                            <ul class="menu ui-sortable" id="menuitems">
                                @if(!empty($menuitems))
                                @foreach($menuitems as $key=>$item)
                                <li data-id="{{$item->id}}"><span class="menu-item-bar"><i class="fa fa-arrows"></i>
                                        @if(empty($item->name)) {{$item->title}} @else {{$item->name}} @endif <a
                                            href="#collapse{{$item->id}}" class="pull-right" data-toggle="collapse"><i
                                                class="caret"></i></a></span>
                                    <div class="collapse" id="collapse{{$item->id}}">
                                        <div class="input-box">
                                            <form method="post" action="{{url('update-menuitem')}}/{{$item->id}}">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Link Name</label>
                                                    <input type="text" name="name"
                                                        value="@if(empty($item->name)) {{$item->title}} @else {{$item->name}} @endif"
                                                        class="form-control">
                                                </div>
                                                @if($item->type == 'custom')
                                                <div class="form-group">
                                                    <label>URL</label>
                                                    <input type="text" name="slug" value="{{$item->slug}}"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <input type="checkbox" name="target" value="_blank"
                                                        @if($item->target == '_blank') checked @endif> Open in a new tab
                                                </div>
                                                @endif
                                                <div class="form-group">
                                                    <button class="btn btn-sm btn-primary">Save</button>
                                                    <a href="{{url('delete-menuitem')}}/{{$item->id}}/{{$key}}"
                                                        class="btn btn-sm btn-danger">Delete</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <ul>
                                        @if(isset($item->children))
                                        @foreach($item->children as $m)
                                        @foreach($m as $in=>$data)
                                        <li data-id="{{$data->id}}" class="menu-item"> <span class="menu-item-bar"><i
                                                    class="fa fa-arrows"></i> @if(empty($data->name)) {{$data->title}}
                                                @else {{$data->name}} @endif <a href="#collapse{{$data->id}}"
                                                    class="pull-right" data-toggle="collapse"><i
                                                        class="caret"></i></a></span>
                                            <div class="collapse" id="collapse{{$data->id}}">
                                                <div class="input-box">
                                                    <form method="post"
                                                        action="{{url('update-menuitem')}}/{{$data->id}}">
                                                        @csrf
                                                        <div class="form-group">
                                                            <label>Link Name</label>
                                                            <input type="text" name="name"
                                                                value="@if(empty($data->name)) {{$data->title}} @else {{$data->name}} @endif"
                                                                class="form-control">
                                                        </div>
                                                        @if($data->type == 'custom')
                                                        <div class="form-group">
                                                            <label>URL</label>
                                                            <input type="text" name="slug" value="{{$data->slug}}"
                                                                class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="checkbox" name="target" value="_blank"
                                                                @if($data->target == '_blank') checked @endif> Open in a
                                                            new tab
                                                        </div>
                                                        @endif
                                                        <div class="form-group">
                                                            <button class="btn btn-sm btn-primary">Save</button>
                                                            <a href="{{url('delete-menuitem')}}/{{$data->id}}/{{$key}}/{{$in}}"
                                                                class="btn btn-sm btn-danger">Delete</a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <ul></ul>
                                        </li>
                                        @endforeach
                                        @endforeach
                                        @endif
                                    </ul>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        @if($desiredMenu != '')
		<div class="form-group menulocation">
		  <label><b>Menu Location</b></label>
		  <p><label><input type="radio" name="location" value="1" @if($desiredMenu->location == 1) checked @endif> Header</label></p>
		  <p><label><input type="radio" name="location" value="2" @if($desiredMenu->location == 2) checked @endif> Main Navigation</label></p>
		</div>
		<div class="text-right">
		  <button class="btn btn-sm btn-primary" id="saveMenu">Save Menu</button>
		</div>
		<p><a href="{{url('delete-menu')}}/{{$desiredMenu->id}}">Delete Menu</a></p>
	  @endif

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="serialize_output">@if($desiredMenu){{ $desiredMenu->content }}@endif</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
    @if($desiredMenu)
    $('#add-categories').click(function () {
        var menuid = <?= $desiredMenu -> id?>;
        var n = $('input[name="select-category[]"]:checked').length;
        var array = $('input[name="select-category[]"]:checked');
        var ids = [];
        for (i = 0; i < n; i++) {
            ids[i] = array.eq(i).val();
        }
        if (ids.length == 0) {
            return false;
        }
        $.ajax({
            type: "GET",
            data: {
                menuid: menuid,
                ids: ids
            },
            url: "{{ url('add-categories-to-menu') }}",
            success: function (res) {
                window.location.reload();
            }
        })
    });

    $('#add-posts').click(function () {
        var menuid = <?= $desiredMenu ->id ?>;
        var n = $('input[name="select-post[]"]:checked').length;
        var array = $('input[name="select-post[]"]:checked');
        var ids = [];
        for (i = 0; i < n; i++) {
            ids[i] = array.eq(i).val();
        }
        if (ids.length == 0) {
            return false;
        }
        $.ajax({
            type: "GET",
            data: {
                menuid: menuid,
                ids: ids
            },
            url: "{{url('add-post-to-menu')}}",
            success: function (res) {
                window.location.reload();
            }
        })
    });

    $("#add-custom-link").click(function () {
        var menuid = <?= $desiredMenu ->id ?>;
        var url = $('#url').val();
        var link = $('#link_text').val();
        if (url.length > 0 && link.length > 0) {
            $.ajax({
                type: "GET",
                data: {
                    menuid: menuid,
                    url: url,
                    link: link
                },
                url: "{{ url('add-custom-link') }}",
                success: function (res) {
                    window.location.reload();
                }
            });
        }
    });

    $('#saveMenu').click(function(){
        var menuid = <?= $desiredMenu->id ?>;
        var location = $('input[name="location"]:checked').val();
        var newText = $("#serialize_output").text();
        var data = JSON.parse($("#serialize_output").text());
        $.ajax({
            type:"get",
            data: {menuid:menuid,data:data,location:location},
            url: "{{url('update-menu')}}",
            success:function(res){
            window.location.reload();
            }
        })
    });
    @endif

    $("#menuitems").sortable({
        update: function(event, ui) {
            // Get the sorted items as an array of their data-id attributes
            var sortedIDs = $("#menuitems").sortable("toArray", { attribute: 'data-id' });
            // Convert the array to JSON and display it
            var jsonString = JSON.stringify(sortedIDs, null, 2);
            $('#serialize_output').text(jsonString);
        }
    });
</script>
@endpush
