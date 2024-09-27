@extends('admin.template.datatable')

@section('post-header-assets')
    @vite(['resources/js/admin/pages/menu.js'])
@endsection

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
    <button class="btn-refresh btn btn-outline-info w-100"><i class="fa fa-fw fa-refresh me-1"></i>Refresh</button>
    <button class="btn-clear btn btn-outline-secondary w-100"><i class="fa fa-fw fa-eraser me-1"></i>Clear</button>
    <button class="btn-new btn btn-success w-100"><i class="fa fa-fw fa-plus me-1"></i>New Menu Item</button>
@endsection

@section('custom-dom')
    <div class="block-content block-content-full">
        <label class="form-label" for="menu-types-items">Menu Types</label>
        <select class="form-select" id="menu-types-items">
        </select>
    </div>
@endsection

@section('list')
    <table id="menus" class="menus table table-bordered table-striped table-vcenter js-dataTable-responsive"></table>
@endsection
