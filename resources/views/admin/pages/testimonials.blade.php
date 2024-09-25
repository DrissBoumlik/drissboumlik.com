@extends('admin.template.datatable')

@section('list-title')
    Testimonials list
@endsection

@section('breadcrumb')
    <ol class="breadcrumb breadcrumb-alt">
        <li class="breadcrumb-item">
            <a class="link-fx" href="javascript:void(0)">Testimonials</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">
            List
        </li>
    </ol>
@endsection

@section('buttons')
    <button class="btn-refresh btn btn-outline-info"><i class="fa fa-fw fa-refresh me-1"></i>Refresh</button>
    <button class="btn-new btn btn-success"><i class="fa fa-fw fa-plus me-1"></i>New Testimonial</button>
@endsection

@section('list')
    <table id="testimonials" class="testimonials table table-bordered table-striped table-vcenter js-dataTable-responsive"></table>
@endsection
