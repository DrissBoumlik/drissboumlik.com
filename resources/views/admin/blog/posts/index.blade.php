@extends('admin.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('/template/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/template/assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/template/assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css') }}">
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="{{ asset('/template/assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-buttons-jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/template/assets/js/plugins/datatables-buttons/buttons.html5.min.js') }}"></script>
    <script>
        One.onLoad((()=>class{static initDataTables(){jQuery.extend(jQuery.fn.DataTable.ext.classes,{sWrapper:"dataTables_wrapper dt-bootstrap5",sFilterInput:"form-control form-control-sm",sLengthSelect:"form-select form-select-sm"}),jQuery.extend(!0,jQuery.fn.DataTable.defaults,{language:{lengthMenu:"_MENU_",search:"_INPUT_",searchPlaceholder:"Search..",info:"Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>",paginate:{first:'<i class="fa fa-angle-double-left"></i>',previous:'<i class="fa fa-angle-left"></i>',next:'<i class="fa fa-angle-right"></i>',last:'<i class="fa fa-angle-double-right"></i>'}}}),jQuery.extend(!0,jQuery.fn.DataTable.Buttons.defaults,{dom:{button:{className:"btn btn-sm btn-primary"}}}),jQuery(".js-dataTable-full").DataTable({pageLength:10,lengthMenu:[[5,10,15,20],[5,10,15,20]],autoWidth:!1}),jQuery(".js-dataTable-full-pagination").DataTable({pagingType:"full_numbers",pageLength:10,lengthMenu:[[5,10,15,20],[5,10,15,20]],autoWidth:!1}),jQuery(".js-dataTable-simple").DataTable({pageLength:10,lengthMenu:!1,searching:!1,autoWidth:!1,dom:"<'row'<'col-sm-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>"}),jQuery(".js-dataTable-buttons").DataTable({pageLength:10,lengthMenu:[[5,10,15,20],[5,10,15,20]],autoWidth:!1,buttons:["copy","csv","excel","pdf","print"],dom:"<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"}),jQuery(".js-dataTable-responsive").DataTable({pagingType:"full_numbers",pageLength:10,lengthMenu:[[5,10,15,20],[5,10,15,20]],autoWidth:!1,responsive:!0})}static init(){this.initDataTables()}}.init()));
    </script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        Posts list
                    </h1>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Posts</a>
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
                <div class="block-content p-0 d-flex justify-content-end">
                    <a href="/admin/posts/create" class="btn btn-success">
                        <i class="fa fa-fw fa-plus me-1"></i> New Post
                    </a>
                </div>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-responsive class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
                    <thead>
                    <tr>
                        <th class="text-center">Actions</th>
                        <th class="text-center">ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th class="text-center"><i class="fa-solid fa-eye"></i></th>
                        <th class="text-center"><i class="fa-solid fa-thumbs-up"></i></th>
                        <th class="text-center"><i class="fa-solid fa-upload"></i></th>
                        <th class="text-center"><i class="fa-solid fa-pen"></i></th>
                        <th>Active</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td class="text-center fs-sm">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                        <a href="/blog/{{ $post->slug }}" target="_blank" class="link-dark">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                        <a href="/admin/posts/edit/{{ $post->slug }}" target="_blank" class="link-dark">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </a>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center fs-sm">{{ $post->id }}</td>
                            <td class="fw-semibold fs-sm"><span data-bs-toggle="tooltip" title="{{ $post->title }}">{{ $post->short_title }}</span></td>
                            <td><span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill {{ $post->status->class }}">{{ $post->status->text }}</span></td>
                            <td class="fs-sm"><div class="item item-tiny item-circle mx-auto mb-3 {{ $post->featured ? 'bg-success' : 'bg-danger' }}"></div></td>
                            <td class="fs-sm">{{ $post->views }}</td>
                            <td class="fs-sm">{{ $post->likes }}</td>
                            <td class="fs-sm">{{ $post->published_at ?? '---' }}</td>
                            <td class="fs-sm">{{ $post->created_at }}</td>
                            <td class="fs-sm"><div class="item item-tiny item-circle mx-auto mb-3 {{ $post->active ? 'bg-success' : 'bg-danger' }}"></div></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
@endsection
