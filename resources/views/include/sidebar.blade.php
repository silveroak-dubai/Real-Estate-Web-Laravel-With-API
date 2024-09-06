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
            <li class="{{ request()->is('dashboard') ? 'mm-active' : '' }}">
                <a href="{{ route('app.dashboard') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>

            @if(permission('user-access'))
            <li class="{{ request()->is('users*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.users.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">group</i>
                    </div>
                    <div class="menu-title">Users</div>
                </a>
            </li>
            @endif

            @if (permission('blog-access'))
            <li class="{{ request()->is('blogs*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.blogs.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">group</i>
                    </div>
                    <div class="menu-title">Blogs</div>
                </a>
            </li>
            @endif
            
            {{-- <li class="mm-active">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="material-icons-outlined">widgets</i>
                    </div>
                    <div class="menu-title">Widgets</div>
                </a>
                <ul class="mm-collapse mm-show">
                    <li class="mm-active"><a href="widgets-data.html"><i class="material-icons-outlined">arrow_right</i>Data</a>
                    </li>
                    <li><a href="widgets-advance.html"><i class="material-icons-outlined">arrow_right</i>Advance</a>
                    </li>
                </ul>
            </li> --}}
            <li class="menu-label">UI Elements</li>
            <li>
                <a href="javascrpt:;">
                    <div class="parent-icon"><i class="material-icons-outlined">support</i>
                    </div>
                    <div class="menu-title">Support</div>
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
