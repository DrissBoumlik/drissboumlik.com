@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link href="{{ asset('/template/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('/plugins/moment-js/moment.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Tables list
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Tables</a>
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
                    <button class="btn btn-outline-warning btn-export mb-3">
                        <i class="fa-solid fa-download"></i> Export
                    </button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="export-db-config">
                    <div class="form-check form-block">
                        <input class="form-check-input" type="checkbox" value="" id="do-not-create-tables" name="do-not-create-tables">
                        <label class="form-check-label" for="do-not-create-tables">Don't create tables</label>
                    </div>
                    <div class="form-check form-block">
                        <input class="form-check-input" type="checkbox" value="" id="export-all-tables" name="export-all-tables">
                        <label class="form-check-label" for="export-all-tables">Export all tables</label>
                    </div>
                </div>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <!-- DataTables init on table by adding .js-dataTable-responsive class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                    <table id="tables" class="visitors table table-bordered table-striped table-vcenter js-dataTable-responsive">
                        <tr>
                            <th>Table name</th>
                            <th>Table count</th>
                            <th class="text-center"><i class="fa fa-fw fa-square-check"></i></th>
                        </tr>
                        @foreach($data->tables as $table)
                        <tr>
                            <td class="table-name">{{ $table->name }}</td>
                            <td>{{ $table->count }}</td>
                            <td class="text-center"><input type="checkbox" class="form-check-input table-item" name="tables[]"></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
@endsection
