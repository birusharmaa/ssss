/* start*/
/**
* Function for load all Staus Call  
*/
function hideAccountFeild(){
    $("#account_name").val("");
    $("#inputField").removeClass("d-flex");
    $("#inputField").hide();
    $(".save-account").removeClass('save-account').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
    $(".update-account").removeClass('update-account').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
  } 

function loadAllStatus() {
    let url = BaseUrl + "/account/all";
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                getAllStatus(data)
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}

function getAllStatus(data) {  
    var num = 0;
    if (data.length > 0) {       
        
    let table = $('#accountDatatables').DataTable();
    let dataSet = [];
    if (data == 'No record found.') {             
    }  else{        
        data.forEach(e => {           
            let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editAcount(this.id)"></i>
            <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deleteAcount(this.id)"></i>`;
            let row = [++num, e.account_name,action];
            dataSet.push(row);
        });
    }
    table.destroy();
    $('#accountDatatables').DataTable({
        data: dataSet,
        "responsive": true,
        "columnDefs": [
            {
                "targets": [],
                "visible": false,
                "searchable": false
            },
            {
                "targets": [],
                "visible": false
            }
        ]
    });
    }   
  }

  /**
* Function for load Edit Status */

function editAcount(id) {
    let url = BaseUrl + "/account/show/" + id;
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
                  console.log(data);
                    $("#inputField").show();
                    $("#inputField").addClass("d-flex");
                    $("#account_name").val(data.account_name);
                    $('#accountId').val(data.id);
                    $(".save-account").removeClass('save-account').addClass('update-account');
                    $(".add-new").removeClass('add-new').addClass('update-account');
                    $(".update-account").html('');
                    $(".update-account").html('<i class="fas fa-edit mr-2"></i>Update Account');
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

function deleteAcount(id) {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        let url = BaseUrl + "/account/delete/" + id;
        console.log(url);
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
                        setTimeout(() => { loadAllStatus()}, 1000);  
                    }                   
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) { 
                        Notiflix.Notify.error(data.messages.success);  
                        setTimeout(() => { loadAllStatus()}, 1000);
                    }
                }
            });
    } else {

    }
}

$(function () {
    loadAllStatus();
    $(document).on('click', '.save-account', function (e) {
        e.preventDefault();
        let url = BaseUrl + '/account/insert';
        let formData = $("#acoountName").serialize();
        if($("#account_name").val()!=""){
          $.ajax({
              type: "POST",
              headers: {
                  'email': email,
                  'password': passw,
              },
              url: url,
              data: formData,
              success: function (data) {
                $("#account_name").val("");
                  if (data.status === 200) {                      
                  Notiflix.Notify.success(data.messages.success);  
                  setTimeout(() => { loadAllStatus()}, 1000);  
                  }
              },
              error: function (jqxhr, eception) {
                      Notiflix.Notify.warning(jqxhr.responseJSON.messages.account_name);  
              }
          });
        }
    })
});

$(function () {
    loadAllStatus();
    $(document).on('click', '.update-account', function (e) {
        e.preventDefault();
        var accountId = $('#accountId').val();
        if (accountId > 0 && accountId != '') {
            let urli = BaseUrl + '/account/update/' + accountId;
            let formData = $("#acoountName").serialize();
            if (formData) {
                $.ajax({
                    type: "put",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: urli,
                    data: formData,
                    success: function (data) {

                        if (data.status === 200) {
                            Notiflix.Notify.success(data.messages.success);
                            hideAccountFeild();  
                            setTimeout(() => { loadAllStatus()}, 1000);  
                        }
                    },
                    error: function (jqxhr, eception) {
                        if (jqxhr.status === 404) {  
                            Notiflix.Notify.error(data.messages);  
                            //setTimeout(() => { window.location.reload()}, 1000);  
                        } 
                    }
                });                
            }
        } else {
            let url = BaseUrl + '/account/insert';
            let formData = $("#acoountName").serialize();
              if($("#account_name").val()!=""){
                $.ajax({
                    type: "POST",
                    headers: {
                        'email': email,
                        'password': passw,
                    },
                    url: url,
                    data: formData,
                    success: function (data) {
                      console.log('ss00');
                        if (data.status === 200) {                      
                        Notiflix.Notify.success(data.messages.success);  
                        setTimeout(() => { loadAllStatus()}, 1000);  
                        }
                    },
                    error: function (jqxhr, eception) {
                            Notiflix.Notify.warning(jqxhr.responseJSON.messages.account_name);  
                    }
                });
              }
                    
        }
    })

});