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
                    <a href="/admin/media-manager/{{ $data->previous_path }}" class="btn btn-outline-warning"><i class="fa fa-fw fa-chevron-circle-left me-1"></i> Back</a>
                    <a href="" class="btn btn-outline-info"><i class="fa fa-fw fa-refresh me-1"></i> Refresh</a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <ol class="breadcrumb breadcrumb-alt">
                    {!! $data->breadcrumb['breadcrumb'] !!}
                </ol>
            </div>
            <div class="block-content block-content-full">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12"><h3>Directories</h3></div>
                        @if (isset($data->content['directories']) && count($data->content['directories']))
                            @foreach($data->content['directories'] as $dir)
                                <div class="col-6 col-sm-4 col-md-3 mb-4 media-item-wrapper">
                                    <div class="directory media-item mb-2">
                                        <a href="/admin/media-manager/{{ $dir->path }}" class="media-item-link">
                                            <div class="directory-icon w-100 h-100"><i class="fa-solid fa-folder-open"></i></div>
                                            <div class="directory-name w-100 h-100">
                                                <span title="{{ $dir->name }}" class="capitalize-first-letter">{{ $dir->name }}</span>
                                            </div>
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-outline-danger w-100 delete-file"
                                            data-name="{{ $dir->name }}" data-path="{{ $dir->path }}">Delete</button>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12"><div class="text-center p-5">No directories found</div></div>
                        @endif
                    </div>
                    <div class=""><hr style="border-top: 2px solid var(--tc-blue)"/></div>
                    <div class="row">
                        <div class="col-12"><h3>Files</h3></div>
                        @if (isset($data->content['files']) && count($data->content['files']))
                            @foreach($data->content['files'] as $file)
                                <div class="col-6 col-sm-4 col-md-3 mb-4 media-item-wrapper">
                                    <div class="file media-item mb-2">
                                        <a href="/{{ $file->getPathname() }}" target="_blank" class="media-item-link">
                                        @if(str_contains(\File::mimeType($file), 'image'))
                                            <div class="file-image h-100">
                                                <img src="/{{ $file->getPathname() }}" class="img-fluid w-100 h-100" alt="{{ $file->getFilename() }}"/>
                                            </div>
                                        @else
                                            <div class="file-icon w-100 h-100"><i class="fa-solid fa-file"></i></div>
                                            <div class="file-name w-100 h-100">
                                                <span title="{{ $file->getFilename() }}" class="capitalize-first-letter">{{ $file->getFilename() }}</span>
                                            </div>
                                        @endif
                                        </a>
                                    </div>
                                    <button type="submit" class="btn btn-outline-danger w-100 delete-file"
                                            data-name="{{ $file->getFilename() }}" data-path="{{ $file->getPathname() }}">Delete</button>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12"><div class="text-center p-5">No files found</div></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
@endsection
