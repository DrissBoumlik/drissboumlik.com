@extends('admin.template.datatable')

@section('list-title')
    Menu Types list
@endsection

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-alt">
        <li class="breadcrumb-item">
            <a class="link-fx" href="javascript:void(0)">Menu Types</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">
            List
        </li>
    </ol>
@endsection

@section('buttons')
    <button class="btn-refresh btn btn-outline-info">
        <i class="fa fa-fw fa-refresh me-1"></i>Refresh</button>
@endsection

@section('list')
    <table id="menu-types" class="menu-types table table-bordered table-striped table-vcenter js-dataTable-responsive"></table>
@endsection
