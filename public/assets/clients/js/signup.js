function signUp() {
    event.preventDefault();

    var name = $('#name').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var phone = $('#phone').val();

    $.ajax({
        url: "http://localhost/shop/authenticate/processSignUp",
        type: "POST",
        data: {
            name: name,
            email: email,
            address: address,
            phone: phone
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                toastr.success('Nhập thông tin khách hàng thành công');

                setTimeout(function() {
                    window.location.href = data.redirect_url;
                }, 1000); 
            }else {
                if(data.error_messages['name'] != null ) {
                    $('.error-message-name').html(data.error_messages['name']);
                }else {
                    $('.error-message-name').html('');
                }

                if(data.error_messages['email'] != null ) {
                    $('.error-message-email').html(data.error_messages['email']);
                }else {
                    $('.error-message-email').html('');
                }

                if(data.error_messages['address'] != null ) {
                    $('.error-message-address').html(data.error_messages['address']);
                }else {
                    $('.error-message-address').html('');
                }

                if(data.error_messages['phone'] != null ) {
                    $('.error-message-phone').html(data.error_messages['phone']);
                }else {
                    $('.error-message-phone').html('');
                }
            }

        },
        error: function(error) {
            console.error("Lỗi khi gửi yêu cầu đăng ký:", error);
            alert("An error occurred while processing the request.");
        }
    });
}