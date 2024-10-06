document.addEventListener('DOMContentLoaded', function () {
    try {
        let showPasswordButtons = document.querySelectorAll('.show-password');
        if (showPasswordButtons.length) {
            showPasswordButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    let inputPassword = this.previousElementSibling; // Assuming input is a sibling before the button
                    let type, icon;
                    if (inputPassword.type === 'text') {
                        type = 'password';
                        icon = "<i class='fa-solid fa-eye'></i>";
                    } else {
                        type = 'text';
                        icon = "<i class='fa-solid fa-eye-slash'></i>";
                    }
                    this.innerHTML = icon;
                    inputPassword.type = type;
                });
            });
        }
    } catch (error) {
        console.log(error);
    }
});
