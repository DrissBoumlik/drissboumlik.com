@extends('admin.template.datatable')

@section('list-title')
    Menus list
@endsection

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-alt">
        <li class="breadcrumb-item">
            <a class="link-fx" href="javascript:void(0)">Menus</a>
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
    <table id="menus" class="menus table table-bordered table-striped table-vcenter js-dataTable-responsive"></table>
@endsection
