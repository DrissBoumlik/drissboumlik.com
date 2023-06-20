<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="d-flex align-items-center">
            <!-- Logo -->
            <a class="fw-semibold fs-5 tracking-wider text-dual me-3" href="/">
                <span class="fw-normal">Driss Boumlik</span>
            </a>
            <!-- END Logo -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center">
            <!-- Menu -->
            <div class="d-none d-lg-block">
                <ul class="nav-main nav-main-horizontal nav-main-hover">
                    @if (\Auth::check())
                    <li class="nav-main-item">
                        <a class="nav-main-link" href="/admin">
                            <span class="nav-main-link-name">Admin Panel</span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('') ? 'active' : '' }}" href="/">
                            <span class="nav-main-link-name">Home</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('blog') ? 'active' : '' }}" href="/blog">
                            <span class="nav-main-link-name">Blog</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('about') ? 'active' : '' }}" href="/about">
                            <span class="nav-main-link-name">About</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                        <a class="nav-main-link {{ request()->is('resume') ? 'active' : '' }}" href="/resume" target="_blank">
                            <span class="nav-main-link-name">Resume</span>
                        </a>
                    </li>
                    <li class="nav-main-item">
                            <!-- Dark Mode -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <a class="nav-main-link btn btn-sm btn-alt-secondary toggle-dark-mode-blog" data-toggle="layout" data-action="dark_mode_toggle" href="javascript:void(0)">
                                <i class="far fa-moon"></i>
                            </a>
                            <!-- END Dark Mode -->
                    </li>
                </ul>
            </div>
            <!-- END Menu -->

            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none ms-1" data-toggle="layout"
                    data-action="sidebar_toggle">
                <i class="fa fa-fw fa-bars"></i>
            </button>
            <!-- END Toggle Sidebar -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Search -->
    <div id="page-header-search" class="overlay-header bg-body-extra-light">
        <div class="content-header">
            <form class="w-100" method="POST">
                <div class="input-group input-group-sm">
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <button type="button" class="btn btn-alt-danger" data-toggle="layout"
                            data-action="header_search_off">
                        <i class="fa fa-fw fa-times-circle"></i>
                    </button>
                    <input type="text" class="form-control" placeholder="Search or hit ESC.."
                           id="page-header-search-input" name="page-header-search-input">
                </div>
            </form>
        </div>
    </div>
    <!-- END Header Search -->

    <!-- Header Loader -->
    <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
    <div id="page-header-loader" class="overlay-header bg-primary-lighter">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-circle-notch fa-spin text-primary"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
<!-- END Header -->
