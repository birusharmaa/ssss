/**
 * Function for load all users except admin from DB
 */
 function loadAllUses() {
    let url = BaseUrl + "/api/users";
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
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
            headers: {
                'email': email,
                'password': passw,
            },
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

/* Shalu code start*/
/**
* Function for load all Category except admin from DB
*/
function loadAllCategories() {
    let url = BaseUrl + "/catapi/categories";
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                getAllCategory(data)
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}

function getAllCategory(data) {
    let html = ``;
    let html2 = ``;
    var first = 0;
    var num = 0;
    if (data.length > 0) {        
        html2 += `<option>select</option>`;
        data.forEach((c) => {
            html2 += `<option value="${c.id}"> ${c.title} </option>`;
        });
    } else {
        html = '<tr><td colspan="3">No Record found</td></tr>';
        html2 = '<option>No Record found</option>';
    }   
    $('#allCategory').html(html);   

    /**
     * Datatable of all Category.
     */

    let table = $('#allCategory').DataTable();
    let dataSet = [];
    if (data) {
        data.forEach(e => {
            if (first == 0) { first = e.id; }
            let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editCat_click(this.id)"></i>
            <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deleteCat_click(this.id)"></i>`;
            let title =`<a href= "#" style="color: #000000;" onclick="loadAllSubCategories(${e.id})">${e.title}</a>`;
            let row = [++num, title,action];
            dataSet.push(row);
        });
    }
    $('#Catfirstid').val(first);
    table.destroy();
    $('#allCategory').DataTable({
        data: dataSet,
    });

    $('#selCat1').html(html2);
    loadAllSubCategories(first); 

}
/**
* Function for load all SubCategory from DB
*/
function loadAllSubCategories(id) {
    let url = BaseUrl + `/subapi/subcategories/${id}`;
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {

                getAllSubCategory(data);
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}

function getAllSubCategory(data) {
    let html = ``;

    if (data.length > 0) {
        var num = 0;
        var firstid = 0;
        html += ` <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">SubCategory</th>
          <th scope="col">Action</th>
        </tr>
      </thead><tbody>`;
        data.forEach((e) => {
            html += `<tr>
            <td>${++num}</td>
            <td>${e.title}</td>        
            <td>
            <i class="fas fa-edit text-info" id="${e.id}" onClick="editSubCat_click(this.id)"></i>
            <i class="fas fa-trash-alt text-danger" id="${e.id}" onClick="deleteSubCat_click(this.id)"></i>
          </tr>`;
        });

    } else {
        html = '<tr><td colspan="3">No Record found</td></tr>';
    }
    $('#SuballCategory').html(html);
}


/**
* Function for load Edit Category */

function editCat_click(id) {
    let url = BaseUrl + "/catapi/show/" + id;
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                if (data.id > 0) {
                    $('#CatName').val(data.title);
                    $('#CatNameid').val(data.id);
                } else {
                    alert('No data found');
                }
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}


/**
* Function for load Delete Category */

function deleteCat_click(id) {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        let url = BaseUrl + "/catapi/delete/" + id;
        $.ajax
            ({
                type: "delete",
                headers: {
                    'email': email,
                    'password': passw,
                },
                url: url,
                success: function (data) {

                    if (data.status === 200) {
                        message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> ${data.messages.success}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                        setTimeout(() => { $('#alertMessage').html(message); }, 600);
                    }
                    loadAllCategories();
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) {
                        message = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> ${data.messages.success}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;
                        setTimeout(() => { $('#alertMessage').html(message); }, 600);
                    }
                }
            });
    } else {

    }
}


/**
* Function for load Edit SubCategory */

function editSubCat_click(id) {
    let url = BaseUrl + "/subapi/show/" + id;
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {

                if (data.id > 0) {
                    $('#SubCatName').val(data.title);
                    $('#subCatNameid').val(data.id);
                    $('#selCat').val(data.cat_id);
                } else {
                    alert('No data found');
                }
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}


/**
* Function for load Delete Sub Category */

function deleteSubCat_click(id) {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        let url = BaseUrl + "/subapi/delete/" + id;
        $.ajax
            ({
                type: "delete",
                headers: {
                    'email': email,
                    'password': passw,
                },
                url: url,
                success: function (data) {
                    if (data.status === 200) {
                        message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> ${data.messages.success}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                        setTimeout(() => { $('#alertMessage').html(message); }, 600);
                    }
                    //loadAllSubCategories();

                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) {
                        message = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> ${data.messages.success}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;
                        setTimeout(() => { $('#alertMessage').html(message); }, 600);
                    }
                }
            });

        var first = $('#Catfirstid').val();
        loadAllSubCategories(first);
    } else {

    }
}
/* Shalu code end*/

/**
 * Block for run all the code segmanet when page is ready
 */
$(function () {

    /**
     * Function to load all users when load page
     */
    loadAllCategories();

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

    $('body').on('change', '#source-list', function () {
        let formData = {
            'userId': $('#user-list').val(),
            "sourceId": $(this).val(),
            'formDate': $('#from-date').val(),
            'toDate': $('#to-date').val()
        }
        /**
         * Function calling to send form data to the controller
         */
        loadDashBordData(formData);
    });

    $('body').on('change', '#from-date', function () {
        let formData = {
            'userId': $('#user-list').val(),
            "sourceId": $('#source-list').val(),
            'formDate': $(this).val(),
            'toDate': $('#to-date').val()
        }
        /**
         * Function calling to send form data to the controller
         */
        loadDashBordData(formData);
    })

    $('body').on('change', '#to-date', function () {
        let formData = {
            "toDate": $(this).val(),
            "sourceId": $('#source-list').val(),
            'formDate': $('#from-date').val(),
            'userId': $('#user-list').val()
        }
        /**
         * Function calling to send form data to the controller
         */
        loadDashBordData(formData);
    })

 

    $('#settingForm').on('submit', function (e) {
        e.preventDefault();
        let url = BaseUrl + '/api/setting';
        let formData = $(this).serialize();
        if (formData) {

            let message = '';
            $.ajax({
                type: "PUT",
                headers: {
                    'email': email,
                    'password': passw,
                },
                url: url,
                data: formData,
                success: function (data) {
                    if (data.status === 200) {
                        message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Setting!</strong> ${data.messages.success}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                        $('#alertMessage').html(message);
                        setTimeout(() => {
                            window.location.reload()
                        }, 600);
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
                        $('#alertMessage').html(message);
                        setTimeout(() => {
                            window.location.reload()
                        }, 600);
                    }
                }
            });
        }
    });

    $('#logo').on('change', function () {
        var formData = new FormData();
        formData.append('logo', $('#logo')[0].files[0]);
        $.ajax({
            url: BaseUrl + '/api/upload_logo',
            type: 'POST',
            data: formData,
            headers: {
                'email': email,
                'password': passw,
            },
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success: function (data) {
                if (data.data) {
                    $('#site_logo').val(data.data);
                }
            }
        });
    });

    $('#data-filter').on('keyup', function (e) {
        e.preventDefault();
        let query = $(this).val();
        let url = BaseUrl + '/leads/search/'
        let formData = {
            query
        }

        if (query) {
            $.ajax({
                type: 'Post',
                url: url,
                data: formData,
                headers: {
                    'email': email,
                    'password': passw,
                },
                success: function (data) {

                    let html = '';
                    if (data.error) {
                        html += `<option value="Not found"></option>`;
                    } else {
                        for (item of data.data) {
                            html += `<span><a href="${BaseUrl + '/admin/lead/' + item.id}">${item.Name}</a></span>`;
                        }

                    }
                    $('#searchlist').html(html);
                    $('#searchlist').removeClass('d-none');
                }
            });
        } else {
            $('#searchlist').addClass('d-none');
        }
    });


    /**
     * Shalu code
     */

    /**
    * Category insert and update
    */
    $('#categoryForm').on('submit', function (e) {
        e.preventDefault();
        var CatNameid = $('#CatNameid').val();
        console.log(CatNameid);
        if (CatNameid > 0 && CatNameid != '') {
            let url = BaseUrl + '/catapi/update/' + CatNameid;
            let formData = $(this).serialize();
            if (formData) {

                let message = '';
                $.ajax({
                    type: "PUT",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: url,
                    data: formData,
                    success: function (data) {
                        if (data.status === 200) {
                            message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> ${data.messages.success}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`;
                            setTimeout(() => { $('#alertMessage').html(message); }, 600);
                        } else if (jqxhr.status == 400) {
                            message = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong>${jqxhr.messages.title}
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
                            <strong>Error!</strong> ${data.messages}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                            setTimeout(() => { $('#alertMessage').html(message); }, 600);
                        }
                    }
                }); loadAllCategories();
            }
        } else {

            let url = BaseUrl + '/catapi/insert';
            let formData = $(this).serialize();
            //console.log(formData);
            if (formData) {

                let message = '';
                $.ajax({
                    type: "POST",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: url,
                    data: formData,
                    success: function (data) {
                        //console.log(data.message);
                        if (data.status === 200) {
                            message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> ${data.messages.success}
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
                        <strong>Error!</strong> ${data.messages}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;
                            setTimeout(() => { $('#alertMessage').html(message); }, 600);
                        } else if (jqxhr.status == 400) {

                            message = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> The Category Name must be at least 3 characters.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;
                            setTimeout(() => { $('#alertMessage').html(message); }, 600);
                        }
                    }
                }); loadAllCategories();
            }
        }
    })

    /**
  * SubCategory insert and update
  */
    $('#subcategoryForm').on('submit', function (e) {
        e.preventDefault();
        var subCatNameid = $('#subCatNameid').val();

        if (subCatNameid > 0 && subCatNameid != '') {
            let url = BaseUrl + '/subapi/update/' + subCatNameid;
            let formData = $(this).serialize();
            if (formData) {

                let message = '';
                $.ajax({
                    type: "PUT",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: url,
                    data: formData,
                    success: function (data) {
                        if (data.status === 200) {
                            message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> ${data.messages.success}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>`;
                            setTimeout(() => { $('#alertMessage').html(message); }, 600);

                        }
                    },
                    error: function (jqxhr, eception) {
                        if (jqxhr.status === 404) {
                            message = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> ${data.messages}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                            setTimeout(() => { $('#alertMessage').html(message); }, 600);
                        } else if (jqxhr.status == 400) {
                            message = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> Please, select category.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>`;
                            setTimeout(() => { $('#alertMessage').html(message); }, 600);
                        }
                    }
                });
                var first = $('#Catfirstid').val();
                loadAllSubCategories(first);
            }
        } else {
            let url = BaseUrl + '/subapi/insert';
            let formData = $(this).serialize();
            if (formData) {

                let message = '';
                $.ajax({
                    type: "POST",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: url,
                    data: formData,
                    success: function (data) {
                        if (data.status === 200) {
                            message = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> ${data.messages.success}
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
                        <strong>Error!</strong> ${data.messages}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;
                            setTimeout(() => { $('#alertMessage').html(message); }, 600);

                        } else if (jqxhr.status == 400) {
                            message = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Please, select category.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`;
                            setTimeout(() => { $('#alertMessage').html(message); }, 600);
                        }
                    }
                });
            }
            var first = $("select").val();           
            loadAllSubCategories(first);
        }
    })
})