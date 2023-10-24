
$(function () {
    $('#contact-form').on('submit', function(e) {
        e.preventDefault();
        let _this = this;
        let data = $(this).serializeArray();
        data.forEach(function(item, key){
            $(`#error-${item.name}`).remove();
        });
        $.ajax({
            method: 'POST',
            url: '/api/get-in-touch',
            data: data,
            success: function (response) {
                console.log(response);
                $('#contact-form-response').remove()
                $(_this).after(`<div id="contact-form-response" class="tc-alert tc-alert-ok text-center">${response.message}</div>`);
                setTimeout(() => $('#contact-form-response').remove(), 5000);
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR, textStatus, errorThrown);
                // $(_this).after(`<div id="contact-form-response" class="tc-alert tc-alert-error text-center">${jqXHR.responseJSON.message}</div>`);
                // setTimeout(() => $('#contact-form-response').remove(), 5000);
                for(let errorKey in jqXHR.responseJSON.errors) {
                    let messages = jqXHR.responseJSON.errors[errorKey];
                    $(`#form-${errorKey}`).after(`<div id="error-${errorKey}" class="tc-alert tc-alert-error">${messages[0]}</div>`);
                }
            }
        });
    });
});
