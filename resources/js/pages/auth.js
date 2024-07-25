
$(function () {
    try {
        let show_password_btn = $('.show-password');
        if (show_password_btn.length) {
            show_password_btn.on('click', function () {
                let input_password = $(this).siblings('input');
                let type = input_password.attr('type') === 'text' ? 'password' : 'text';
                input_password.attr('type', type);
            });
        }
    } catch (error) {
        console.log(error);
    }
});
