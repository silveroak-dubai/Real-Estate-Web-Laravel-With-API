@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')
<style>
    .item-list,
    .info-box {
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
                                <option value="">Select Menu</option>
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
                        @include('menu.sidebar')
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
                                <div class="dd">
                                    <ol class="menu dd-list" id="menuitems">
                                        @if(!empty($menuitems))
                                            @foreach($menuitems as $key=>$item)
                                            <li data-id="{{$item->id}}" class="dd-item"><span class="menu-item-bar dd-handle"><i class="fa fa-arrows"></i>
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
                                    </ol>
                                </div>
                            </div>
                            @if($desiredMenu != '')
                                <div class="form-group menulocation">
                                    <label><b>Menu Location</b></label>
                                    <div class="form-check">
                                        <input class="form-check-input shadow-none" type="radio" name="location" id="location" {{ $desiredMenu->location == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="location">Header</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input shadow-none" type="radio" name="location" id="location2" {{ $desiredMenu->location == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="location2">Main Navigation</label>
                                    </div>


                                </div>
                                <div class="text-right">
                                    <button class="btn btn-sm btn-primary" id="saveMenu">Save Menu</button>
                                </div>
                                <p><a href="{{ url('delete-menu') }}/{{ $desiredMenu->id }}">Delete Menu</a></p>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js"></script>
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
            var menuid = "{{ $desiredMenu->id }}";
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

    $('.dd').nestable({
        maxDepth: 3 // Adjust this as per your requirement
    }).on('change', function() {
        var serialized = $('.dd').nestable('serialize');
        $("#serialize_output").text(JSON.stringify(serialized, null, 2));
        console.log(JSON.stringify(serialized)); // You can send this to your backend if needed
    });

    // check all categories
    $(document).on('click','#select-all-categories',function(){
        if(this.checked){
            $('.category-checkbox').each(function () {
                this.checked = true;
            });
        }else{
            $('.category-checkbox').each(function () {
                this.checked = false;
            });
        }
    });

    // check all posts
    $(document).on('click','#select-all-post',function(){
        if(this.checked){
            $('.post-checkbox').each(function () {
                this.checked = true;
            });
        }else{
            $('.post-checkbox').each(function () {
                this.checked = false;
            });
        }
    });
</script>
@endpush
