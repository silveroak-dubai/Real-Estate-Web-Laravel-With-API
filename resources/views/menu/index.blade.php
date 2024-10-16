@extends('layouts.app')

@section('title',$siteTitle)
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css">

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
            /* width: 75%; */
            background: #fff;
            padding: 10px;
            box-sizing: border-box;
            margin-bottom: 5px;
            border: 1px solid #ddd;
            border-top: 0;
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
            margin: 0;
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
            min-height: 40px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h2><span>Menus</span></h2>

            <div class="content info-box">
                @if (count($menus) > 0)
                    Select a menu to edit:
                    <form action="{{ url('manage-menus') }}" class="form-inline">
                        <select name="id">
                            @foreach ($menus as $menu)
                                @if ($desiredMenu != '')
                                    <option value="{{ $menu->id }}" @if ($menu->id == $desiredMenu->id) selected @endif>
                                        {{ $menu->title }}</option>
                                @else
                                    <option value="{{ $menu->id }}">{{ $menu->title }}</option>
                                @endif
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary btn-menu-select">Select</button>
                    </form>
                    or <a href="{{ url('manage-menus?id=new') }}">Create a new menu</a>.
                @endif
            </div>
        </div>
    </div>

    <div class="row" id="main-row">
        <div class="col-md-3 cat-form @if (count($menus) == 0) disabled @endif">
            <div class="accordion " id="menu-items">
                <div class="accordion-item rouned-0">
                    <h2 class="accordion-header rouned-0">
                        <button class="accordion-button rouned-0" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Categories
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#menu-items">
                        <div class="accordion-body">
                            <div class="collapse show" id="categories-list">
                                <div class="item-list-body">
                                    @foreach ($categories as $cat)
                                        <div class="form-check">
                                            <input class="form-check-input" value="{{ $cat->id }}"
                                                name="select-category[]" type="checkbox" value=""
                                                id="category-id-{{ $cat->id }}">
                                            <label class="form-check-label" for="category-id-{{ $cat->id }}">
                                                {{ $cat->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="item-list-footer">
                                    <label class="btn btn-sm btn-secondary"><input class="form-check-input"
                                            type="checkbox" id="select-all-categories"> Select All</label>
                                    <button type="button" class="btn btn-sm btn-secondary float-end"
                                        id="add-categories">Add to Menu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Posts
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#menu-items">
                        <div class="accordion-body">
                            <div id="posts-list">
                                <div class="item-list-body">
                                    @foreach ($posts as $post)
                                        <div class="form-check">
                                            <input class="form-check-input" value="{{ $post->id }}"
                                                name="select-post[]" type="checkbox" value=""
                                                id="post-id-{{ $post->id }}">
                                            <label class="form-check-label" for="post-id-{{ $post->id }}">
                                                {{ $post->title }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="item-list-footer">
                                    <label class="btn btn-sm btn-secondary"><input class="form-check-input"
                                            type="checkbox" id="select-all-posts">
                                        Select All</label>
                                    <button type="button" id="add-posts" class="btn btn-sm btn-secondary float-end">Add
                                        to
                                        Menu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Custom Links
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#menu-items">
                        <div class="accordion-body pb-5">
                            <div class="" id="custom-links">
                                <div class="mb-3">
                                    <label for="url">URL</label>
                                    <input type="url" id="url" class="form-control"
                                        placeholder="https://">
                                </div>
                                <div class="mb-3">
                                    <label for="linktext">Link Text</label>
                                    <input type="text" id="linktext" class="form-control">
                                </div>
                                <button type="button" class="btn btn-sm btn-secondary float-end"  id="add-custom-link">Add to Menu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 cat-view">
            <div class="card rounded-0">
                <div class="card-header bg-white py-2">
                    <h4 class="card-title mb-0">Menu Structure</h4>
                </div>
                <div class="card-body">
                    @if ($desiredMenu == '')
                        <h4>Create New Menu</h4>
                        <form method="post" action="{{ url('create-menu') }}">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-12">
                                    <label>Name</label>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <button class="btn btn-sm btn-primary">Create Menu</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div id="menu-content">
                            <div id="result"></div>
                            <div style="min-height: 240px;">
                                <p>Select categories, pages or add custom links to menus.</p>
                                @if ($desiredMenu != '')
                                    <div class="dd" id="menuitems">
                                        <ol class="dd-list">
                                            @if (!empty($menuitems))
                                                @foreach ($menuitems as $key => $item)
                                                    <li class="dd-item mt-2" data-id="{{ $item->id ?? '' }}">
                                                        <div class="dd-handle border rouned-0 border-end-0 float-start" style="width: 92%">
                                                            <i class="fa fa-arrows-alt"></i>
                                                                {{ $item->title ?? '' ?? '' }}
                                                        </div>
                                                        <a href="#collapse{{ $item->id ?? '' }}" style="width: 8%"
                                                            class="px-3 py-2 border float-end"
                                                            data-bs-toggle="collapse"><i
                                                                class="fa fa-caret-down"></i> </a>

                                                        <div class="collapse" id="collapse{{ $item->id ?? '' }}">
                                                            <div class="input-box">
                                                                <form method="post"
                                                                    action="{{ url('update-menuitem') }}/{{ $item->id ?? '' }}">
                                                                    {{ csrf_field() }}
                                                                    <div class="form-group">
                                                                        <label>Link Name</label>
                                                                        <input type="text" name="name"
                                                                            value="{{ $item->title ?? '' }}"
                                                                            class="form-control">
                                                                    </div>
                                                                    @if ($item->type == 'custom')
                                                                        <div class="form-group">
                                                                            <label>URL</label>
                                                                            <input type="text" name="slug"
                                                                                value="{{ $item->slug ?? '' }}"
                                                                                class="form-control">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <input type="checkbox" name="target"
                                                                                value="_blank"
                                                                                @if ($item->target == '_blank') checked @endif>
                                                                            Open in a new tab
                                                                        </div>
                                                                    @endif
                                                                    <div class="form-group">
                                                                        <button
                                                                            class="btn btn-sm btn-primary">Save</button>
                                                                        <a href="{{ url('delete-menuitem') }}/{{ $item->id ?? '' }}/{{ $key }}"
                                                                            class="btn btn-sm btn-danger">Delete</a>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        @if (isset($item->children))
                                                            <ol class="dd-list mt-2">
                                                                @foreach ($item->children as $in => $data)
                                                                    {{-- @foreach ($m as $in => $data) --}}
                                                                    <li class="dd-item" data-id="{{ $data->id }}">
                                                                        <div class="dd-handle border float-start" style="width: 90%">
                                                                            <i class="fa fa-arrows-alt"></i>
                                                                            {{ $data->name ?? $data->title }}

                                                                        </div>
                                                                        <a href="#collapse{{ $data->id }}" style="width: 10%"
                                                                            class="px-3 py-2 border-start float-end"
                                                                            data-bs-toggle="collapse"><i
                                                                                class="fa fa-caret-down"></i> </a>

                                                                        <div class="collapse"
                                                                            id="collapse{{ $data->id }}">
                                                                            <div class="input-box">
                                                                                <form method="post"
                                                                                    action="{{ url('update-menuitem') }}/{{ $data->id }}">
                                                                                    {{ csrf_field() }}
                                                                                    <div class="form-group">
                                                                                        <label>Link Name</label>
                                                                                        <input type="text"
                                                                                            name="name"
                                                                                            value="{{ $data->name ?? $data->title }}"
                                                                                            class="form-control">
                                                                                    </div>
                                                                                    @if ($data->type == 'custom')
                                                                                        <div class="form-group">
                                                                                            <label>URL</label>
                                                                                            <input type="text"
                                                                                                name="slug"
                                                                                                value="{{ $data->slug }}"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <input type="checkbox"
                                                                                                name="target"
                                                                                                value="_blank"
                                                                                                @if ($data->target == '_blank') checked @endif>
                                                                                            Open in a new tab
                                                                                        </div>
                                                                                    @endif
                                                                                    <div class="form-group">
                                                                                        <button
                                                                                            class="btn btn-sm btn-primary">Save</button>
                                                                                        <a href="{{ url('delete-menuitem') }}/{{ $data->id }}/{{ $key }}/{{ $in }}"
                                                                                            class="btn btn-sm btn-danger">Delete</a>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    {{-- @endforeach --}}
                                                                @endforeach
                                                            </ol>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ol>
                                    </div>
                                @endif
                            </div>
                            @if ($desiredMenu != '')
                                <div class="row">
                                    <div class="col-md-4">
                                        <p><i>Display location</i></p>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="form-check">
                                                <input type="radio" name="location" class="form-check-input"
                                                    value="2" @if ($desiredMenu->location == 1) checked @endif>
                                                <span class="form-check-label">
                                                    Header
                                                </span>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-check">
                                                <input type="radio" name="location" class="form-check-input"
                                                    value="2" @if ($desiredMenu->location == 2) checked @endif>
                                                <span class="form-check-label">
                                                    Main Navigation
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-sm btn-primary" id="saveMenu">Save Menu</button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="document.getElementById('deleteMenu').submit()">Delete Menu</button>
                                    <form id="deleteMenu" action="{{ url('delete-menu') }}/{{ $desiredMenu->id }}"
                                        method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
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
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>

<script>
    $('#select-all-categories').click(function(event) {
        $('#categories-list :checkbox').prop('checked', this.checked);
    });

    $('#select-all-posts').click(function(event) {
        $('#posts-list :checkbox').prop('checked', this.checked);
    });
</script>

@if ($desiredMenu)
    <script>
        $('#add-categories').click(function() {
            var menuid = "{{ $desiredMenu->id }}";
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
                type: "get",
                data: {
                    menuid: menuid,
                    ids: ids
                },
                url: "{{ url('add-categories-to-menu') }}",
                success: function(res) {
                    location.reload();
                    updateSerializedOutput();
                }
            });
        });

        $('#add-posts').click(function() {
            var menuid = "{{ $desiredMenu->id }}";
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
                type: "get",
                data: {
                    menuid: menuid,
                    ids: ids
                },
                url: "{{ url('add-post-to-menu') }}",
                success: function(res) {
                    location.reload();
                    updateSerializedOutput();
                }
            });
        });

        $("#add-custom-link").click(function() {
            var menuid = "{{ $desiredMenu->id }}";
            var url = $('#url').val();
            var link = $('#linktext').val();
            if (url.length > 0 && link.length > 0) {
                $.ajax({
                    type: "get",
                    data: {
                        menuid: menuid,
                        url: url,
                        link: link
                    },
                    url: "{{ url('add-custom-link') }}",
                    success: function(res) {
                        location.reload();
                        updateSerializedOutput();
                    }
                });
            }
        });

        $('#saveMenu').click(function() {
            var menuid = "{{ $desiredMenu->id }}";
            var location = $('input[name="location"]:checked').val();
            var newText = $("#serialize_output").text();
            var data = JSON.parse($("#serialize_output").text());
            $.ajax({
                type: "get",
                data: {
                    menuid: menuid,
                    data: data,
                    location: location
                },
                url: "{{ url('update-menu') }}",
                success: function(res) {
                    window.location.reload();
                }
            })
        })
    </script>
@endif

<script>
    $(document).ready(function() {
        $('#menuitems').nestable({
            maxDepth: 3 // Adjust this as per your requirement
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
