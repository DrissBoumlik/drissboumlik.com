import $ from 'jquery';

$(function () {
    try {

        $(document).on('submit', '.subscribe-update-form', function(e) {
            e.preventDefault();
            let _this = this;
            let data = $(_this).serializeArray();
            $('#subscribe-form-response').remove();
            $(_this).after(`<div id="subscribe-form-response" class="tc-alert tc-alert-ok text-center"><i class="fa-solid fa-spinner spinClockWise"></i> Sending...</div>`);
            $.ajax({
                method: 'PUT',
                url: `/api/${_this.getAttribute('data-action')}`,
                data: data,
                success: function (response) {
                    console.log(response);
                    $('#subscribe-form-response').remove();
                    $(_this).after(`<div id="subscribe-form-response" class="tc-alert ${response.class} text-center"> ${response.icon} ${response.message}</div>`);
                    window.location.href = response.next_url;
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR, textStatus, errorThrown);
                    let response = jqXHR.responseJSON;
                    $('#subscribe-form-response').remove();
                    $(_this).after(`<div id="subscribe-form-response" class="tc-alert ${response.class} text-center"> ${response.icon} ${response.message}</div>`);
                }
            });
        });
        $(document).on('submit', '.subscribe-form', function (e) {
            e.preventDefault();
            let _this = this;
            $('#subscribe-form-response').remove();
            $(_this).after(`<div id="subscribe-form-response" class="tc-alert tc-alert-ok tc-white text-center"><i class="fa-solid fa-spinner spinClockWise"></i> Sending...</div>`);
            $.ajax({
                method: 'POST',
                url: '/api/subscribers',
                data: {'subscriber_email' : $('#subscriber-email').val()},
                success: function (response) {
                    console.log(response);
                    $('#subscribe-form-response').remove();
                    $(_this).after(`<div id="subscribe-form-response" class="tc-alert ${response.class} text-center"> ${response.icon} ${response.message}</div>`);
                },
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR, textStatus, errorThrown);
                    let response = jqXHR.responseJSON;
                    $('#subscribe-form-response').remove();
                    $(_this).after(`<div id="subscribe-form-response" class="tc-alert ${response.class} text-center"> ${response.icon} ${response.message}</div>`);
                }
            });
        });

    } catch (error) {
        // console.log(error);
    }
});
