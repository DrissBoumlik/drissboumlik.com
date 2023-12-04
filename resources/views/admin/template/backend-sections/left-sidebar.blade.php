<!-- Sidebar -->
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header">
        <!-- Logo -->
        <a class="font-semibold text-dual" href="/admin">
            <span class="smini-visible">
                <img class="img-avatar img-avatar20" src="{{ asset('/assets/img/me/circle-256.ico') }}" alt="" width="20" height="20" loading="lazy">
            </span>
            <span class="smini-hide fs-5 tracking-wider">Admin <span class="fw-normal">Panel</span></span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div>
            @include('admin.addons.darkmode')
            <!-- Options -->
{{--            <div class="dropdown d-inline-block ms-1">--}}
{{--                <a class="btn btn-sm btn-alt-secondary" id="sidebar-themes-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">--}}
{{--                    <i class="fa fa-brush"></i>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu dropdown-menu-end fs-sm smini-hide border-0" aria-labelledby="sidebar-themes-dropdown">--}}
{{--                    <!-- Sidebar Styles -->--}}
{{--                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->--}}
{{--                    <a class="dropdown-item fw-medium" data-toggle="layout" data-action="sidebar_style_light" href="javascript:void(0)">--}}
{{--                        <span>Sidebar Light</span>--}}
{{--                    </a>--}}
{{--                    <a class="dropdown-item fw-medium" data-toggle="layout" data-action="sidebar_style_dark" href="javascript:void(0)">--}}
{{--                        <span>Sidebar Dark</span>--}}
{{--                    </a>--}}
{{--                    <!-- END Sidebar Styles -->--}}

{{--                    <div class="dropdown-divider"></div>--}}

{{--                    <!-- Header Styles -->--}}
{{--                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->--}}
{{--                    <a class="dropdown-item fw-medium" data-toggle="layout" data-action="header_style_light" href="javascript:void(0)">--}}
{{--                        <span>Header Light</span>--}}
{{--                    </a>--}}
{{--                    <a class="dropdown-item fw-medium" data-toggle="layout" data-action="header_style_dark" href="javascript:void(0)">--}}
{{--                        <span>Header Dark</span>--}}
{{--                    </a>--}}
{{--                    <!-- END Header Styles -->--}}
{{--                </div>--}}
{{--            </div>--}}
            <!-- END Options -->

            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                <i class="fa fa-fw fa-times"></i>
            </a>
            <!-- END Close Sidebar -->
        </div>
        <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/posts') ? ' active' : '' }}" href="/admin/posts">
                        <i class="nav-main-link-icon fa fa-fw fa-list"></i>
                        <span class="nav-main-link-name">Posts</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/tags') ? ' active' : '' }}" href="/admin/tags">
                        <i class="nav-main-link-icon fa fa-fw fa-tags"></i>
                        <span class="nav-main-link-name">Tags</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/visitors') ? ' active' : '' }}" href="/admin/visitors">
                        <i class="nav-main-link-icon fa fa-fw fa-eye"></i>
                        <span class="nav-main-link-name">Visitors</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/messages') ? ' active' : '' }}" href="/admin/messages">
                        <i class="nav-main-link-icon fa fa-fw fa-envelope"></i>
                        <span class="nav-main-link-name">Messages</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/generate-sitemap') ? ' active' : '' }}" href="/admin/generate-sitemap" target="_blank">
                        <i class="nav-main-link-icon fa fa-fw fa-sitemap"></i>
                        <span class="nav-main-link-name">Generate Sitemap</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('admin/export-db') ? ' active' : '' }}" href="/admin/export-db" target="_blank">
                        <i class="nav-main-link-icon fa fa-fw fa-database"></i>
                        <span class="nav-main-link-name">Export DB</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="/">
                        <i class="nav-main-link-icon fa fa-fw fa-globe"></i>
                        <span class="nav-main-link-name">Site</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="/blog">
                        <i class="nav-main-link-icon fa fa-fw fa-file-lines"></i>
                        <span class="nav-main-link-name">Blog</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
<!-- END Sidebar -->
