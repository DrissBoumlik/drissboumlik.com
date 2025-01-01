import { configDT, get_alert_box } from "@/admin/tools";

$(function () {
    try {

        if ($('#visitors').length) {
            let params = {
                first_time: true,
                id: '#visitors',
                method: 'POST',
                url: '/api/visitors',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-visitor-details">
                            <i class="fa fs-3 fa-eye"></i>
                        </button>
                    </div>
                `;
                        }
                    },
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'ip', name: 'ip', title: 'IP' },
                    { data: 'url', name: 'url', title: 'URL', className: 'text-left'},
                    { data: 'ref_source', name: 'ref_source', title: 'Source', className: 'text-left'},
                    { data: 'ref_medium', name: 'ref_medium', title: 'Medium', className: 'text-left'},
                    { data: 'updated_at', name: 'updated_at', title: 'Updated @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let updated_at_for_humans = moment(row.updated_at).fromNow();
                            let updated_at_formatted = moment(row.updated_at).format('Y-M-D hh:mm');
                            return `<span title="${updated_at_formatted}">${updated_at_for_humans}<br/>${updated_at_formatted}</span>`;
                        }
                    },
                    { data: 'countryCode', name: 'countryCode', title: 'Country Code', className: 'fw-semibold fs-sm'},
                    { data: 'currencyCode', name: 'currencyCode', title: 'Currency Code', className: 'fw-semibold fs-sm'},
                    { data: 'countryName', name: 'countryName', title: 'Country Name', className: 'fw-semibold fs-sm'},
                    { data: 'regionName', name: 'regionName', title: 'Region Name', className: 'fw-semibold fs-sm'},
                    { data: 'cityName', name: 'cityName', title: 'City Name', className: 'fw-semibold fs-sm'},
                    { data: 'latitude', name: 'latitude', title: 'Latitude', className: 'fw-semibold fs-sm'},
                    { data: 'longitude', name: 'longitude', title: 'Longitude', className: 'fw-semibold fs-sm'},
                    { data: 'regionCode', name: 'regionCode', title: 'Region Code', className: 'fw-semibold fs-sm'},
                    { data: 'zipCode', name: 'zipCode', title: 'Zip Code', className: 'fw-semibold fs-sm'},
                    { data: 'isoCode', name: 'isoCode', title: 'Iso Code', className: 'fw-semibold fs-sm'},
                    { data: 'postalCode', name: 'postalCode', title: 'Postal Code', className: 'fw-semibold fs-sm'},
                    { data: 'metroCode', name: 'metroCode', title: 'Metro Code', className: 'fw-semibold fs-sm'},
                    { data: 'areaCode', name: 'areaCode', title: 'Area Code', className: 'fw-semibold fs-sm'},
                    { data: 'timezone', name: 'timezone', title: 'Timezone', className: 'fw-semibold fs-sm'},
                    { data: 'driver', name: 'driver', title: 'Driver', className: 'fw-semibold fs-sm'},
                ]
            };
            let visitorsDataTable = configDT(params);
            $('#visitors').on('click', '.display-visitor-details', function(e) {
                const $row = $(this).closest('tr');
                const data = visitorsDataTable.row( $row ).data();
                let created_at = moment(data.updated_at)
                let modal = `
        <div class="modal modal-visitor-details" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${data.countryName}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form id="form-visitor" data-visitor-id="${data.id}">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label" for="country-name">Country</label>
                                            <input type="text" class="form-control" id="country-name" name="countryName"
                                                value="${data.countryName}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="country-code">Country Code</label>
                                            <input type="text" class="form-control" id="country-code" name="countryCode"
                                                value="${data.countryCode}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="region-name">Region</label>
                                            <input type="text" class="form-control" id="region-name" name="regionName"
                                                value="${data.regionName}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="city-name">City</label>
                                            <input type="text" class="form-control" id="city-name" name="cityName"
                                                value="${data.cityName}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">IP : ${data.ip}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">URL : ${data.url}</label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Source : ${data.ref_source}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Medium : ${data.ref_medium}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Created @ : ${created_at.format('Y-M-D hh:mm')} / ${created_at.fromNow()}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Zip Code : ${data.zipCode}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Latitude : ${data.latitude}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">Logitude : ${data.longitude}</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlInput1" class="form-label">TimeZone : ${data.timezone}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-outline-info w-100">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>`;
                $('#page-container').append(modal);
                let modalVisitorDetails = $('.modal-visitor-details');
                $('.btn-close').add('.modal-visitor-details').on('click', function(e) {
                    if (e.target != modalVisitorDetails[0] && e.target != $('.btn-close')[0]) {
                        return;
                    }
                    modalVisitorDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalVisitorDetails.show()

                $(document).off('submit', '#form-visitor').on('submit', '#form-visitor', function(e) {
                    e.preventDefault();
                    if (!confirm("Are you sure ?")) {
                        return;
                    }
                    let _this = $(this);
                    let data = _this.serializeArray();
                    $.ajax({
                        type: 'PUT',
                        url: `/api/visitors/${_this.data('visitor-id')}`,
                        data: data,
                        success: function(response) {
                            visitorsDataTable.ajax.reload(null, false);
                            get_alert_box({class: 'alert-info', message: response.message, icon: '<i class="fa-solid fa-check-circle"></i>'});
                        },
                        error: function (jqXHR, textStatus, errorThrown){
                            console.log(jqXHR, textStatus, errorThrown);
                            get_alert_box({class: 'alert-danger', message: jqXHR.responseJSON.message, icon: '<i class="fa-solid fa-triangle-exclamation"></i>'});
                        }
                    });
                });

            });
        }
        if ($('#messages').length) {
            let params = {
                first_time: true,
                id: '#messages',
                method: 'POST',
                url: '/api/messages',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-email-details">
                            <i class="fa fs-3 fa-eye"></i>
                        </button>
                    </div>
                `;
                        }
                    },
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'name', name: 'name', title: 'Name' },
                    { data: 'email', name: 'email', title: 'Email' },
                    { data: 'body', name: 'body', title: 'Body' ,
                        render: function(data, type, row, params) {
                            return data.substring(0, 30) + '...';
                        }
                    },
                    { data: 'created_at', name: 'created_at', title: 'Created @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let created_at_for_humans = moment(row.created_at).fromNow();
                            let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                            return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
                        }
                    },
                ]
            };
            let messagesDataTable = configDT(params);
            $('#messages').on('click', '.display-email-details', function(e) {
                const $row = $(this).closest('tr');
                const data = messagesDataTable.row( $row ).data();

                let created_at = moment(data.created_at);

                let modal = `
        <div class="modal modal-email-details" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${data.name}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Sender : ${data.name}</label>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email : ${data.email}</label>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Message : <br/>${data.body}</label>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Created @ : ${created_at.format('Y-M-D hh:mm')} / ${created_at.fromNow()}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>`;
                $('#page-container').append(modal);
                let modalEmailDetails = $('.modal-email-details');
                $('.btn-close').add('.modal-email-details').on('click', function(e) {
                    if (e.target != modalEmailDetails[0] && e.target != $('.btn-close')[0]) {
                        return;
                    }
                    modalEmailDetails.remove();
                    $('.modal-backdrop').remove();
                });
                modalEmailDetails.show()
            });
        }
        if ($('#subscriptions').length) {
            let params = {
                first_time: true,
                id: '#subscriptions',
                method: 'POST',
                url: '/api/subscriptions',
                columns: [
                    { data: 'id', name: 'id', title: 'Actions' ,
                        render: function (data, type, row, params) {
                            return `
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm js-bs-tooltip-enabled display-email-details">
                            <i class="fa fs-3 fa-eye"></i>
                        </button>
                    </div>
                `;
                        }
                    },
                    { data: 'id', name: 'id', title: 'ID' },
                    { data: 'subscription_id', name: 'subscription_id',title: 'Subscription Id'  },
                    { data: 'email', name: 'email', title: 'Email'  },
                    { data: 'first_name', name: 'first_name', title: 'First Name'  },
                    { data: 'last_name', name: 'last_name', title: 'Last Name'  },
                    { data: 'subscribed_at', name: 'subscribed_at', title: 'Subscribed At'  },
                    { data: 'token_verification', name: 'token_verification', title: 'Token Verification' },
                    { data: 'created_at', name: 'created_at', title: 'Created @', className: 'fs-sm',
                        render: function(data, type, row, params) {
                            let created_at_for_humans = moment(row.created_at).fromNow();
                            let created_at_formatted = moment(row.created_at).format('Y-M-D hh:mm');
                            return `<span title="${created_at_formatted}">${created_at_for_humans}<br/>${created_at_formatted}</span>`;
                        }
                    },
                ]
            };
            let subscriptionsDataTable = configDT(params);
        }

    } catch (error) {
        console.log(error);
    }
});
