@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link href="{{ asset('/template/assets/js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script defer src="{{ asset('/plugins/chartjs/chart.umd.js') }}"></script>
    <script defer src="{{ asset('/plugins/chartjs/hammerjs@2.0.8.js') }}"></script>
    <script defer src="{{ asset('/plugins/chartjs/chartjs-plugin-zoom.min.js') }}"></script>
    <script defer src="{{ asset('/plugins/moment-js/moment.js') }}"></script>
    <script defer src="{{ asset('/template/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('post-header-assets')
    @vite(['resources/js/admin/pages/user-interaction/chart.js'])
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
            <div class="block-content block-content-full p-md-3 py-2 px-1">
                <div class="container-fluid charts">
                    <div class="chart-section row py-3 px-1">
                        <h3>Stats by Field</h3>
                        <div class="chart-options">
                            <div class="chart-option column-selection">
                                <label class="form-label" for="columns-list">Select column</label>
                                <select class="form-select" name="columns-list" id="columns-list"></select>
                            </div>
                            <div class="chart-option page-selection">
                                <label class="form-label" for="pages-list">Select Page</label>
                                <select class="form-select" name="pages-list" id="pages-list"></select>
                            </div>
                            <div class="chart-option perpage-selection">
                                <label class="form-label" for="perpage-list">Select Per Page</label>
                                <select class="form-select" name="perpage-list" id="perpage-list">
                                    <option value="10">10</option>
                                    <option value="20" selected>20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="150">150</option>
                                    <option value="200">200</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="chart-container"><canvas id="myChart"></canvas></div>
                        </div>
                    </div>
                    <div class="row chart-section py-3 px-1">
                        <h3>Stats by Year</h3>
                        <div class="chart-options">
                            <div class="chart-option column-selection">
                                <label class="form-label" for="columns-list2">Select column</label>
                                <select class="form-select" name="columns-list2" id="columns-list2"></select>
                            </div>
                            <div class="chart-option year-selection">
                                <label class="form-label" for="years-list2">Select Year</label>
                                <select class="form-select" name="years-list2" id="years-list2">
                                    @for($year = 2022; $year <= 2030; $year++)
                                        <option value="{{ $year }}" {{ now()->year === $year ? 'selected' : ''}}>{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="chart-option page-selection">
                                <label class="form-label" for="pages-list2">Select Page</label>
                                <select class="form-select" name="pages-list2" id="pages-list2"></select>
                            </div>
                            <div class="chart-option perpage-selection">
                                <label class="form-label" for="perpage-list2">Select Per Page</label>
                                <select class="form-select" name="perpage-list2" id="perpage-list2">
                                    <option value="10">10</option>
                                    <option value="20" selected>20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="150">150</option>
                                    <option value="200">200</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="chart-container"><canvas id="myChart2"></canvas></div>
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
