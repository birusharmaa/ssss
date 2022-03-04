/* start*/
/**
* Function for load all Staus Call  
*/
function loadAlllocation() {
    let url = BaseUrl + "/location/all";
    $.ajax
        ({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                getAlllocation(data)
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
}

function getAlllocation(data) {  
    var num = 0;
    if (data.length > 0) {       
        
    let table = $('#locationDatatables').DataTable();
    let dataSet = [];
    if (data == 'No record found.') {             
    }  else{        
        data.forEach(e => {           
            let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editlocation(this.id)"></i>
            <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deletelocation(this.id)"></i>`;
            let row = [++num, e.location_name,action];
            dataSet.push(row);
        });
    }
    table.destroy();
    $('#locationDatatables').DataTable({
        data: dataSet,
        "responsive": true,
    });
    }   
  }

  /**
* Function for load Edit Status */

function editlocation(id) {
    let url = BaseUrl + "/location/show/" + id;
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
                    $("#location_name").val(data.location_name);
                    $('#locationid').val(data.id);
                    $(".save-location").removeClass('save-location').addClass('update-location');
                    $(".add-new").removeClass('add-new').addClass('update-location');
                    $(".update-location").html('');
                    $(".update-location").html('<i class="fas fa-edit mr-2"></i>Update');
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

function deletelocation(id) {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        let url = BaseUrl + "/location/delete/" + id;
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
                        setTimeout(() => { loadAlllocation()}, 1000);  
                    }                   
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) { 
                        Notiflix.Notify.error(data.messages.success);  
                        setTimeout(() => { loadAlllocation()}, 1000);
                    }
                }
            });
    } else {

    }
}



$(function () {
    loadAlllocation();
    $(document).on('click', '.save-location', function (e) {
        e.preventDefault();     
        let url = BaseUrl + '/location/insert';
        let formData = $("#locationForm").serialize();      

        if($("#location_name").val()!=""){            
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
                  setTimeout(() => { loadAlllocation()}, 1000);  
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
    loadAlllocation();
    $(document).on('click', '.update-location', function (e) {
        e.preventDefault();
        var accountId = $('#locationid').val();
        if (accountId > 0 && accountId != '') {
            let urli = BaseUrl + '/location/update/' + accountId;
            let formData = $("#locationForm").serialize();
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
                            setTimeout(() => { loadAlllocation()}, 1000);  
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
        $("#location_name").focus();
        $(".add-new").removeClass('add-new').addClass('save-location');
        $(".save-location").html('');
        $(".save-location").html('<i class="far fa-save mr-2"></i>Save');
      });


});

function hideAccountFeild(){
    $("#location_name").val("");
    $("#inputField").removeClass("d-flex");
    $("#inputField").hide();
    $(".save-location").removeClass('save-location').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
    $(".update-location").removeClass('update-location').addClass('add-new');
    $(".add-new").html('');
    $(".add-new").html('<i class="fas fa-plus mr-2"></i>Add New');
  } 