/**
 * Function for load all users except admin from DB
 */
function loadAllUses() {
    let url = BaseUrl + "/api/users";
    $.ajax
        ({
            type: "Get",
            url: url,
            success: function (data) {
                updateUserSelect(data.data)
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}
/**
 * Function for load all the users in forntend
 * 
 * @param {Array} data 
 */
function updateUserSelect(data) {
    let html = '<option id="">Select</option>';
    if (data.length > 0) {
        data.forEach(element => {
            html += `<option id="${element.emp_id}">${element.full_name}</option>'`
        });
    } else {
        html = '<option id="">No users</option>';
    }

    $('#user-list').html(html);
}


/**
 * Function for load all dashboard data form database
 */

function loadDashBordData(formData = null) {

    let url = BaseUrl + '/api/dashboad';
    $.ajax
        ({
            type: "post",
            url: url,
            data: formData,
            success: function (data) {
                loadDashboardWidget(data.data);
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}

/**
 * Function to print widgets on admin dashboard
 * 
 * @param {array} data 
 */
function loadDashboardWidget(data) {
    let html = ``;
    if (data.length > 0) {
        data.forEach(element => {
            html += `<div class="col-md-3 mt-2">
            <div class="card card-widgit">
              <div class="card-body">
                <div class="statistics-item">
                  <p>
                    ${element.title}
                  </p>
                  <h2>
                  ${element.count}
                  </h2>
                </div>
              </div>
            </div>
          </div>`
        });
    }

    /**
     * Updating the widgets container with fresh data
     */
    $('#widget-container').html(html);
}

/**
 * Block for run all the code segmanet when page is ready
 */
$(function () {
    /**
     * Function to load all users when load page
     */
    loadAllUses();

    /**
     * Change event for user select box to load dashboard data from DB
     */
    $('body').on('change', '#user-list', function () {
        let formData = {
            "userId": $(this).val(),
            "sourceId": $('#source-list').val(),
            'formDate': $('#from-date').val(),
            'toDate': $('#to-date').val()
        }
        /**
         * Function calling to send form data to the controller
         */
        loadDashBordData(formData);
    })

    $('#user-list').trigger("change");

    $('#settingForm').on('submit', function (e) {
        e.preventDefault();
        let url = BaseUrl + '/api/setting';
        let formData = $(this).serialize();
        if (formData) {

            let message = '';
            $.ajax({
                type: "PUT",
                url: url,
                data: formData,
                success: function (data) {
                    console.log(data.message);

                    if (data.status === 200) {
                        message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Setting!</strong> ${data.messages.success}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                        setTimeout(() => { $('#alertMessage').html(message); }, 600);
                    }
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) {
                        message = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Setting!</strong> ${data.messages}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;
                        setTimeout(() => { $('#alertMessage').html(message); }, 600);
                    }
                }
            });
        }
    })


})