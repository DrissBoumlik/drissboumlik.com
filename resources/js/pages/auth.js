
$(function () {
    try {
        let show_password_btn = $('.show-password');
        if (show_password_btn.length) {
            show_password_btn.on('click', function () {
                let input_password = $(this).siblings('input');
                let type, icon;
                if (input_password.attr('type') === 'text') {
                    type = 'password';
                    icon = "<i class='fa-solid fa-eye'></i>";
                } else {
                    type = 'text';
                    icon = "<i class='fa-solid fa-eye-slash'></i>";
                }
                $(this).html(icon);
                input_password.attr('type', type);
            });
        }
    } catch (error) {
        console.log(error);
    }
});
