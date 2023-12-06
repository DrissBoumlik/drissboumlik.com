@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link href="{{ asset('/template/assets/js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('/plugins/chartjs/chart.umd.js') }}"></script>
    <script src="{{ asset('/plugins/chartjs/hammerjs@2.0.8.js') }}"></script>
    <script src="{{ asset('/plugins/chartjs/chartjs-plugin-zoom.min.js') }}"></script>
    <script src="{{ asset('/plugins/moment-js/moment.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Visitors charts
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Visitors</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            Charts
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
            <div class="block-content block-content-full">
                <div class="container-fluid charts">
                    <div class="row chart-section">
                        <h3>Stats by Field</h3>
                        <div class="column-selection col-6">
                            <label class="form-label" for="columns-list">Select column</label>
                            <select class="form-select js-select2" name="columns-list" id="columns-list"></select>
                        </div>
                        <div class="page-selection col-6">
                            <label class="form-label" for="pages-list">Select Page</label>
                            <select class="form-select js-select2" name="pages-list" id="pages-list"></select>
                        </div>
                        <div class="col-12 mt-4">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                    <div class="row chart-section">
                        <h3>Stats by Year</h3>
                        <div class="column-selection col-6">
                            <label class="form-label" for="columns-list2">Select column</label>
                            <select class="form-select js-select2" name="columns-list2" id="columns-list2"></select>
                        </div>
                        <div class="year-selection col-6">
                            <label class="form-label" for="years-list2">Select Year</label>
                            <select class="form-select js-select2" name="years-list2" id="years-list2">
                                <option value="2022">2022</option>
                                <option value="2023" selected>2023</option>
                                <option value="2024">2024</option>
                            </select>
                        </div>
                        <div class="page-selection col-6 mt-3">
                            <label class="form-label" for="pages-list2">Select Page</label>
                            <select class="form-select js-select2" name="pages-list2" id="pages-list2"></select>
                        </div>
                        <div class="col-12 mt-4">
                            <canvas id="myChart2"></canvas>
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