$(function () {
    $('#general-setting-form').on('submit', function (e) {
        e.preventDefault();
        let empid = $('#employee_id').val();
        let url = BaseUrl + `/profile/update_general/${empid}`;
        let formData = $(this).serialize();
        if (formData) {
            $.ajax
                ({
                    type: "put",
                    headers: {
                        'email': 'demo@gmail.com',
                        'password': '12345',
                    },
                    url: url,
                    data: formData,
                    success: function (data) {
                        message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong></strong> ${data.messages.success}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
                        setTimeout(() => { $('#alertMessage').html(message); }, 600);
                    },
                    error: function (jqxhr, eception) {
                        if (jqxhr.status == 404) {
                            alert('No data found');
                        }
                    }
                });
        }
    });


    $('#update-password-form').on('submit', function (e) {
        e.preventDefault();


        let empid = $('#employee_id').val();
        let url = BaseUrl + `/profile/update_password/${empid}`;
        let formData = $(this).serialize();
        if (formData) {
            $.ajax
                ({
                    type: "PUT",
                    headers: {
                        'email': 'demo@gmail.com',
                        'password': '12345',
                    },
                    url: url,
                    data: formData,
                    success: function (data) {
                        message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong></strong> ${data.messages.success}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
                        setTimeout(() => { $('#alertMessage').html(message); }, 600);
                    },
                    error: function (jqxhr, eception) {
                        if (jqxhr.status == 404) {
                            alert('No data found');
                        }
                    }
                });
        }
    });

    // $('#update-image-form').on('submit', function (e) {
    //     e.preventDefault();
    //     let empid = $('#employee_id').val();
    //     let url = BaseUrl + `/profile/update_password/${empid}`;
    //     let formData = $(this).serialize();
    //     if (formData) {
    //         $.ajax
    //             ({
    //                 type: "put",
    //                 headers: {
    //                     'email': 'demo@gmail.com',
    //                     'password': '123456789',
    //                 },
    //                 url: url,
    //                 data: formData,
    //                 success: function (data) {
    //                     message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
    //                 <strong></strong> ${data.messages.success}
    //                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    //                     <span aria-hidden="true">&times;</span>
    //                 </button>
    //             </div>`;
    //                     setTimeout(() => { $('#alertMessage').html(message); }, 600);
    //                 },
    //                 error: function (jqxhr, eception) {
    //                     if (jqxhr.status == 404) {
    //                         alert('No data found');
    //                     }
    //                 }
    //             });
    //     }
    // });

    $('#update-image-form').on('submit', (function (e) {
        e.preventDefault();
        let empid = $('#employee_id').val();
        let url = BaseUrl + `/profile/image_update/${empid}`;
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            headers: {
                'email': 'demo@gmail.com',
                'password': '12345',
            },
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong></strong> ${data.messages.success}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
                setTimeout(() => { $('#alertMessage').html(message); }, 600);
            }

        });
    }));

    $("#uploadImage").on("click", function () {
        $("#update-image-form").submit();
    });


})