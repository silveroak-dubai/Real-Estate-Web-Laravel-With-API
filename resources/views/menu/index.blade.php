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
            min-height: 40px;
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
        <div class="col-md-3 cat-form @if (request()->get('id') == 'new') disabled @endif">
            <div class="card rounded-0">
                <div class="card-header">
                    <h4 class="mb-0 card-titlw">Add Menu Items</h4>
                </div>
                <div class="card-body">
                    <div class="accordion" id="menu-items">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button py-2 shadow-none" type="button" data-bs-toggle="collapse"
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
                                                <input class="form-check-input shadow-none" type="checkbox" value="{{ $cat->id }}" name="select-category[]" id="category-{{ $cat->id }}">
                                                <label class="form-check-label" for="category-{{ $cat->id }}">{{ $cat->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="item-list-footer d-flex align-items-center justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input shadow-none" type="checkbox" id="select-all-categories">
                                                <label class="form-check-label" for="select-all-categories">Select All</label>
                                            </div>

                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                id="add-categories">Add to Menu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button py-2 shadow-none" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Posts
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#menu-items">
                                <div class="accordion-body">
                                    <div id="posts-list">
                                        <div class="item-list-body">
                                            @foreach ($posts as $post)
                                            <div class="form-check">
                                                <input class="form-check-input shadow-none" type="checkbox" value="{{ $post->id }}" name="select-post[]" id="post-{{ $post->id }}">
                                                <label class="form-check-label" for="post-{{ $post->id }}">{{ $post->name }}</label>
                                            </div>
                                            @endforeach
                                        </div>

                                        <div class="item-list-footer d-flex align-items-center justify-content-between">
                                            <div class="form-check">
                                                <input class="form-check-input shadow-none" type="checkbox" id="select-all-posts">
                                                <label class="form-check-label" for="select-all-posts">Select All</label>
                                            </div>

                                            <button type="button" class="btn btn-sm btn-outline-success"
                                                id="add-posts">Add to Menu</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button py-2 shadow-none" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Custom Links
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#menu-items">
                                <div class="accordion-body pb-5">
                                    <div class="" id="custom-links">
                                        <x-form.inputbox labelName="URL" name="url" required="required" placeholder="https://"/>
                                        <x-form.inputbox labelName="Link Text" name="linktext" required="required" placeholder="Enter Text"/>

                                        <button type="button" class="btn btn-sm btn-outline-success float-end"  id="add-custom-link">Add to Menu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 cat-view">
            <div class="card rounded-0">
                <div class="card-header">
                    <h4 class="card-title mb-0">Menu Structure</h4>
                </div>
                <div class="card-body">
                    @if (empty($desiredMenu))
                        <h4>Create New Menu</h4>
                        <form method="post" action="{{ route('app.menus.store') }}">
                            @csrf
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
                            <div class="mb-3">
                                <p>Select categories, pages or add custom links to menus.</p>
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
                url: "{{ route('app.menus.add.categories') }}",
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
                url: "{{ route('app.menus.add.posts') }}",
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
                    url: "{{ route('app.menus.add.customs') }}",
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
                url: "{{ route('app.menus.update-with.items') }}",
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
