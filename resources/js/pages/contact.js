import $ from 'jquery/dist/jquery.min.js';

$(function () {
    try {
        let contactForm = $('#contact-form');
        if (contactForm.length) {
            contactForm.on('submit', function (e) {
                e.preventDefault();
                let _this = this;
                let formIsValid = true;
                let data = $(this).serializeArray();
                data.forEach(function (item, key) {
                    $(`#error-${item.name}`).remove();
                    if (item.value === '') {
                        formIsValid = false;
                        $(`#form-${item.name}`).after(`<div id="error-${item.name}" class="tc-alert tc-alert-error">This field is required.</div>`);
                    }
                });
                if (!formIsValid) {
                    return;
                }

                $('#contact-form-response').remove()
                $(_this).after(`<div id="contact-form-response" class="contact-form-response tc-alert tc-alert-ok text-center"><i class="fa-solid fa-spinner spinClockWise"></i> Sending...</div>`);

                $.ajax({
                    method: 'POST',
                    url: '/api/get-in-touch',
                    data: data,
                    success: function (response) {
                        $('#contact-form-response').remove()
                        $(_this).after(`<div id="contact-form-response" class="contact-form-response tc-alert ${response.class} text-center"> ${response.icon} ${response.message}</div>`);
                        // setTimeout(() => $('#contact-form-response').remove(), 5000);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        let response = jqXHR.responseJSON;
                        $('#contact-form-response').remove()
                        if (response.class && response.icon) {
                            $(_this).after(`<div id="contact-form-response" class="contact-form-response tc-alert ${response.class} text-center"> ${response.icon} ${response.message}</div>`);
                        }
                        let errors = response.errors;
                        data.forEach(function (item, key) {
                            $(`#error-${item.name}`).remove();
                        });
                        for (let errorKey in errors) {
                            let messages = errors[errorKey];
                            $(`#error-${errorKey}`).remove();
                            $(`#form-${errorKey}`).after(`<div id="error-${errorKey}" class="tc-alert tc-alert-error">${messages || 'This field is required.'}</div>`);
                        }
                    }
                });
            });
        }

        let contact_form = document.getElementById("form-body");
        if (contact_form) {
            let previousText = "";
            contact_form.addEventListener("input", function (event) {
                let maxLength = 200;
                let currentLength = this.value.length;
                let textLengthDisplay = document.getElementById("current-text-length");
                textLengthDisplay.innerText = `${currentLength}/${maxLength}`;
                if (currentLength >= maxLength) {
                    // this.value = previousText;
                    this.value = previousText = this.value.substring(0, 200);
                    textLengthDisplay.innerText = `${maxLength}/${maxLength}`;
                    textLengthDisplay.classList.add("tc-red-light");
                } else {
                    previousText = this.value;
                    textLengthDisplay.classList.remove("tc-red-light");
                }
            });
        }


    } catch (error) {
        // console.log(error);
    }
});
