/* start*/
/**
* Function for load all Staus Call  
*/
function loadAllSubject() {
    let url = BaseUrl + "/subject/all";
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                getAllSubject(data)
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}

function getAllSubject(data) {  
    var num = 0;
    if (data.length > 0) {       
        
    let table = $('#subjectDatatables').DataTable();
    let dataSet = [];
    if (data == 'No record found.') {             
    }  else{        
        data.forEach(e => {           
            let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editsubject(this.id)"></i>
            <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deletesubject(this.id)"></i>`;
            let row = [++num, e.subject_name,action];
            dataSet.push(row);
        });
    }
    table.destroy();
    $('#subjectDatatables').DataTable({
        data: dataSet,
    });
    }   
  }

  /**
* Function for load Edit Status */

function editsubject(id) {
    let url = BaseUrl + "/subject/show/" + id;
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
                    $("#subject_name").val(data.subject_name);
                    $('#subjectid').val(data.id);
                    $(".save-subject").removeClass('save-subject').addClass('update-subject');
                    $(".add-new").removeClass('add-new').addClass('update-subject');
                    $(".update-subject").html('');
                    $(".update-subject").html('<i class="fas fa-edit mr-2"></i>Update');
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

function deletesubject(id) {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        let url = BaseUrl + "/subject/delete/" + id;
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
                        setTimeout(() => { loadAllSubject()}, 1000);  
                    }                   
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) { 
                        Notiflix.Notify.error(data.messages.success);  
                        setTimeout(() => { loadAllSubject()}, 1000);
                    }
                }
            });
    } else {

    }
}



$(function () {
    loadAllSubject();
    $(document).on('click', '.save-subject', function (e) {
        e.preventDefault();     
        let url = BaseUrl + '/subject/insert';
        let formData = $("#subjectForm").serialize();      

        if($("#subject_name").val()!=""){            
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
                  setTimeout(() => { loadAllSubject()}, 1000);  
                  }
              },
              error: function (jqxhr, eception) {
                Notiflix.Notify.warning(jqxhr.responseJSON.messages.location_name);
              }
          });
        }else{   
         
            
        }
    })
});

$(function () {
    loadAllSubject();
    $(document).on('click', '.update-subject', function (e) {
        e.preventDefault();
        var accountId = $('#subjectid').val();
        if (accountId > 0 && accountId != '') {
            let urli = BaseUrl + '/subject/update/' + accountId;
            let formData = $("#subjectForm").serialize();
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
                            setTimeout(() => { loadAllSubject()}, 1000);  
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
        $("#subject_name").focus();
        $(".add-new").removeClass('add-new').addClass('save-subject');
        $(".save-subject").html('');
        $(".save-subject").html('<i class="far fa-save mr-2"></i>Save');
      });


});

function hideAccountFeild(){
    $("#subject_name").val("");
    $("#inputField").removeClass("d-flex");
    $("#inputField").hide();
    $(".save-subject").removeClass('save-subject').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
    $(".update-subject").removeClass('update-subject').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
  } 