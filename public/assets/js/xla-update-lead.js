const loadSubCategory = (obj) => {

    let html = `<option value="">Select</option>`;
    if (obj.length > 0) {
        for (item of obj) {
            html += `<option value="${item.id}">${item.title}</option>`;
        }
    } else {
        html = `<option value="">Not Found</option>`
    }
    $('#subcategory').html(html);



}

$(function () {
    /**
     * Event for update profile general setting
     */
    $('#update-lead-form').on('submit', function (e) {
        e.preventDefault();
        let empid = $('#empid').val();
        let url = BaseUrl + `/leadsapi/update/${empid}`;
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

                        if (data.error) {
                            let errorlist = data.messages.error;
                            let errorhtml = '';
                            // const keys = Object.keys(errorlist);

                            Object.entries(errorlist).forEach((key) => {
                                errorhtml += `<li>${key}</li>`;
                            })

                            message = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong></strong> ${errorhtml}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                            $('#alertMessage').html(message);
                        } else {
                            message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong></strong> ${data.messages.success}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                            $('#alertMessage').html(message);
                            setTimeout(() => { window.location.reload() }, 600);
                        }

                    }

                });
        }
    });

    $('#new-lead-form').on('submit', function (e) {
        e.preventDefault();
        let url = BaseUrl + `/leadsapi/insert`;
        var formData = new FormData(this);
        if (formData) {
            $.ajax
                ({
                    type: "Post",
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
                        if (data.error) {
                            let errorlist = data.messages.error;
                            let errorhtml = '';
                            Object.entries(errorlist).forEach((key) => {
                                errorhtml += `<li>${key}</li>`;
                            })
                            Notiflix.Notify.success(errorhtml);
                            setTimeout(() => { window.location.reload() }, 600);
                        } else {
                            Notiflix.Notify.warning(data.messages.success);
                            setTimeout(() => { window.location.reload() }, 600);
                        }

                    }

                });
        }
    });


    /**
     * Import Leads
     */

    // $('#import_form').on('submit', function (e) {
    //     e.preventDefault();
    //     let url = BaseUrl + `/leadsapi/import`;
    //     var formData = new FormData(this);
    //     if (formData) {
    //         $.ajax
    //             ({
    //                 type: "post",
    //                 url: url,
    //                 data: formData,
    //                 headers: {
    //                     'email': email,
    //                     'password': passw,
    //                 },
    //                 cache: false,
    //                 contentType: false,
    //                 processData: false,
    //                 success: function (data) {
    //                     if (data.status == 200) {
    //                         document.getElementById("import_form").reset();
    //                         $('#leadModelImport').modal('hide');
    //                         Notiflix.Notify.success(data.messages.success);
    //                         setTimeout(() => { window.location.reload() }, 600);
    //                     }

    //                 }, error: function (jqxhr, eception) {

    //                     if (jqxhr.status == 404) {
    //                         Notiflix.Notify.warning(data.messages.success);
    //                         setTimeout(() => { window.location.reload() }, 600);
    //                     }
    //                 }
    //             });
    //     }
    // });


    $('#category').on('change', function () {

        let id = $(this).val();

        let url = BaseUrl + `/admin/subcategory/${id}`;
        console.log(url);
        $.ajax
            ({
                type: "get",
                headers: {
                    'email': email,
                    'password': passw,
                },
                url: url,
                success: function (data) {
                    loadSubCategory(data.data);
                }

            });

    });


    /**
     * Update lead
     */


    $('#update-add-lead').on('submit', function (e) {
        e.preventDefault();

        let leadid = $('#leadid').val();
        let url = BaseUrl + `/leadsapi/update_add/${leadid}`;
        let formData = $(this).serialize();
        if (formData) {
            $.ajax({
                type: "PUT",
                headers: {
                    'email': email,
                    'password': passw,
                },
                url: url,
                data: formData,
                success: function (data) {
                    if (data.error) {
                        let errorlist = data.messages.error;
                        let errorhtml = '';
                        Object.entries(errorlist).forEach((key) => {
                            errorhtml += `<li>${key}</li>`;
                        })
                        Notiflix.Notify.warning(errorhtml);
                    } else {
                        Notiflix.Notify.success(data.messages.success);
                        setTimeout(() => { window.location.reload() }, 1000);
                    }

                }

            });
        }
    });

});