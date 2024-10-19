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
                                                                    <form method="POST" id="menu_item_form{{ $item->id }}">
                                                                        @csrf
                                                                        <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                                                        <x-form.inputbox labelName="Link Name" required="required" name="link_name" value="{{ $item->title ?? '' }}"/>
                                                                        @if($item->type == 'custom')
                                                                        <x-form.inputbox labelName="URL" required="required" name="url" value="{{ $item->slug ?? '' }}"/>
                                                                        @else
                                                                        <div class="mb-3">
                                                                            <label for="url" class="form-label required">URL</label>
                                                                            <div class="position-relative input-icon">
                                                                                <input type="text" class="form-control form-control-sm rounded-0 shadow-none" id="url" name="url" value="{{ $item->slug ?? '' }}">
                                                                                <span class="position-absolute top-50 translate-middle-y">{{ config('app.front_url') }}</span>
                                                                            </div>
                                                                        </div>
                                                                        @endif

                                                                        <x-form.inputbox labelName="Extra Classes" name="classes" value="{{ $item->classes ?? '' }}"/>

                                                                        <div class="form-check">
                                                                            <input type="checkbox" name="target" id="target-{{ $item->id }}" {{ $item->target == "_blank" ? 'checked' : '' }} value="_blank"  class="form-check-input shadow-none">
                                                                            <label class="form-check-label" for="target-{{ $item->id }}">Open in a new tab</label>
                                                                        </div>
                                                                    </form>
                                                                    <div class="mt-2">
                                                                        <button type="button" class="btn btn-sm btn-primary" onclick="menuItemSave({{ $item->id }})">Save</button>

                                                                        <button class="btn btn-sm btn-danger" onclick="deleteItem({{ $item->id }})">Delete</button>
                                                                        <form class="d-none" id="delete_form_{{ $item->id }}" action="{{ url('menus/delete-menuitem', [$item->id, $key]) }}" method="POST">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                        </form>
                                                                    </div>
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
                                                                                    <form method="POST" id="menu_item_form{{ $data->id }}">
                                                                                        @csrf
                                                                                        <input type="hidden" name="menu_item_id" value="{{ $data->id }}">
                                                                                        <x-form.inputbox labelName="Link Name" required="required" name="link_name" value="{{ $data->name ?? $data->title }}"/>

                                                                                        @if($data->type == 'custom')
                                                                                        <x-form.inputbox labelName="URL" required="required" name="url" value="{{ $data->slug ?? '' }}"/>
                                                                                        @else
                                                                                        <div class="mb-3">
                                                                                            <label for="url" class="form-label required">URL</label>
                                                                                            <div class="position-relative input-icon">
                                                                                                <input type="text" class="form-control form-control-sm rounded-0 shadow-none" id="url" name="url" value="{{ $data->slug ?? '' }}">
                                                                                                <span class="position-absolute top-50 translate-middle-y">{{ config('app.front_url') }}</span>
                                                                                            </div>
                                                                                        </div>
                                                                                        @endif

                                                                                        <x-form.inputbox labelName="Extra Classes" name="classes" value="{{ $data->classes ?? '' }}"/>

                                                                                        <div class="form-check">
                                                                                            <input type="checkbox" name="target" id="target-{{ $data->id }}" value="_blank" @if ($data->target == '_blank') checked @endif class="form-check-input shadow-none">
                                                                                            <label class="form-check-label" for="target-{{ $data->id }}">Open in a new tab</label>
                                                                                        </div>
                                                                                    </form>
                                                                                    <div class="mt-2">
                                                                                        <button type="buttion" class="btn btn-sm btn-primary" onclick="menuItemSave({{ $data->id }})">Save</button>

                                                                                        <button class="btn btn-sm btn-danger" onclick="deleteItem({{ $data->id }})">Delete</button>
                                                                                        <form class="d-none" id="delete_form_{{ $data->id }}" action="{{ url('menus/delete-menuitem', [$data->id, $key, $in]) }}" method="POST">
                                                                                            @csrf
                                                                                            @method('DELETE')
                                                                                        </form>
                                                                                    </div>
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
