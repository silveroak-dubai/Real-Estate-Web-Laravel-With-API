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
                    <div class="parent-icon"><i class="material-icons-outlined">home</i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            @endpermission

            @permission('user-access')
            <li class="{{ request()->is('users*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.users.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">group</i>
                    </div>
                    <div class="menu-title">Users</div>
                </a>
            </li>
            @endpermission

            @permission('blog-access')
            <li class="{{ request()->is('blogs*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.blogs.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">group</i>
                    </div>
                    <div class="menu-title">Blogs</div>
                </a>
            </li>
            @endif

            @permission('our-bank-access')
            <li class="{{ request()->is('our-banks*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.our-banks.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">group</i>
                    </div>
                    <div class="menu-title">Our Banks</div>
                </a>
            </li>
            @endpermission

            @if (permission('faq-access'))
            <li class="{{ request()->is('faqs*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.faqs.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">group</i>
                    </div>
                    <div class="menu-title">Faqs</div>
                </a>
            </li>
            @endif

            @if (permission('achievement-access'))
            <li class="{{ request()->is('achievements*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.achievements.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">group</i>
                    </div>
                    <div class="menu-title">Achievements</div>
                </a>
            </li>
            @endif

            @if (permission('our-partner-access'))
            <li class="{{ request()->is('our-partners*') ? 'mm-active' : '' }}">
                <a href="{{ route('app.our-partners.index') }}">
                    <div class="parent-icon"><i class="material-icons-outlined">group</i>
                    </div>
                    <div class="menu-title">Our Parners</div>
                </a>
            </li>
            @endif

            @if (permission('team-language-access') || permission('team-specialized-access') || permission('our-team-access'))
            <li class="{{ request()->is('team-languages*') || request()->is('team-specializeds*') || request()->is('our-teams*') ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="material-icons-outlined">widgets</i>
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

            <li class="menu-label">UI Elements</li>

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
