<!-- Sidebar -->
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header bg-white-5">
        <!-- Logo -->
        <a class="fw-semibold text-dual" href="index.html">
                    <span class="smini-visible">
                        <i class="fa fa-circle-notch text-primary"></i>
                    </span>
            <span class="smini-hide fs-5 tracking-wider">
                        <span class="fw-normal">Driss Boumlik</span>
                    </span>
        </a>
        <!-- END Logo -->

        <!-- Extra -->
        <div>
            <!-- Close Sidebar, Visible only on mobile screens -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout"
               data-action="sidebar_close" href="javascript:void(0)">
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
            @include('admin.template.frontend-sections.nav-items', ['nav_class' => 'nav-main'])
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
<!-- END Sidebar -->
