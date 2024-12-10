
document.addEventListener('DOMContentLoaded', function () {
    try {
        const contactForm = document.getElementById('contact-form');

        if (contactForm) {
            contactForm.addEventListener('submit', function (e) {
                e.preventDefault();

                let formIsValid = true;
                const formData = new FormData(contactForm);
                const data = {};

                // Convert FormData to object
                formData.forEach((value, key) => {
                    data[key] = value;
                });

                // Clear previous errors
                Object.keys(data).forEach((name) => {
                    const errorElement = document.getElementById(`error-${name}`);
                    if (errorElement) errorElement.remove();
                });

                // Validate fields
                Object.keys(data).forEach((name) => {
                    if (data[name].trim() === '') {
                        formIsValid = false;
                        const fieldElement = document.getElementById(`form-${name}`);
                        if (fieldElement) {
                            fieldElement.insertAdjacentHTML(
                                'afterend',
                                `<div id="error-${name}" class="tc-alert tc-alert-error">This field is required.</div>`
                            );
                        }
                    }
                });

                if (!formIsValid) {
                    return;
                }

                const responseContainer = document.getElementById('contact-form-response');
                if (responseContainer) responseContainer.remove();

                const sendButton = document.querySelector('.btn-send');
                if (sendButton) sendButton.classList.add('loading-spinner');

                // Send AJAX request
                fetch('/api/get-in-touch', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(data),
                })
                    .then(async (response) => {
                        const result = await response.json();
                        // Remove previous response
                        if (responseContainer) responseContainer.remove();
                        // Display success or error
                        debugger
                        contactForm.insertAdjacentHTML('afterend', getAlertDom(result));
                        // Remove spinner
                        if (sendButton) sendButton.classList.remove('loading-spinner');
                    })
                    .catch(async (error) => {
                        const response = error.responseJSON || {};

                        // Remove previous response
                        if (responseContainer) responseContainer.remove();

                        if (response.class && response.icon) {
                            contactForm.insertAdjacentHTML('afterend', getAlertDom(response));
                        }

                        // Display errors
                        const errors = response.errors || {};
                        Object.keys(errors).forEach((errorKey) => {
                            const messages = errors[errorKey] || ['This field is required.'];
                            debugger
                            const fieldElement = document.getElementById(`form-${errorKey}`);
                            if (fieldElement) {
                                fieldElement.insertAdjacentHTML(
                                    'afterend',
                                    `<div id="error-${errorKey}" class="tc-alert tc-alert-error">${messages.join('<br>')}</div>`
                                );
                            }
                        });

                        // Remove spinner
                        if (sendButton) sendButton.classList.remove('loading-spinner');
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

function getAlertDom(params) {
    return `
        <div id="contact-form-response"
            class="contact-form-response tc-alert ${params.class} text-center">
                ${params.icon} <span>${params.message}</span>
        </div>
    `;
}
