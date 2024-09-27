<h3><span>Add Menu Items</span></h3>

<div class="accordion" id="menu-items">
    <div class="accordion-item">
        <div class="accordion-header" id="categories-list">
            <button type="button" class="accordion-button shadow-none py-2" data-bs-toggle="collapse"
                data-bs-target="#category-btn" aria-expanded="true" aria-controls="category-btn">Categories <span
                    class="caret pull-right"></span></button>
        </div>
        <div class="accordion-collapse collapse show" aria-labelledby="categories-list" data-bs-parent="#menu-items"
            id="category-btn">
            <div class="card-body">
                <div class="item-list-body">
                    @foreach($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input shadow-none category-checkbox" type="checkbox" value="{{ $category->id }}"
                            name="select-category[]" id="category-{{ $category->id }}">
                        <label class="form-check-label" for="category-{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="item-list-footer d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input shadow-none" type="checkbox" id="select-all-categories">
                        <label class="form-check-label" for="select-all-categories">Select All</label>
                    </div>

                    <button type="button" class="btn btn-default btn-sm" id="add-categories">Add to Menu</button>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header">
            <button type="button" class="accordion-button shadow-none py-2" data-bs-toggle="collapse"
                data-bs-target="#post-btn" aria-expanded="true" aria-controls="post-btn">Posts <span
                    class="caret pull-right"></span></button>
        </div>
        <div class="accordion-collapse collapse show" aria-labelledby="categories-list" data-bs-parent="#menu-items"
            id="post-btn">
            <div class="card-body">
                <div class="item-list-body">
                    @foreach($posts as $post)
                    <div class="form-check">
                        <input class="form-check-input shadow-none post-checkbox" type="checkbox" value="{{ $post->id }}"
                            name="select-post[]" id="post-{{ $post->id }}">
                        <label class="form-check-label" for="post-{{ $post->id }}">{{ $post->title }}</label>
                    </div>
                    @endforeach
                </div>
                <div class="item-list-footer d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input shadow-none" type="checkbox" id="select-all-posts">
                        <label class="form-check-label" for="select-all-posts">Select All</label>
                    </div>

                    <button type="button" id="add-posts" class="btn btn-default btn-sm">Add to Menu</button>
                </div>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <div class="accordion-header">
            <button type="button" class="accordion-button shadow-none py-2" data-bs-toggle="collapse"
                data-bs-target="#custom-btn" aria-expanded="true" aria-controls="custom-btn">Custom
                Links <span class="caret pull-right"></span></button>
        </div>
        <div class="accordion-collapse collapse show" aria-labelledby="categories-list" data-bs-parent="#menu-items"
            id="custom-btn">
            <div class="card-body">
                <div class="item-list-bodys">
                    <x-form.inputbox labelName="URL" name="url" required="required" />
                    <x-form.inputbox labelName="Link Text" name="link_text" required="required" />
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-default btn-sm" id="add-custom-link">Add to Menu</button>
                </div>
            </div>
        </div>
    </div>
</div>
