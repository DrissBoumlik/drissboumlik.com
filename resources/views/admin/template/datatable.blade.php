@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link href="{{ asset('/template/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script defer src="{{ asset('/plugins/moment-js/moment.js') }}"></script>
    <script defer src="{{ asset('/template/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script defer src="{{ asset('/template/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        @yield('list-title')
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    @yield('breadcrumb')
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
                <div class="block-content p-0 d-flex justify-content-between gap-2 flex-wrap flex-md-nowrap">
                    @yield('buttons')
                </div>
            </div>
            @yield('custom-dom')
            <div class="block-content block-content-full">
                <div class="table-responsive tc-scroll">
                    @yield('list')
                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
@endsection
