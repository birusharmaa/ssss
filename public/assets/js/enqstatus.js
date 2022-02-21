/* start*/

/**
* Function for load all Staus Call  
*/

function loadAllenq() {
    let url = BaseUrl + "/enquiry/all";
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                getAllenq(data)
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}

function getAllenq(data) {  
    var num = 0;
    if (data.length > 0) {       
        
    let table = $('#enqDatatable').DataTable();
    let dataSet = [];
    if (data == 'No record found.') {             
    }  else{        
        data.forEach(e => {           
            let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editenq(this.id)"></i>
            <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deleteenq(this.id)"></i>`;
            let row = [++num, e.title, e.description,action];
            dataSet.push(row);
        });
    }
    table.destroy();
    $('#enqDatatable').DataTable({
        data: dataSet,
    });
    }   
  }

  /**
* Function for load Edit Status */

function editenq(id) {
    let url = BaseUrl + "/enquiry/show/" + id;
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
                    $("#title").val(data.title);
                    $("#descriptionField").show();
                    $("#descriptionField").addClass("d-flex");
                    $("#description").val(data.description);
                    $('#enqid').val(data.id);
                    $(".save-enq").removeClass('save-enq').addClass('update-enq');
                    $(".add-new").removeClass('add-new').addClass('update-enq');
                    $(".update-enq").html('');
                    $(".update-enq").html('<i class="fas fa-edit mr-2"></i>Update');
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

function deleteenq(id) {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        let url = BaseUrl + "/enquiry/delete/" + id;
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
                        setTimeout(() => { loadAllenq()}, 1000);  
                    }                   
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) { 
                        Notiflix.Notify.error(data.messages.success);  
                        setTimeout(() => { loadAllenq()}, 1000);
                    }
                }
            });
    } else {

    }
}

function hideFeild(){
    $("#title").val("");
    $("#inputField").removeClass("d-flex");
    $("#inputField").hide();
    $("#description").val("");
    $("#descriptionField").removeClass("d-flex");
    $("#descriptionField").hide();
    $(".save-enq").removeClass('save-enq').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
    $(".update-enq").removeClass('update-enq').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
  } 

$(function () {
    loadAllenq();
    $(document).on('click', '.save-enq', function (e) {
        e.preventDefault();
        let url = BaseUrl + '/enquiry/insert';
        let formData = $("#enqForm").serialize();
        
        if($("#title").val()!=""){
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
                  hideFeild();
                  setTimeout(() => { loadAllenq()}, 1000);  
                  }
              },
              error: function (jqxhr, eception) {
                      Notiflix.Notify.warning(jqxhr.responseJSON.messages.title);  
              }
          });
        }
    })
});

$(function () {
  
    $(document).on('click', '.update-enq', function (e) {
        e.preventDefault();
        var enqid = $('#enqid').val();
        if (enqid > 0 && enqid != '') {
            let urli = BaseUrl + '/enquiry/update/' + enqid;
            let formData = $("#enqForm").serialize();
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
                            hideFeild();
                            setTimeout(() => { loadAllenq()}, 1000);  
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

});

