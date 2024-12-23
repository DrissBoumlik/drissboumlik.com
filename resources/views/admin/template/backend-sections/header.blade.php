<!-- Header -->
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="d-flex align-items-center">
            @include('admin.addons.toggle-sidebar')
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="d-flex align-items-center gap-2">
            <!-- User Dropdown -->
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle" src="{{ asset('/assets/img/me/circle-256.png') }}" alt="Header Avatar" width="20" height="20" loading="lazy">
                    <span class="d-none d-sm-inline-block ms-2">{{ \Auth::user()->name }}</span>
                    <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block ms-1 mt-1"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown">
                    <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                        <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset('/assets/img/me/circle-256.ico') }}" alt="" width="50" height="50" loading="lazy">
                        <p class="mt-2 mb-0 fw-medium">{{ \Auth::user()->name }}</p>
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="/admin/profile">
                            <span class="fs-sm fw-medium">Profile</span>
                        </a>
                    </div>
                    <div role="separator" class="dropdown-divider m-0"></div>
                    <div class="p-2">
                        @include('components.logout-button', ['logout_btn' => '<span class="fs-sm fw-medium">Log Out</span>', 'link_classes' => 'dropdown-item d-flex align-items-center justify-content-between'])
                    </div>
                </div>
            </div>
            <!-- END User Dropdown -->
            @include('admin.addons.toggle-header')
            @include('admin.addons.darkmode')
            @include('admin.addons.toggle-sidebar')

        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Loader -->
    <!-- Please check out the Loaders page under Components category to see examples of showing/hiding it -->
    <div id="page-header-loader" class="overlay-header bg-body-extra-light">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-circle-notch fa-spin"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>
<!-- END Header -->
