@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link href="{{ asset('/template/assets/js/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('/plugins/moment-js/moment.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('post-header-assets')
    @vite(['resources/js/admin/pages/media-manager.js'])
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        File Manager
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">File Manager</a>
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
                    <a href="/admin/media-manager" data-href id="previous-path" class="btn btn-outline-warning media-link"><i class="fa fa-fw fa-chevron-circle-left me-1"></i>Back</a>
                    <button class="btn btn-outline-danger btn-empty-trash"><i class="fa fa-fw fa-trash me-1"></i>Empty Trash</button>
                </div>
            </div>
            <div class="block-header block-header-default br-0">
                <form id="form-create-directories">
                    <div class="input-group">
                        <input type="text" class="form-control" id="directories-names" name="directories-names" placeholder="Separate names by ;" required>
                        <button type="submit" class="btn btn-outline-success"><i class="fa fa-fw fa-folder-plus me-1"></i>New Directory</button>
                    </div>
                </form>
            </div>
            <div class="block-content block-content-full">
                <ol class="breadcrumb breadcrumb-alt" id="breadcrumb">

                </ol>
            </div>
            <div class="block-content block-content-full">
                <div class="container-fluid">
                    <div class=""><h3>Directories</h3></div>
                    <div class="row" id="directories">
                        <div class="col-12 text-center p-5">
                            <div class="spinner-border" role="status"
                                 style="width: 3rem; height: 3rem;
                                 border-color: var(--tc-grey-dark) transparent var(--tc-grey-dark) var(--tc-grey-dark);" >
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="row"><div class="col-12"><hr style="border-top: 2px solid var(--tc-blue)"/></div></div>
                    <div class=""><h3>Files</h3></div>
                    <div class="row" id="files">
                        <div class="col-12 text-center p-5">
                            <div class="spinner-border" role="status"
                                 style="width: 3rem; height: 3rem;
                                border-color: var(--tc-grey-dark) transparent var(--tc-grey-dark) var(--tc-grey-dark);" >
                                <span class="visually-hidden">Loading...</span>
                            </div>
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
