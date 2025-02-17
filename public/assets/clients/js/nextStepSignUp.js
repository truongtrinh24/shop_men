function processSignUp() {
    event.preventDefault();

    var username = $('#username').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirm-password').val();

    var errorMessagePassword = $('.error-message-password');
    var errorMessageConfirmPassword = $('.error-message-comfirm-password');

    $.ajax({
        url: 'http://localhost/shop/authenticate/processSignUpAccount',
        type: 'POST',
        data: {
            username: username,
            password: password,
            confirmPassword: confirmPassword
        },
        dataType: 'json',
        success: function(data) {
            if(data.success) {
                toastr.success('Đăng ký thành công thành công');

                setTimeout(function() {
                    window.location.href = data.redirect_url;
                }, 1000); 
            } else {
                if(data.error_messages['password']!= null) {
                    errorMessagePassword.html(data.error_messages['password']);
                } else {
                    errorMessagePassword.html('');
                }

                if(data.error_messages['confirmPassword']!= null) {
                    errorMessageConfirmPassword.html(data.error_messages['confirmPassword']);
                } else {
                    errorMessageConfirmPassword.html('');
                }
            }
        },
        error: function(error) {
            alert("An error occurred while authenticating");
        }

    });
}