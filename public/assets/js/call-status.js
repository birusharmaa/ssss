/* start*/
/**
* Function for load all Staus Call 
*/
function loadAllStatus() {
    let url = BaseUrl + "/status/all";
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
        
    let table = $('#allstatus').DataTable();
    let dataSet = [];
    if (data == 'No record found.') {             
    }  else{        
        data.forEach(e => {           
            let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editStatus_click(this.id)"></i>
            <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deleteStatus_click(this.id)"></i>`;
            let row = [++num, e.title,e.description,action];
            dataSet.push(row);
        });
    }
    table.destroy();
    $('#allstatus').DataTable({
        data: dataSet,
    });
    }   
  }

  /**
* Function for load Edit Status */

function editStatus_click(id) {
    let url = BaseUrl + "/status/show/" + id;
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
                    $('#title').val(data.title);
                    $('#description').val(data.description);
                    $('#statusid').val(data.id);
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

function deleteStatus_click(id) {

    var proceed = confirm("Are you sure you want to proceed?");
    if (proceed) {
        let url = BaseUrl + "/status/delete/" + id;
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
                        setTimeout(() => { window.location.reload()}, 1000);  
                    }                   
                },
                error: function (jqxhr, eception) {
                    if (jqxhr.status == 404) { 
                        Notiflix.Notify.error(data.messages.success);  
                        setTimeout(() => { window.location.reload()}, 1000);
                    }
                }
            });
    } else {

    }
}

$(function () {

    loadAllStatus();
    $('#statusForm').on('submit', function (e) {
        e.preventDefault();
        var statusid = $('#statusid').val();
        if (statusid > 0 && statusid != '') {
            let urli = BaseUrl + '/status/update/' + statusid;
            let formData = $(this).serialize();
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
                            setTimeout(() => { window.location.reload()}, 1000);  
                        }
                    },
                    error: function (jqxhr, eception) {
                        if (jqxhr.status === 404) {  
                            Notiflix.Notify.error(data.messages);  
                            setTimeout(() => { window.location.reload()}, 1000);  
                        } 
                    }
                });                
            }
        } else {
            let url = BaseUrl + '/status/insert';
            let formData = $(this).serialize();
            if (formData) {
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
                        setTimeout(() => { window.location.reload()}, 1000);  
                        }
                    },
                    error: function (jqxhr, eception) {

                        if (jqxhr.status == 404) {
                            Notiflix.Notify.success(data.messages.success);  
                            setTimeout(() => { window.location.reload()}, 1000);  
                        }
                    }
                });
            }          
        }
    })

});