const firstCaps = (str) => {
    const str2 = str.charAt(0).toUpperCase() + str.slice(1);
    return str2;
}

$(function () {
    $('body').on('click', '.next-followup-btn', function (e) {
        e.preventDefault();
        let lead_id = $(this).attr('data-id');

        let lead_name = $(this).attr('data-lead-title');
        $('#lead_id').val(lead_id);
        $('#followupsModalLongTitle').text(firstCaps(lead_name));
        $('#followupsModal').modal('toggle');

    });

    /**
     * Event to show call status fields
     */

    $('body').on('change', '#calltype', function () {
        $('#callstatus').removeClass('d-none');
    });

    /**
     * Event for load subject, followup, comment and submit button on change
     */
    $('body').on('change', '#callstatussel', function () {
        let id = $('#callstatussel :selected').val();
        if ($(this).val() == 7) {
            $('#followup_div').removeClass('d-none');
        }
        $('#subject_div').removeClass('d-none');
        $('#comments_div').removeClass('d-none');
        $('#submit_btn').removeClass('d-none');
    });


    /**
     * Envets for update comments
     */

    $('#followps-lead-forms').on('submit', function (e) {
        e.preventDefault();
        let formData = $(this).serialize();
        let url = BaseUrl + '/api/updatecomments';
        $.ajax({
            type: "post",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            data: formData,
            success: function (data) {
                if (data.status == 200) {
                    $('#subject_div').addClass('d-none');
                    $('#comments_div').addClass('d-none');
                    $('#submit_btn').addClass('d-none');
                    $('#calltype').addClass('d-none');
                    $('#callstatus').addClass('d-none');
                    $('#followup_div').addClass('d-none');
                    $('#followupsModal').modal('hide');
                    Notiflix.Notify.success(data.message.success);
                    setTimeout(() => {
                        window.location.reload();
                    }, 600)

                } else {

                }
            }
        });
    });


    /**
        * Unsubscribe lead event
        */
    $('body').on('click', '.unsubscribe-leads', function () {

        let id = $(this).attr('data-id');
        let url = BaseUrl + '/api/unsubscribe-leads';
        let status = $(this).attr('status');
        let formData = { id, status }
        let message = (status == 1) ? 'Are you sure wnats to unsubscribe this lead?' : 'Are you sure wnats to subscribe this lead?';
        Notiflix.Confirm.show(
            'XLA Confirm',
            message,
            'Yes',
            'No',
            function okCb() {
                $.ajax({
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    type: "post",
                    url: url,
                    data: formData,
                    success: function (data) {
                        if (!data.error) {
                            Notiflix.Notify.success(data.message.success);
                            setTimeout(() => { window.location.reload() }, 1000)

                        } else {
                            Notiflix.Notify.warning(data.message);
                        }
                    },
                    error: function (jqxhr, data) {
                        console.log(jqxhr);
                    }
                });
            },
            function cancelCb() {
                return false;
            },
            {
                width: '320px',
                borderRadius: '8px',

            },
        );
    })
});