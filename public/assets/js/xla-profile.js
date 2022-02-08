$(function () {
    /**
     * Event for update profile general setting
     */
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
                        'email': email,
                        'password': passw,
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
                $('#alertMessage').html(message);
                        setTimeout(() => { window.location.reload() }, 600);
                    },
                    error: function (jqxhr, eception) {
                        if (jqxhr.status == 404) {
                            alert('No data found');
                        }
                    }
                });
        }
    });

    /**
     * Event for update password
     */

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
                        'email': email,
                        'password': passw,
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
                $('#alertMessage').html(message);
                        setTimeout(() => { 
                                window.location.href = BaseUrl +'/logout';
                        }, 600);
                    },
                    error: function (jqxhr, eception) {
                        if (jqxhr.status == 404) {
                            alert('No data found');
                        }
                    }
                });
        }
    });

    /**
     * Event for upload image for submit form
     */

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
                'email': email,
                'password': passw,
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

    /**
     * Event for remove profile pic
     */
    $('#remove-pic').on('click', function () {
        let cnf = confirm('Are you sure want to remove profile picture?');
        if (cnf) {
            let empid = $(this).attr('data-empid')
            let url = BaseUrl + `/profile/image_delete/${empid}`;
            $.ajax
                ({
                    type: "delete",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: url,
                    success: function (data) {
                        message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong></strong> ${data.messages.success}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;
                        $('#alertMessage').html(message);
                        setTimeout(() => { window.location.reload() }, 600);
                    },
                    error: function (jqxhr, eception) {
                        if (jqxhr.status == 404) {
                            alert('No data found');
                        }
                    }
                });
        } else {
            return false;
        }
    });
});