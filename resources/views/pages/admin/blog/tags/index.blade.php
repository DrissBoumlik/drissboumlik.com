@extends('layout.template.backend')

@section('css')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="/template/assets/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/template/assets/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet"
          href="/template/assets/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css">
@endsection

@section('js')
    <!-- Page JS Plugins -->
    <script src="/template/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-buttons/dataTables.buttons.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-buttons-jszip/jszip.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js"></script>
    <script src="/template/assets/js/plugins/datatables-buttons/buttons.print.min.js"></script>
    <script src="/template/assets/js/plugins/datatables-buttons/buttons.html5.min.js"></script>
    <script>
        One.onLoad((() => class {
            static initDataTables() {
                jQuery.extend(jQuery.fn.DataTable.ext.classes, {
                    sWrapper: "dataTables_wrapper dt-bootstrap5",
                    sFilterInput: "form-control form-control-sm",
                    sLengthSelect: "form-select form-select-sm"
                }), jQuery.extend(!0, jQuery.fn.DataTable.defaults, {
                    language: {
                        lengthMenu: "_MENU_",
                        search: "_INPUT_",
                        searchPlaceholder: "Search..",
                        info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>",
                        paginate: {
                            first: '<i class="fa fa-angle-double-left"></i>',
                            previous: '<i class="fa fa-angle-left"></i>',
                            next: '<i class="fa fa-angle-right"></i>',
                            last: '<i class="fa fa-angle-double-right"></i>'
                        }
                    }
                }), jQuery.extend(!0, jQuery.fn.DataTable.Buttons.defaults, {dom: {button: {className: "btn btn-sm btn-primary"}}}), jQuery(".js-dataTable-full").DataTable({
                    pageLength: 10,
                    lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
                    autoWidth: !1
                }), jQuery(".js-dataTable-full-pagination").DataTable({
                    pagingType: "full_numbers",
                    pageLength: 10,
                    lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
                    autoWidth: !1
                }), jQuery(".js-dataTable-simple").DataTable({
                    pageLength: 10,
                    lengthMenu: !1,
                    searching: !1,
                    autoWidth: !1,
                    dom: "<'row'<'col-sm-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>"
                }), jQuery(".js-dataTable-buttons").DataTable({
                    pageLength: 10,
                    lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
                    autoWidth: !1,
                    buttons: ["copy", "csv", "excel", "pdf", "print"],
                    dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                }), jQuery(".js-dataTable-responsive").DataTable({
                    pagingType: "full_numbers",
                    pageLength: 10,
                    lengthMenu: [[5, 10, 15, 20], [5, 10, 15, 20]],
                    autoWidth: !1,
                    responsive: !0
                })
            }

            static init() {
                this.initDataTables()
            }
        }.init()));
    </script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        DataTables
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        Tables transformed with dynamic features.
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="javascript:void(0)">Tables</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            DataTables
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
                <h3 class="block-title">
                    Dynamic Table <small>DataTables Responsive Mode</small>
                </h3>
            </div>
            <div class="block-content d-flex justify-content-end">
                <a href="/admin/tags/create" class="btn btn-success">
                    <i class="fa fa-fw fa-plus me-1"></i> New Tag
                </a>
            </div>
            <div class="block-content block-content-full">
                <!-- DataTables init on table by adding .js-dataTable-responsive class, functionality is initialized in js/pages/be_tables_datatables.min.js which was auto compiled from _js/pages/be_tables_datatables.js -->
                <table class="table table-bordered table-striped table-vcenter js-dataTable-responsive">
                    <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>color</th>
                        <th>Posts</th>
                        <th class="text-center" style="width: 100px;">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tags as $tag)
                        <tr>
                            <td class="text-center fs-sm">{{ $tag->id }}</td>
                            <td class="fw-semibold fs-sm">{{ $tag->name }}</td>
                            <td class="fw-semibold fs-sm">{{ $tag->slug }}</td>
                            <td class="fw-semibold fs-sm"><div class="item item-tiny item-circle mx-auto mb-3" style="background-color: {{ $tag->color }}"></div></td>
                            <td class="fw-semibold fs-sm">{{ $tag->posts_count }}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="/admin/tags/edit/{{ $tag->slug }}" class="btn btn-sm btn-alt-secondary"
                                       data-bs-toggle="tooltip" title="Edit">
                                        <i class="fa fa-fw fa-pencil-alt"></i>
                                    </a>
                                    <a href="/admin/tags/edit/{{ $tag->slug }}" class="btn btn-sm btn-alt-secondary"
                                       data-bs-toggle="tooltip" title="Delete">
                                        <i class="fa fa-fw fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Dynamic Table Responsive -->
    </div>
    <!-- END Page Content -->

    @php $response = session()->get('response') @endphp
    @if ($response)
        <!-- END Page Content -->
        <div data-notify="container" class="col-11 col-sm-4 alert {{ $response['class'] }} alert-dismissible animated fadeIn" role="alert" data-notify-position="bottom-right" style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1033; bottom: 20px; right: 20px; animation-iteration-count: 1;">
            <p class="mb-0">
                <span data-notify="icon"></span>
                <span data-notify="title"></span>
                <span data-notify="message">{{ $response['message'] }}</span>
            </p>
            <a class="p-2 m-1 text-dark" href="javascript:void(0)" aria-label="Close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1035;">
                <i class="fa fa-times"></i>
            </a>
        </div>
        <script>
            $('.alert-info').on('click', function() { $(this).remove() });
        </script>
    @endif
@endsection
