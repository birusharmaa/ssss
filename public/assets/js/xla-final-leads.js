/**
 * Function to load followp list form database
 */
const loadFollowUpLeadsList = () => {
    let url = BaseUrl + `/api/followuplist`;
    $.ajax
        ({
            type: "get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                loadFollowUpTable(data.data)
            }
        });
}
/**
 * Function to load data form database usubscribed list
 */
const loadUnubscribeList = () => {
    let url = BaseUrl + `/api/unsubscribelist`;
    $.ajax
        ({
            type: "get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                loadUnSubTable(data.data);
            }
        });
}

/**
 * 
 * @param {array} data 
 */
const loadFollowUpTable = (data) => {
    let table = $('#assign-leads-table').DataTable();
    let dataSet = [];
    if (data) {

        data.forEach(e => {
            let name = `<a href="${BaseUrl+'/admin/add_lead/'+ e.id}" class="text-info">${e.Name}</a>`;
            let action = `<a href="#" class="unsubscribe-leads btn btn-outline-primary" data-id="${e.id}" status="${(e.Unsubscribe == 0)?1:0}"><i class="fas fa-strikethrough"></i>Unsubscribe</a>`;
            let row = [name, e.Email, e.Mob_1, e.Course_Value, action];
            dataSet.push(row);
        });

    }

    table.destroy();
    $('#assign-leads-table').DataTable({
        data: dataSet,
    });

}
/**
 * 
 * @param {array} data 
 */
const loadUnSubTable = (data) => {
    let table = $('#unsublead-leads-table').DataTable();
    let dataSet = [];
    if (data) {
        data.forEach(e => {
            let name = `<a href="${BaseUrl+'/admin/add_lead/'+ e.id}" class="text-info">${e.Name}</a>`;
            let action = `<a href="#" class=" btn btn-outline-primary" data-id="${e.id}"><i class="fas fa-strikethrough"></i>Unsubscribe</a>`;
            action = '';
            let row = [name, e.Email, e.Mob_1, e.Course_Value, action];
            dataSet.push(row);
        });
    }
    table.destroy();
    $('#unsublead-leads-table').DataTable({
        data: dataSet,
    });
}
/**
 * 
 * @param {string} status 
 * @param {string} message 
 */
const loadRes = (status, message) => {
    html = `<div class="alert ${status} alert-dismissible fade show mt-3" role="alert">
     ${message}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>`;
    $('#alertRes').html(html);
}

/**
 * 
 * @param {object} obj 
 */
const loadSubCategory = (obj) => {
    let html = `<option value="">Select</option>`;
    if (obj.length > 0) {
        for (item of obj) {
            html += `<option value="${item.id}">${item.title}</option>`;
        }
    } else {
        html = `<option value="">Not Found</option>`
    }
    $('#sub-category').html(html);
}

/**
 * 
 * @param {object} obj 
 */
const loadLeadView = (obj) => {
    let html = '';
    let assignHtml = '';
    if (obj) {
        let avatar = (obj.Photo != null && obj.Photo != '') ? obj.Photo : BaseUrl + '/public/assets/images/faces/face13.jpg';
        html += `<div class="card" style="width: 18rem;">
            <img class="card-img-top" src="${avatar}" alt="Card image cap">
            <div class="card-body">
            <h5 class="card-title">${obj.Name}</h5>
            <p class="card-text">Email: ${obj.Email}</p>
            <p class="card-text">Phone: ${obj.Mob_1}</p>
            <p class="card-text">Courese: ${obj.Course_Value}</p>
            </div>
        </div>`;
        assignHtml += `<div><button class="btn btn-info float-right mr-2" id="assignLeadToUser" data-id="${obj.id}">Follow Up</button></div>`;
        $('#lead_id').val(obj.id);
    }

    // <a href="#" class="btn btn-primary">More details</a>

    $('#leadViewContainer').html(html);
    $('#assignContainer').html(assignHtml);
}

/**
 * Function to load lead update form
 */
const loadLeadupdateForm = () => {
    $('#calltype').removeClass('d-none');
}


$(function () {

    /**
     * Function for get all the subcategory by category.
     */
    $('#lead-category').on('change', function () {

        let id = $(this).val();

        let url = BaseUrl + `/admin/subcategory/${id}`;
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
    })

    /**
     * Function for search data form leads by search event
     */
    $('#leadFilterForm').on('submit', function (e) {
        e.preventDefault();
        if ($('#lead-category').val() != '') {
            let formData = {
                'Enq_Course': $('#lead-category').val(),
                'subcategory': $('#sub-category').val(),
                'City': $('#city').val(),
                'From': $('#from-lead-date').val(),
                'To': $('#to-lead-date').val(),
            }
            let url = BaseUrl + `/api/lead-data`;
            $.ajax
                ({
                    type: "post",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: url,
                    data: formData,
                    success: function (data) {
                        if (data.data) {
                            loadLeadView(data.data);
                        } else {
                            Notiflix.Notify.info(data.messages.success);
                        }
                    },
                    error: function (jqxhr, data) {
                        console.log(jqxhr);
                    }

                });
        } else {
            alert('Category is required');
            return false
        }
    });

    /**
     * Event to assign leads to users
     */

    $('body').on('click', '#assignLeadToUser', function () {
        let url = BaseUrl + `/api/assignlead`;
        let leadId = $(this).attr('data-id');
        $.ajax
            ({
                type: "post",
                headers: {
                    'email': email,
                    'password': passw,
                },
                url: url,
                data: { id: leadId },
                success: function (data) {
                    if (data.status == 200) {
                        loadLeadupdateForm();
                    } else {
                        alert($data.message);
                    }

                },

            });
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

    $('#leadCommentUpdateForm').on('submit', function (e) {
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
                    loadRes('alert-success', data.message.success);
                    $('#subject_div').addClass('d-none');
                    $('#comments_div').addClass('d-none');
                    $('#submit_btn').addClass('d-none');
                    $('#calltype').addClass('d-none');
                    $('#callstatus').addClass('d-none');
                    $('#followup_div').addClass('d-none');
                    setTimeout(() => {
                        $('#leadFilterForm').trigger('submit')
                    }, 600);

                } else {
                    loadRes('alert-danger', data.message);
                }
            }
        });
    });

    /**
     * Load fresh data when click on all assign leads
     */
    $('#pills-assignedList-tab').on('click', function () {
        loadFollowUpLeadsList();
    });

    /**
     * Event for load fresh unsubscribed lead list
     */
    $('#pills-unsubslead-tab').on('click', function () {
        loadUnubscribeList();
    });

    /**
     * Unsubscribe lead event
     */
    $('body').on('click', '.unsubscribe-leads', function () {
         let id = $(this).attr('data-id');
         let status = $(this).attr('status');
         let url = BaseUrl + '/api/unsubscribe-leads';
         let formData = { id,status }
         
         Notiflix.Confirm.show(
                'XLA Confirm',
                'Are you sure wnats to unsubscribe this lead?',
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
                        loadFollowUpLeadsList();
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