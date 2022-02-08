$(function () {

    $('body').on('click', '.show-permission', function () {
        let id = $(this).attr('data-id');
        $(this).siblings('.active').removeClass('active');
        $(this).addClass('active');
        let url = BaseUrl + '/'
        $.ajax({
            type: "PUT",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            data: formData,
            success: function (data) {
                console.log(data);
            }
        });
    });

    /**
     * Select first item default
     */
    $(".show-permission").first().addClass("active");




});