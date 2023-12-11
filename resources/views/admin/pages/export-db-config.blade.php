@extends('admin.template.datatable')

@section('list-title')
    Tables list
@endsection

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-alt">
        <li class="breadcrumb-item">
            <a class="link-fx" href="javascript:void(0)">Tables</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">
            List
        </li>
    </ol>
@endsection

@section('buttons')
    <button class="btn-refresh btn btn-outline-info">
        <i class="fa fa-fw fa-refresh me-1"></i> Refresh
    </button>
    <button class="btn btn-outline-warning btn-export">
        <i class="fa-solid fa-download"></i> Export
    </button>
@endsection

@section('custom-dom')
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
@endsection

@section('list')
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
@endsection
