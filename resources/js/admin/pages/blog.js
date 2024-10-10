import {getDomClass, shortenTextIfLongByLength, configDT} from "../functions";

document.addEventListener("DOMContentLoaded", function () {
    try {

        if (document.querySelector('#posts')) {
            let params = {
                first_time: true,
                id: '#posts',
                method: 'POST',
                url: '/api/posts',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions',
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="View Post">
                                            <a href="/blog/${row.slug}" target="_blank" class="link-dark">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="Edit Post">
                                            <a href="/admin/posts/edit/${row.slug}" target="_blank" class="link-dark">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </a>
                                        </button>
                                    </div>`;
                    }},
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row, params) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3 ${ row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'title', name: 'title', title: 'Title', className: 'fw-semibold fs-sm',
                        render: function (data, type, row, params) {
                            return `<span title="${row.title}">${shortenTextIfLongByLength(row.title, 20)}</span>`;
                    }},
                    { data: 'published', name: 'published', title: 'Published', domElement: 'select',
                        render: function (data, type, row, params) {
                            let published = getDomClass(row.published);
                            return `<span class="fs-xs fw-semibold d-inline-block py-1 px-3
                                                rounded-pill ${published.class}">${published.text}</span>`;
                    }},
                    { data: 'featured', name: 'featured', title: 'Featured', className: 'fs-sm', domElement: 'select',
                        render: function (data, type, row, params) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3
                                                ${row.featured ? 'bg-success' : 'bg-danger'}"></div>`;
                    }},
                    { data: 'views', name: 'views', title: 'Views' },
                    { data: 'likes', name: 'likes', title: 'Likes' },
                    { data: 'tags_count', name: 'tags_count', title: 'Tags', searchable: false },
                    { data: 'published_at', name: 'published_at', title: 'Published @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let published_at_for_humans = row.published_at ? moment(row.published_at).fromNow() : '------';
                            let published_at_formatted = row.published_at ? moment(row.published_at).format('Y-M-D hh:mm') : '------';
                            return `<span title="${published_at_formatted}">${published_at_for_humans}<br/>${published_at_formatted}</span>`;
                    }},
                    { data: 'created_at', name: 'created_at', title: 'Created @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let created_at_for_humans = moment(row.created_at).fromNow();
                            let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                            return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
                    }},
                    { data: 'updated_at', name: 'updated_at', title: 'Updated @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let updated_at_for_humans = moment(row.updated_at).fromNow();
                            let updated_at_formatted = moment(row.updated_at).format('Y-M-D hh:mm');
                            return `<span title="${updated_at_formatted}">${updated_at_for_humans}<br/>${updated_at_formatted}</span>`;
                    }},
                ]
            };
            configDT(params);
        }

        if (document.querySelector('#tags')) {
            let params = {
                first_time: true,
                id: '#tags',
                method: 'POST',
                url: '/api/tags',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions',
                        render: function (data, type, row, params) {
                            return `<div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="View Tag">
                                            <a href="/tags/${row.slug}" target="_blank" class="link-dark">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" title="Edit Tag">
                                            <a href="/admin/tags/edit/${row.slug}" target="_blank" class="link-dark">
                                                <i class="fa fa-fw fa-pencil-alt"></i>
                                            </a>
                                        </button>
                                    </div>`;
                    }},
                    { data: 'active', name: 'active', title: 'Active', className: 'fs-sm',
                        render: function (data, type, row, params) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3
                                                ${ row.active ? 'bg-success' : 'bg-danger' }"></div>`;
                    }},
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'name', name: 'name', title: 'Name', className: 'fw-semibold fs-sm' },
                    { data: 'slug', name: 'slug', title: 'Slug', className: 'fw-semibold fs-sm' },
                    { data: 'color', name: 'color', title: 'Color', className: 'fw-semibold fs-sm',
                        render: function(data, type, row, params) {
                            return `<div class="item item-tiny item-circle mx-auto mb-3"
                                    style="background-color: ${row.color}"></div>`;
                    }},
                    { data: 'posts_count', name: 'posts_count', title: 'Posts', className: 'fw-semibold fs-sm', searchable: false },
                    { data: 'created_at', name: 'created_at', title: 'Created @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let created_at_for_humans = moment(row.created_at).fromNow();
                            let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                            return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
                    }},
                ]
            };
            configDT(params);
        }
    } catch (error) {
        console.log(error);
    }
});
