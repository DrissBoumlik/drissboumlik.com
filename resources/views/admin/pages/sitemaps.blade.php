@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link href="{{ asset('/template/assets/js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script defer src="{{ asset('/plugins/moment-js/moment.js') }}"></script>
    <script defer src="{{ asset('/template/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('post-header-assets')
    @vite(['resources/js/admin/pages/media-manager.js'])
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Sitemaps
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Sitemaps</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            List
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Dynamic Table Responsive -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <div class="block-content p-0 d-flex justify-content-between">
                    <a onclick="location.reload(true);;" class="btn btn-outline-info w-100">
                        <i class="fa fa-fw fa-redo me-1"></i>Reload</a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="container-fluid">
                    <div class="sitemap d-flex justify-content-center gap-4 flex-wrap flex-md-nowrap">
                        <div class="view-sitemaps-archive w-100">
                            <a class="btn btn-alt-secondary w-100 h-100px d-flex justify-content-center align-items-center" href="/admin/media-manager/storage/sitemap-archive">
                                <i class="fa fa-fw fa-eye me-2"></i>View sitemaps archive</a>
                        </div>
                        <div class="generate-sitemap w-100">
                            <a class="btn btn-alt-primary w-100 h-100px d-flex justify-content-center align-items-center" href="/admin/generate-sitemap"
                                target="_blank"><i class="fa fa-fw fa-sitemap me-2"></i>Generate Sitemap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
@endsection
