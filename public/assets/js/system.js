/* start*/
/**
* Function for load all Staus Call  
*/
function loadAllSystem() {
    let url = BaseUrl + "/system/all";
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                getAllSystem(data)
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}

function getAllSystem(data) {  
    var num = 0;
    if (data.length > 0) {       
        
    let table = $('#systemDatatables').DataTable();
    let dataSet = [];
    if (data == 'No record found.') {             
    }  else{        
        data.forEach(e => {           
            let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editsystem(this.id)"></i>
            <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deletesystem(this.id)"></i>`;
            let row = [++num, e.sys_name,action];
            dataSet.push(row);
        });
    }
    table.destroy();
    $('#systemDatatables').DataTable({
        data: dataSet,
    });
    }   
  }

  /**
* Function for load Edit Status */

function editsystem(id) {
    let url = BaseUrl + "/system/show/" + id;
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
                    $("#sys_name").val(data.sys_name);
                    $('#systemid').val(data.id);
                    $(".save-system").removeClass('save-system').addClass('update-system');
                    $(".add-new").removeClass('add-new').addClass('update-system');
                    $(".update-system").html('');
                    $(".update-system").html('<i class="fas fa-edit mr-2"></i>Update');
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

function deletesystem(id) {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        let url = BaseUrl + "/system/delete/" + id;
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
                        setTimeout(() => { loadAllSystem()}, 1000);  
                    }                   
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) { 
                        Notiflix.Notify.error(data.messages.success);  
                        setTimeout(() => { loadAllSystem()}, 1000);
                    }
                }
            });
    } else {
    }
}



$(function () {
    loadAllSystem();
    $(document).on('click', '.save-system', function (e) {
        e.preventDefault();     
        let url = BaseUrl + '/system/insert';
        let formData = $("#systemForm").serialize();      

        if($("#sys_name").val()!=""){            
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
                  Notiflix.Notify.success(data.messages.success);  
                  hideAccountFeild(); 
                  setTimeout(() => { loadAllSystem()}, 1000);  
                  }
              },
              error: function (jqxhr, eception) {
                Notiflix.Notify.warning(jqxhr.responseJSON.messages.location_name);
              }
          });
        }else{   
        }
    })


    $(document).on('click', '.update-system', function (e) {
        e.preventDefault();
        var accountId = $('#systemid').val();
        if (accountId > 0 && accountId != '') {
            let urli = BaseUrl + '/system/update/' + accountId;
            let formData = $("#systemForm").serialize();
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
                            setTimeout(() => { loadAllSystem()}, 1000);  
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
        }
    })


    $(".add-new").click(function (e) {
        e.preventDefault();
        $("#inputField").show();
        $("#inputField").addClass("d-flex");
        $("#sys_name").focus();
        $(".add-new").removeClass('add-new').addClass('save-system');
        $(".save-system").html('');
        $(".save-system").html('<i class="far fa-save mr-2"></i>Save');
      });

});


function hideAccountFeild(){
    $("#sys_name").val("");
    $("#inputField").removeClass("d-flex");
    $("#inputField").hide();
    $(".save-system").removeClass('save-system').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
    $(".update-system").removeClass('update-system').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
  } 