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
        <div class="d-flex align-items-center gap-2">
            @include('admin.addons.toggle-header')
            @include('admin.addons.darkmode')
            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-alt-secondary" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
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
                <li class="nav-main-item{{ request()->is(['admin/posts', 'admin/posts/*',
                                        'admin/tags', 'admin/tags/*',
                                        'admin/file-manager', 'admin/file-manager/*']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-fw fa-cube"></i>
                        <span class="nav-main-link-name">Content Management</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/posts', 'admin/posts/*') ? ' active' : '' }}" href="/admin/posts">
                                <i class="nav-main-link-icon fa fa-fw fa-list"></i>
                                <span class="nav-main-link-name">Posts</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/tags', 'admin/tags/*') ? ' active' : '' }}" href="/admin/tags">
                                <i class="nav-main-link-icon fa fa-fw fa-tags"></i>
                                <span class="nav-main-link-name">Tags</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/file-manager', 'admin/file-manager/*') ? ' active' : '' }}" href="/admin/file-manager">
                                <i class="nav-main-link-icon fa fa-fw fa-images"></i>
                                <span class="nav-main-link-name">File Manager</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="/blog">
                                <i class="nav-main-link-icon fa fa-fw fa-file-lines"></i>
                                <span class="nav-main-link-name">Blog</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-item{{ request()->is(['admin/visitors', 'admin/visitors/charts', 'admin/messages', 'admin/subscriptions']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-fw fa-user-group"></i>
                        <span class="nav-main-link-name">User Interaction and Analytics</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/visitors') ? ' active' : '' }}" href="/admin/visitors">
                                <i class="nav-main-link-icon fa fa-fw fa-eye"></i>
                                <span class="nav-main-link-name">Visitors</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/visitors/charts') ? ' active' : '' }}" href="/admin/visitors/charts">
                                <i class="nav-main-link-icon fa fa-fw fa-chart-simple"></i>
                                <span class="nav-main-link-name">Visitors charts</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/messages') ? ' active' : '' }}" href="/admin/messages">
                                <i class="nav-main-link-icon fa fa-fw fa-envelope"></i>
                                <span class="nav-main-link-name">Messages</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/subscriptions') ? ' active' : '' }}" href="/admin/subscriptions">
                                <i class="nav-main-link-icon fa fa-fw fa-newspaper"></i>
                                <span class="nav-main-link-name">Subscriptions</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-item{{ request()->is(['admin/services', 'admin/projects', 'admin/testimonials']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-fw fa-business-time"></i>
                        <span class="nav-main-link-name">Portfolio</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/services') ? ' active' : '' }}" href="/admin/services">
                                <i class="nav-main-link-icon fa fa-fw fa-trowel"></i>
                                <span class="nav-main-link-name">Services</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/projects') ? ' active' : '' }}" href="/admin/projects">
                                <i class="nav-main-link-icon fa fa-fw fa-briefcase"></i>
                                <span class="nav-main-link-name">Projects</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/testimonials') ? ' active' : '' }}" href="/admin/testimonials">
                                <i class="nav-main-link-icon fa fa-fw fa-comments"></i>
                                <span class="nav-main-link-name">Testimonials</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-item{{ request()->is(['admin/shortened-urls', 'admin/menus', 'admin/menu-types', 'admin/sitemap', 'admin/export-db/config']) ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-fw fa-sitemap"></i>
                        <span class="nav-main-link-name">Site Management</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/menus') ? ' active' : '' }}" href="/admin/menus">
                                <i class="nav-main-link-icon fa fa-fw fa-bars"></i>
                                <span class="nav-main-link-name">Menus</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/menu-types') ? ' active' : '' }}" href="/admin/menu-types">
                                <i class="nav-main-link-icon fa fa-fw fa-bars"></i>
                                <span class="nav-main-link-name">Menu Types</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/shortened-urls') ? ' active' : '' }}" href="/admin/shortened-urls">
                                <i class="nav-main-link-icon fa fa-fw fa-link"></i>
                                <span class="nav-main-link-name">Shortened Urls</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/sitemap') ? ' active' : '' }}" href="/admin/sitemap">
                                <i class="nav-main-link-icon fa fa-fw fa-sitemap"></i>
                                <span class="nav-main-link-name">Sitemap</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('admin/export-db/config') ? ' active' : '' }}" href="/admin/export-db/config">
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
                    </ul>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-fw fa-stethoscope"></i>
                        <span class="nav-main-link-name">Monitoring</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="/telescope">
                                <i class="nav-main-link-icon fa fa-fw fa-microscope"></i>
                                <span class="nav-main-link-name">Telescope</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="/pulse">
                                <i class="nav-main-link-icon fa fa-fw fa-heart-pulse"></i>
                                <span class="nav-main-link-name">Pulse</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
<!-- END Sidebar -->
