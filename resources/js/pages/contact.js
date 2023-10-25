
$(function () {
    $('#contact-form').on('submit', function(e) {
        e.preventDefault();
        let _this = this;
        let data = $(this).serializeArray();
        data.forEach(function(item, key){
            $(`#error-${item.name}`).remove();
        });

        $('#contact-form-response').remove()
        $(_this).after(`<div id="contact-form-response" class="tc-alert tc-alert-ok text-center"><i class="fa-solid fa-spinner spinClockWise"></i> Sending...</div>`);

        $.ajax({
            method: 'POST',
            url: '/api/get-in-touch',
            data: data,
            success: function (response) {
                $('#contact-form-response').remove()
                $(_this).after(`<div id="contact-form-response" class="tc-alert tc-alert-ok text-center"> ${response.icon} ${response.message}</div>`);
                setTimeout(() => $('#contact-form-response').remove(), 5000);
            },
            error: function (jqXHR, textStatus, errorThrown){
                $('#contact-form-response').remove()
                let errors = jqXHR.responseJSON.errors;
                for(let errorKey in errors) {
                    let messages = errors[errorKey];
                    $(`#form-${errorKey}`).after(`<div id="error-${errorKey}" class="tc-alert tc-alert-error">${messages[0]}</div>`);
                }
            }
        });
    });
});
