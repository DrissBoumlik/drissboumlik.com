@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link href="/template/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="/plugins/chartjs/chart.umd.js"></script>
    <script src="/plugins/chartjs/hammerjs@2.0.8.js"></script>
    <script src="/plugins/chartjs/chartjs-plugin-zoom.min.js"></script>
    <script src="{{ asset('/plugins/moment-js/moment.js') }}"></script>
    <script src="/template/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Visitors list
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Visitors</a>
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
                    <button class="btn-refresh btn btn-outline-info">
                        <i class="fa fa-fw fa-refresh me-1"></i> Refresh
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <!-- DataTables init on table by adding .js-dataTable-responsive class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table id="visitors" class="visitors table table-bordered table-striped table-vcenter js-dataTable-responsive"></table>
                </div>
                <div class="chart mt-5">
                    <div class="column-selection">
                        <label class="form-label" for="columns-list">Select column</label>
                        <select class="form-select" name="columns-list" id="columns-list"></select>
                    </div>
                    <div class="page-selection mt-3">
                        <label class="form-label" for="pages-list">Select Page</label>
                        <select class="form-select" name="pages-list" id="pages-list"></select>
                    </div>
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
@endsection
