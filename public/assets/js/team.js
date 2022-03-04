/* start*/
/**
* Function for load all Staus Call  
*/
function loadAllTeam() {
    let url = BaseUrl + "/team/all";
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                getAllTeam(data)
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}

function getAllTeam(data) {
    var num = 0;
    if (data.length > 0) {

        let table = $('#teamDatatables').DataTable();
        let dataSet = [];
        if (data == 'No record found.') {
        } else {
            data.forEach(e => { 
                let action = `<a href="teamview/${e.emp_id}"?><i class="fas fa-eye text-info"></i></a>               
                <i class="fas fa-trash-alt text-danger" id="${e.emp_id}"  onClick="deleteteam(this.id)"></i>`;
                let row = [++num, e.full_name, e.personal_email, e.office_number, e.sys_name, e.account_name, e.location_name, action];
                dataSet.push(row);
            });
        }
        table.destroy();
        $('#teamDatatables').DataTable({
            data: dataSet,
            "responsive": true,
        });
    }
}

/**
* Function for load Edit Status */

function editteam(id) {
    let url = BaseUrl + "/team/show/" + id;
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                if (data.emp_id > 0) {
                    console.log(data);
                    $("#inputField").show();
                    $("#inputField").addClass("d-flex");
                    $("#full_name").val(data.full_name);
                    $('#teamid').val(data.id);
                    $(".save-team").removeClass('save-team').addClass('update-team');
                    $(".add-new").removeClass('add-new').addClass('update-team');
                    $(".update-team").html('');
                    $(".update-team").html('<i class="fas fa-edit mr-2"></i>Update');
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
* Function for load Delete Status */

function deleteteam(id) {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        let url = BaseUrl + "/team/delete/" + id;       
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
                        Notiflix.Notify.success(data.messages.success);
                        setTimeout(() => { loadAllTeam() }, 1000);
                    }
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) {
                        Notiflix.Notify.error(data.messages.success);
                        setTimeout(() => { loadAllTeam() }, 1000);
                    }
                }
            });
    } else {
    }
}


function addTeam() {
    document.getElementById('addTeamcCard').style.display = "block";
    document.getElementById('addpage').style.display = "block";
    document.getElementById('listCard').style.display = "none";
    document.getElementById('listpage').style.display = "none";
}

function updateCardfun(){
    document.getElementById('UpdateCard').style.display = "block";
    document.getElementById('viewcard').style.display = "none";
}

function removeImage(){
    Notiflix.Confirm.show(
        'Profile Remove Confirm',
        'Are you sure?',
        'Yes',
        'No',
        function okCb() {
            let emp_id = $("#emp_id").val();   
            let urli = BaseUrl + `/team/deleteImage/${emp_id}`;
            $.ajax
            ({
                type: "put",
                headers: {
                    'email': email,
                    'password': passw,
                },
                url: urli,
                success: function (data) {
                    if (data.status === 200) {
                        Notiflix.Notify.success(data.messages.success);
                        setTimeout(() => { location.reload() }, 600);
                    }
                },
                error: function (jqxhr, eception) {                  
                    if (jqxhr.status == 404) {
                        Notiflix.Notify.failure(data.messages.success);                        
                    }
                }
            });
        },
        function cancelCb() {          
            Notiflix.Report.info('Your Profile is safe.','', 'close');
        },
        {
          width: '320px',
          borderRadius: '8px',
          // etc...
        },
      );
   
}

$(function () {
    loadAllTeam();

    $("form[name='TeamForm']").validate({

        rules: {
            full_name: "required",
            designation: "required",
            personal_email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8
            },
            office_number: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true
            },
            personal_number: {
                required: true,
                minlength: 10,
                maxlength: 10,
                number: true
            },
            gender: "required"
        },
        messages: {
            full_name: "Please enter your firstname",
            designation: "Please enter your designation",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
            },
            personal_email: "Please enter a valid email address",
            office_number: {
                required: "Please provide your office number",
                minlength: "Your number must be at least 10 digit long",
                maxlength: "Your number must be at least 10 digit long",
                number : "Number should be in numeric format.",
            },
            personal_number: {
                required: "Please provide your Personal number",
                minlength: "Your number must be at least 10 digit long",
                maxlength: "Your number must be at least 10 digit long",
                number : "Number should be in numeric format.",
            },
            gender: "Please select your gender"
        },
        submitHandler: function (form) {           
       
            let formData = $("#TeamForm").serialize();            
                let url = BaseUrl + '/team/insert';
                if (formData) {
                      $.ajax({
                        url: url,
                        type: "POST",
                        headers: {
                            'email': email,
                            'password': passw,
                        },
                        data: formData,
                        success: function (data) {
                            if (data.status === 200) {
                                Notiflix.Notify.success(data.messages.success);
                                setTimeout(() => { loadAllTeam() }, 1000);
                            }
                        },
                        error: function (jqxhr, eception) {
                            if (jqxhr.status == 404) {
                                Notiflix.Notify.success(data.messages.success);
                                setTimeout(() => { loadAllTeam() }, 1000);
                            }
                        }
                    });
                }            
            }
    });


    $('#updateTeam').on('submit', function (e) {
            e.preventDefault();    
            let formData = $("#updateTeam").serialize(); 
            let emp_id = $("#emp_id").val();            
            let urli = BaseUrl + `/team/update/${emp_id}`;

            console.log(formData);
            if (formData) {
                    $.ajax({
                    url: urli,
                    type: "put",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    data: formData,
                    success: function (data) {
                        if (data.status === 200) {
                            Notiflix.Notify.success(data.messages.success);
                            setTimeout(() => { location.reload() }, 1000);
                        }
                    },
                    error: function (jqxhr, eception) {
                        if (jqxhr.status == 404) {
                            Notiflix.Notify.success(data.messages.success);
                            setTimeout(() => { location.reload() }, 1000);
                        }
                    }
                });
            } 
    });

    $('#uploadForm').on('submit', function (e) {
        e.preventDefault();    
      
        let emp_id = $("#emp_id").val();            
        let urli = BaseUrl + `/team/insertImage/${emp_id}`;       
        var formData = new FormData(this);    
        if (emp_id>0) {
                $.ajax({
                url: urli,
                type: "post",
                headers: {
                    'email': email,
                    'password': passw,
                },
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {                
                    if (data.status === 200) {
                        document.getElementById("uploadForm").reset();
                        $('.uploadFormModel').modal('hide');
                        Notiflix.Notify.success(data.messages.success);
                        location.reload();                        
                    }
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) {
                        Notiflix.Notify.failure(data.messages.success);                       
                        setTimeout(() => { location.reload() }, 1000);
                    }
                }
            });
        } 
});


$("form[name='changePassForm']").validate({

    rules: {
        currentPassword: "required",
        newPassword: {
            required: true,
            minlength: 8
        },
        confirmPassword: {
            required: true,
            equalTo: "#newPassword"
        }        
    },
    messages: {
        currentPassword: "Please fill your current password.",       
        newPassword: {
            required: "Please provide a password",
            minlength: "Your password must be at least 8 characters long"
        },      
        confirmPassword: {
            required: "Confirm Password is required.",
            equalTo: "New password and confirm password not match."           
        }
    },
    submitHandler: function (form) {           
        
        let formData = $("#changePassForm").serialize();   
        let emp_id = $("#emp_id").val();                 
            let url = BaseUrl + `/team/passworChange/${emp_id}`;
            if (formData) {
                  $.ajax({
                    url: url,
                    type: "POST",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    data: formData,
                    success: function (data) {
                        console.log(data);
                        if (data.status === 200) {
                            document.getElementById("changePassForm").reset();
                            $('.passChangeModel').modal('hide');
                            Notiflix.Notify.success(data.messages.success);                            
                        }
                    },
                    error: function (jqxhr, eception) {                      
                        if (jqxhr.status == 404) {
                            Notiflix.Notify.failure(jqxhr.responseJSON.messages.error);                           
                        }else if(jqxhr.responseJSON.status==401){
                            Notiflix.Notify.failure(jqxhr.responseJSON.messages.error);   
                        }
                    }
                });
            }            
        }
});

});

