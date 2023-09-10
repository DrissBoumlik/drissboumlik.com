
function initSyntaxHighlighting() {
    One.helpersOnLoad('js-highlightjs');
}

function initGallery() {
    if ($('.js-gallery').length == 0) return;
    One.helpersOnLoad(['jq-magnific-popup']);
}

function initLaraberg() {
    if ($('#post_body').length == 0) return;
    let options = { };
    Laraberg.init('post_body', options)
}

function initSelect2() {
    if ($('.js-select2').length == 0) return;
    One.helpersOnLoad(['jq-select2']);
}
let t = null;
function initImageCropper() {
    let e = document.getElementById("js-img-cropper");
    if (e == null) return;

    if (t) {
        t.destroy();
    }

    One.onLoad((() => class {
        static initImageCropper() {
            Cropper.setDefaults({ aspectRatio: 16 / 9, preview: ".js-img-cropper-preview" });
            t = new Cropper(e, { crop: function (e) {

                } });
            document.querySelectorAll('[data-toggle="cropper"]').forEach((e => {
                e.addEventListener("click", (o => {
                    let a = e.dataset.method || !1, r = e.dataset.option || !1, c = {
                        // crop: () => { t.getData() },
                        zoom: () => { t.zoom(r) },
                        setDragMode: () => { t.setDragMode(r) },
                        rotate: () => { t.rotate(r) },
                        scaleX: () => { t.scaleX(r), e.dataset.option = -r },
                        scaleY: () => { t.scaleY(r), e.dataset.option = -r },
                        setAspectRatio: () => { t.setAspectRatio(r) },
                        crop: () => { t.crop() },
                        clear: () => { t.clear() }
                    };
                    c[a] && c[a]()
                }));
            }));
        }
        static init() { this.initImageCropper() }
    }.init()));
}

function initDatatable() {
    if ($('#posts').length) {
        let params = {
            id: '#posts',
            method: 'POST',
            url: '/api/posts',
            columns: [
                { data: 'id', name: 'id', title: 'Actions', className: 'text-center',
                    render: function (data, type, row, params) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/blog/${row.slug}" target="_blank" class="link-dark">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/admin/posts/edit/${row.slug}" target="_blank" class="link-dark">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                            </button>
                        </div>
                    `;
                    }},
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'title', name: 'title', title: 'Title', className: 'fw-semibold fs-sm',
                    render: function (data, type, row, params) {
                        return `<span data-bs-toggle="tooltip" title="${row.title}">${row.short_title}</span>`;
                    }},
                { data: 'status', name: 'status', title: 'Status',
                    render: function (data, type, row, params) {
                        return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3 rounded-pill ${row.status.class}">${row.status.text}</span`;
                    }},
                { data: 'featured', name: 'featured', title: 'Featured', className: 'fs-sm',
                    render: function (data, type, row, params) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3
                        ${row.featured ? 'bg-success' : 'bg-danger' }"></div>`;
                }},
                { data: 'views', name: 'views', title: '<i class="fa-solid fa-eye"></i>', className: 'text-center'},
                { data: 'likes', name: 'likes', title: '<i class="fa-solid fa-thumbs-up"></i>', className: 'text-center'},
                { data: 'tags_count', name: 'tags_count', title: '<i class="fa-solid fa-tags"></i>', className: 'text-center'},
                { data: 'published_at', name: 'published_at', title: '<i class="fa-solid fa-upload"></i>', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        return `<span title="${row.published_at_formatted}">${row.published_at_for_humans}</span>`;
                    }},
                { data: 'created_at', name: 'created_at', title: '<i class="fa-solid fa-pen"></i>', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        return `<span title="${row.created_at_formatted}">${row.created_at_for_humans}</span>`;
                    }},
                { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                    render: function (data, type, row, params) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3 ${row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                }},
                // <th className="text-center"><i className="fa-solid fa-eye"></i></th>
                // <th className="text-center"><i className="fa-solid fa-thumbs-up"></i></th>
                // <th className="text-center"><i className="fa-solid fa-upload"></i></th>
                // <th className="text-center"><i className="fa-solid fa-pen"></i></th>
                // <th>Active</th>
                // {"data": "commandes_pro_id", "name": "commandes_pro_id", "visible": false,className: 'noVis',}, // Id
                // {"data": "contact_tel", "name": "contact_tel", title: 'Tel', searchName: 'contact_tel', className: 'text-nowrap'}, // Tel
                // {
                //     "data": "date_livraison_souhaitee",
                //     "name": "date_livraison_souhaitee",
                //     title: 'Livraison',
                //     searchName: 'date_livraison_souhaitee',
                //     type: 'date',
                //     mRender: function (data) {
                //         return $.format.date(data, 'dd/MM/yyyy HH:mm')
                //     }
                // },

            ]
        };
        configDT(params);
    }
    if ($('#tags').length) {
        let params = {
            id: '#tags',
            method: 'POST',
            url: '/api/tags',
            columns: [
                { data: 'id', name: 'id', title: 'Actions', className: 'text-center',
                    render: function (data, type, row, params) {
                        return `
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/tags/${row.slug}" target="_blank" class="link-dark">
                                    <i class="fa fa-fw fa-eye"></i>
                                </a>
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip" aria-label="Edit Client" data-bs-original-title="Edit Client">
                                <a href="/admin/tags/edit/${row.slug}" target="_blank" class="link-dark">
                                    <i class="fa fa-fw fa-pencil-alt"></i>
                                </a>
                            </button>
                        </div>
                    `;
                }},
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'name', name: 'name', title: 'Name', className: 'fw-semibold fs-sm'},
                { data: 'slug', name: 'slug', title: 'Slug', className: 'fw-semibold fs-sm'},
                { data: 'color', name: 'color', title: 'Color', className: 'fw-semibold fs-sm',
                    render: function(data, type, row, params) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3"
                             style="background-color: ${row.color}"></div>`;
                    }
                },
                { data: 'posts_count', name: 'posts_count', title: 'Posts', className: 'fw-semibold fs-sm'},
                { data: 'created_at', name: 'created_at', title: '<i class="fa-solid fa-pen"></i>', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        return `<span title="${row.created_at_formatted}">${row.created_at_for_humans}</span>`;
                }},
                { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                    render: function (data, type, row, params) {
                        return `<div class="item item-tiny item-circle mx-auto mb-3 ${row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                }},
            ]
        };
        configDT(params);
    }
    if ($('#visitors').length) {
        let params = {
            id: '#visitors',
            method: 'POST',
            url: '/api/visitors',
            columns: [
                { data: 'id', name: 'id', title: 'ID', className: 'text-center'},
                { data: 'visits_count', name: 'visits_count', title: '<i class="fa fa-fw fa-eye"></i>', className: 'fw-semibold fs-sm'},
                { data: 'ip', name: 'ip', title: 'IP', className: 'text-center'},
                { data: 'updated_at', name: 'updated_at', title: 'updated @', className: 'text-center fs-sm',
                    render: function(data, type, row, params) {
                        return data.split('.')[0].replace('T', ' ');
                    }
                },
                { data: 'countryCode', name: 'countryCode', title: 'Country Code', className: 'fw-semibold fs-sm'},
                { data: 'countryName', name: 'countryName', title: 'Country Name', className: 'fw-semibold fs-sm'},
                { data: 'regionName', name: 'regionName', title: 'Region Name', className: 'fw-semibold fs-sm'},
                { data: 'cityName', name: 'cityName', title: 'City Name', className: 'fw-semibold fs-sm'},
                { data: 'latitude', name: 'latitude', title: 'latitude', className: 'fw-semibold fs-sm'},
                { data: 'longitude', name: 'longitude', title: 'longitude', className: 'fw-semibold fs-sm'},
                { data: 'regionCode', name: 'regionCode', title: 'Region Code', className: 'fw-semibold fs-sm'},
                { data: 'zipCode', name: 'zipCode', title: 'Zip Code', className: 'fw-semibold fs-sm'},
                { data: 'isoCode', name: 'isoCode', title: 'Iso Code', className: 'fw-semibold fs-sm'},
                { data: 'postalCode', name: 'postalCode', title: 'Postal Code', className: 'fw-semibold fs-sm'},
                { data: 'metroCode', name: 'metroCode', title: 'Metro Code', className: 'fw-semibold fs-sm'},
                { data: 'areaCode', name: 'areaCode', title: 'Area Code', className: 'fw-semibold fs-sm'},
                { data: 'timezone', name: 'timezone', title: 'timezone', className: 'fw-semibold fs-sm'},
                { data: 'driver', name: 'driver', title: 'driver', className: 'fw-semibold fs-sm'},
            ]
        };
        configDT(params);
    }
}

function configDT(params) {
    let table = new DataTable(params.id, {
        language: {
            // select: {
            //     style: 'single',
            //     info: false
            // },
            // sWrapper: "dataTables_wrapper dt-bootstrap5",
            // sFilterInput: "form-control form-control-sm",
            // sLengthSelect: "form-select form-select-sm",
            // lengthMenu: "_MENU_",
            // search: "_INPUT_",
            // searchPlaceholder: "Search..",
            // info: "Page <strong>_PAGE_</strong> of <strong>_PAGES_</strong>",
            fnInfoCallback: function( settings, start, end, max, total, pre ) {
                return `${start} <i class="fa-solid fa-arrow-right-long"></i> ${end} | ${total} (Total : ${max})`;
            },
            paginate: {
                first: '<i class="fa fa-angle-double-left"></i>',
                previous: '<i class="fa fa-angle-left"></i>',
                next: '<i class="fa fa-angle-right"></i>',
                last: '<i class="fa fa-angle-double-right"></i>'
            },
            pagingType: "full_numbers",
            pageLength: 5,
        },
        searching: true,
        responsive: true,
        pagingType: 'full_numbers', //'full',
        // autoWidth: true,
        processing: true,
        serverSide: true,
        "ajax": {
            type: params.method,
            url: params.url,
        },
        columns: params.columns,
    });
    $('.btn-refresh').on('click', function (e) {
        table.ajax.reload(null, false);
    });
}

function initPostPageEvent() {
    $('.post-page .wp-block-image').on('click', function () {
        window.open($(this).find('img').attr('src'), '_blank');
    });
}

export { initLaraberg, initSelect2, initGallery, initImageCropper, initSyntaxHighlighting, initDatatable, initPostPageEvent };
