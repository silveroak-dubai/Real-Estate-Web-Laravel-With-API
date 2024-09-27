<aside class="sidebar-wrapper">
    <div class="sidebar-header">
        <div class="logo-icon">
            <img src="assets/images/logo-icon.png" class="logo-img" alt="">
        </div>
        <div class="logo-name flex-grow-1">
            <h5 class="mb-0">Metoxi</h5>
        </div>
        <div class="sidebar-close">
            <span class="material-icons-outlined">close</span>
        </div>
    </div>
    <div class="sidebar-nav" data-simplebar="true">
        <!--navigation-->
        <ul class="metismenu" id="sidenav">
            @permission('dashboard-access')
            <li class="{{ request()->is('dashboard') ? 'mm-active' : '' }}">
                <a href="{{ route('app.dashboard') }}">
                    <div class="parent-icon"><i class="fa fa-tachometer"></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            @endpermission

            @permission('user-access')
            <li class="{{ request()->is('users*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.users.index') }}">
                    <div class="parent-icon"><i class="fa fa-user"></i>
                    </div>
                    <div class="menu-title">Users</div>
                </a>
            </li>
            @endpermission

            @permission('blog-access')
            <li class="{{ request()->is('posts*') ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fa fa-tag"></i>
                    </div>
                    <div class="menu-title">Posts</div>
                </a>
                <ul class="mm-collapse {{ request()->is('posts*') ? 'mm-show' : '' }}">
                    @permission('blog-access')
                    <li class="{{ request()->is('posts/categories') ? 'mm-active' : '' }}">
                        <a href="{{ route('app.posts.categories.index') }}"><i class="material-icons-outlined">arrow_right</i>Categories</a>
                    </li>
                    @endpermission
                    @permission('blog-access')
                    <li class="{{ request()->is('posts') ? 'mm-active' : '' }}">
                        <a href="{{ route('app.posts.index') }}"><i class="material-icons-outlined">arrow_right</i>Posts</a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endpermission

            @permission('our-bank-access')
            <li class="{{ request()->is('our-banks*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.our-banks.index') }}">
                    <div class="parent-icon"><i class="fa fa-university"></i>
                    </div>
                    <div class="menu-title">Our Banks</div>
                </a>
            </li>
            @endpermission

            @if (permission('faq-access'))
            <li class="{{ request()->is('faqs*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.faqs.index') }}">
                    <div class="parent-icon"><i class="fa fa-question-circle"></i>
                    </div>
                    <div class="menu-title">FAQs</div>
                </a>
            </li>
            @endif

            @if (permission('achievement-access'))
            <li class="{{ request()->is('achievements*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.achievements.index') }}">
                    <div class="parent-icon"><i class="fa fa-trophy"></i>
                    </div>
                    <div class="menu-title">Achievements</div>
                </a>
            </li>
            @endif

            @if (permission('our-partner-access'))
            <li class="{{ request()->is('our-partners*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.our-partners.index') }}">
                    <div class="parent-icon"><i class="fa fa-user-circle"></i>
                    </div>
                    <div class="menu-title">Our Parners</div>
                </a>
            </li>
            @endif

            @if (permission('team-language-access') || permission('team-specialized-access') || permission('our-team-access'))
            <li class="{{ request()->is('team-languages*') || request()->is('team-specializeds*') || request()->is('our-teams*') ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fa fa-users"></i>
                    </div>
                    <div class="menu-title">Our Team</div>
                </a>
                <ul class="mm-collapse {{ request()->is('team-languages*') || request()->is('team-specializeds*') || request()->is('our-teams*') ? 'mm-show' : '' }}">
                    @permission('team-language-access')
                    <li class="{{ request()->is('team-languages*') ? 'mm-active' : '' }}">
                        <a href="{{ route('app.team-languages.index') }}"><i class="material-icons-outlined">arrow_right</i>Team Language</a>
                    </li>
                    @endpermission
                    @permission('team-specialized-access')
                    <li class="{{ request()->is('team-specializeds*') ? 'mm-active' : '' }}">
                        <a href="{{ route('app.team-specializeds.index') }}"><i class="material-icons-outlined">arrow_right</i>Team Specialized</a>
                    </li>
                    @endpermission
                    @permission('our-team-access')
                    <li class="{{ request()->is('our-teams*') ? 'mm-active' : '' }}">
                        <a href="{{ route('app.our-teams.index') }}"><i class="material-icons-outlined">arrow_right</i>Team Member</a>
                    </li>
                    @endpermission
                </ul>
            </li>
            @endif

            <li class="{{ request()->is('settings*') ? 'mm-active' : '' }}">
                <a href="#">
                    <div class="parent-icon"><i class="fa fa-commenting-o"></i>
                    </div>
                    <div class="menu-title">Testimonials</div>
                </a>
            </li>

            <li class="">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="fa fa-paint-brush"></i>
                    </div>
                    <div class="menu-title">Appearance</div>
                </a>
                <ul class="mm-collapse">
                    <li class="">
                        <a href="{{ route('app.menu.index') }}"><i class="material-icons-outlined">arrow_right</i>Menus</a>
                    </li>
                    <li class="">
                        <a href="#"><i class="material-icons-outlined">arrow_right</i>Widgets</a>
                    </li>
                    <li class="">
                        <a href="#"><i class="material-icons-outlined">arrow_right</i>Customize</a>
                    </li>
                </ul>
            </li>

            <li class="{{ request()->is('settings*') ? 'mm-active' : '' }}">
                <a href="#">
                    <div class="parent-icon"><i class="fa fa-list-alt"></i>
                    </div>
                    <div class="menu-title">List Leads</div>
                </a>
            </li>

            {{-- <li class="menu-label">BACKEND</li> --}}
            <li class="{{ request()->is('settings*') ? 'mm-active' : '' }}">
                <a href="#">
                    <div class="parent-icon"><i class="fa fa-user-secret"></i>
                    </div>
                    <div class="menu-title">Careers</div>
                </a>
            </li>

            <li class="{{ request()->is('settings*') ? 'mm-active' : '' }}">
                <a href="#">
                    <div class="parent-icon"><i class="fa fa-cogs"></i>
                    </div>
                    <div class="menu-title">Settings</div>
                </a>
            </li>

        </ul>
        <!--end navigation-->
    </div>


    <div class="sidebar-bottom gap-4">
        <div class="dark-mode">
            <a href="javascript:;" class="footer-icon dark-mode-icon">
                <i class="material-icons-outlined">dark_mode</i>
            </a>
        </div>
    </div>
</aside>
