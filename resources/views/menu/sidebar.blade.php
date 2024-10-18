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

                                <button type="button" class="border-0 bg-transparent text-success"
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
                                    <label class="form-check-label" for="post-{{ $post->id }}">{{ $post->title }}</label>
                                </div>
                                @endforeach
                            </div>

                            <div class="item-list-footer d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" id="select-all-posts">
                                    <label class="form-check-label" for="select-all-posts">Select All</label>
                                </div>

                                <button type="button" class="border-0 bg-transparent text-success"
                                    id="add-posts">Add to Menu</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button py-2 shadow-none" type="button" data-bs-toggle="collapse"
                        data-bs-target="#department-collapse" aria-expanded="false" aria-controls="department-collapse">
                        Departments
                    </button>
                </h2>
                <div id="department-collapse" class="accordion-collapse collapse show" data-bs-parent="#menu-items">
                    <div class="accordion-body">
                        <div id="department-list">
                            <div class="item-list-body">
                                @foreach ($departments as $department)
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" value="{{ $department->id }}" name="select-department[]" id="department-{{ $department->id }}">
                                    <label class="form-check-label" for="department-{{ $department->id }}">{{ $department->name }}</label>
                                </div>
                                @endforeach
                            </div>

                            <div class="item-list-footer d-flex align-items-center justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" id="select-all-department">
                                    <label class="form-check-label" for="select-all-department">Select All</label>
                                </div>

                                <button type="button" class="border-0 bg-transparent text-success"
                                    id="add-department">Add to Menu</button>
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
                        <div id="custom-links">
                            <form method="POST" id="custom_menu_form">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $desiredMenu->id }}">
                                <x-form.inputbox labelName="URL" name="url" required="required" placeholder="https://"/>
                                <x-form.inputbox labelName="Link Text" name="link_text" required="required" placeholder="Enter Text"/>
                            </form>
                            <button type="button" class="border-0 bg-transparent text-success float-end"  id="add-custom-link">Add to Menu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
