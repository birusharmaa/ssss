$(document).ready(function() {
    loadtAllLeads();
});

function loadtAllLeads() {
    let url = BaseUrl + "/leadsApi/all";
    $.ajax({
        type: "Get",
        headers: {
            'email': email,
            'password': passw,
        },
        url: url,
        success: function (data) {
            getAllLeads(data)
        },
        error: function (jqxhr, eception) {
            if (jqxhr.status == 404) {
                alert('No data found');
            }
        }
    });
}

//Load datatables data
function getAllLeads(data) {
    let html = ``;
    var first = 0;
    var num = 0;
    table = $('#leads-table').DataTable();
    let dataSet = [];
    if (data) {
        data.forEach(e => {
            if (first == 0) { first = e.id; }
            // let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editCat_click(this.id)"></i>
            // <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deleteCat_click(this.id)"></i>`;
            // let title =`<a href= "#" style="color: #000000;" onclick="loadAllSubCategories(${e.id})">${e.title}</a>`;
            //console.log(e.FollowUp_Days);
            const d = new Date();
             
            let date = formatDate(d);
            finalDate = getNumberOfDays(date, e.FollowUp_Days);
            if(isNaN(finalDate)){
              finalDate = "";
            }else{
              finalDate = finalDate+" Days";
            }
            let name =`<a href= "#" class="text-info"  onclick="leadDetails(${e.id})">${e.Name}</a>`;
            let row = [++num, e.id, e.owner_name, e.source_name, name,e.Email,e.Mob_1, e.mob_2, finalDate, e.Enq_Dt, e.Follow_Up_Dt];
            dataSet.push(row);
        });
    }

    table.destroy();
    $('#leads-table').DataTable({
        data: dataSet,
    });
    //$('#leads-table').DataTable().ajax.reload();
}

//Get select user details
function leadDetails(id=null){
    if(id){
        let url = BaseUrl + "/leadsApi/show/"+id;
        $.ajax({
            type: "Get",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            success: function (data) {
                //getAllLeads(data)
                console.log(data.follow_comment);
                $("#counsellerStates").html("");

                if(data){
                    $('#userId').val(data.data['id']);
                    $('#userName').val(data.data['name']);
                    $('#userStatus').val(data.data['status']);
                    $("#userStatus select").val(data.data['status']);

                    $('#userFallow').val(data.data['FollouUp_Counts']);
                    $('#userLastCall').val(data.data['Enq_Dt']);
                    $('#userNextCall').val(data.data['Follow_Up_Dt']);
                    if(data.data['Unsubscribe']=="1"){
                      $('#subscribeYes').prop('checked', true);
                      $('#subscribeNo').prop('checked', false);
                    }else{
                      $('#subscribeNo').prop('checked', true);
                      $('#subscribeYes').prop('checked', false);
                    }
                }
                if(data.follow_comment.length>0){
                  $('#userId').val(data.data['id']);
                  for(var i=0; i<data.follow_comment.length; i++){
                    $("#counsellerStates").prepend(

                         '<div class="col-12 mt-2">'+data.follow_comment[i].comments+'</div>'+
                         '<div class="col-12 text-right">'+data.follow_comment[i].full_name+", "+data.follow_comment[i].fallow_comments_time+'</div>'
                      )
                  }
                   
                                          
                                          
                }
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
            }
        });
    }
}

//On key up or key change function
function fetchData(){
    let enqStatus = $("#enqStatus").val();
    let ownerId   = $("#ownerId option:selected").val();
    let sourceId  = $("#sourceId").val();
    let followUp = $("#followUp").val();
    let enqDate = $("#enqDate").val();
    let followUpDate = $("#followUpDate").val();
    let location = $("#location").val();
    let city = $("#city").val();

    let url = BaseUrl + "/leadsApi/fetchData";
    $.ajax({
        type: "POST",
        headers: {
            'email': email,
            'password': passw,
        },
        url: url,
        data:{
            "enqStatus":enqStatus,
            "ownerId" : ownerId,
            "sourceId" : sourceId,
            "followUp" : followUp,
            "enqDate" :enqDate,
            "followUpDate" : followUpDate,
            "location": location,
            "city": city
        },
        dataType:'json',
        success: function (data) {
            $('#totalLeads').text(data.total_leads[0].id);
            $('#totalLeadsLastMonth').text(data.total_leads_last_month[0].id);
            $('#currentLeads').text(data.current_leads[0].id);
            $('#currentLeadsLastMonth').text(data.current_leads_last_month[0].id);
            $('#openLeads').text(data.open_leads[0].id);
            $('#openLeadsLastMonth').text(data.open_leads_last_month[0].id);
            getAllLeads(data.details);
        },
        error: function (jqxhr, eception) {
            if (jqxhr.status == 404) {
                alert('No data found');
            }
        }
    });

}

//Change date formate
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;
    return [year, month, day].join('-');
}

//Get number of days
function getNumberOfDays(start, end) {
    const date1 = new Date(start);
    const date2 = new Date(end);

    // One day in milliseconds
    const oneDay = 1000 * 60 * 60 * 24;

    // Calculating the time difference between two dates
    const diffInTime = date2.getTime() - date1.getTime();

    // Calculating the no. of days between two dates
    const diffInDays = Math.round(diffInTime / oneDay);
    return diffInDays;
}

//Save comments
$(document).on('click', '#saveComments',function(){
    $(".validation").remove();
    var loadId = $("#userId").val();
    var comments = $("#comments").val();
    if(loadId==""){
        $("#comments").addClass("input-error");
        $("#comments").parent().append('<span class="text-danger validation">Please select lead.</span>');
    }

    if(comments=="" && loadId != ""){
        $("#comments").addClass("input-error");
        $("#comments").parent().append('<span class="text-danger validation">Please enter comment.</span>');
    }

    if(loadId && comments){
        let url = BaseUrl + "/leadsApi/saveComment";
        $.ajax({
            type: "POST",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            data:{
                "loadId":loadId,
                "comments" : comments
            },
            dataType:'json',
            success: function (data) {
                if(data.follow_comment.length>0){
                    $("#counsellerStates").html("");
                    for(var i=0; i<data.follow_comment.length; i++){
                        $("#counsellerStates").prepend(
                            '<div class="col-12 mt-2">'+data.follow_comment[i].comments+'</div>'+
                            '<div class="col-12 text-right">'+data.follow_comment[i].full_name+", "+data.follow_comment[i].fallow_comments_time+'</div>'
                        )
                    }
                    $("#comments").val("");
                    // swal({
                    //     title: "Success!",
                    //     text: "Your comment added successfully!",
                    //     icon: "success",
                    //     button: "OK",
                    // });
                    Swal.fire(
                      'Success!',
                      'Your comment added successfully!',
                      'success'
                    );                       
                }
            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
                if(jqxhr.responseJSON.messages.comments){
                    $("#comments").addClass("input-error");
                    $("#comments").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.comments+'</span>');
                }
                if(jqxhr.responseJSON.messages.loadId){
                    $("#comments").addClass("input-error");
                    $("#comments").parent().append('<span class="text-danger validation">Please select lead</span>');
                }
            }
        });
    }
});

//Save seleceted user details
$(document).on('click', '#saveUserDetials',function(){
    $(".validation").remove();

    var loadId = $("#userId").val();
    var userName = $("#userName").val();
    var userStatus = $("#userStatus").val();
    var userFallow = $("#userFallow").val();
    var userLastCall = $("#userLastCall").val();
    var userNextCall = $("#userNextCall").val();
    var unsubscribe = $('input[name="userUnsubscribe"]:checked').val();
    if(loadId==""){
        $("#userName").addClass("input-error");
        $("#userName").parent().append('<span class="text-danger validation">Please select lead.</span>');
    }

    if(userName=="" && loadId != ""){
        $("#userName").addClass("input-error");
        $("#userName").parent().append('<span class="text-danger validation">Please enter name.</span>');
    }

    if(userStatus=="" && loadId != ""){
        $("#userStatus").addClass("input-error");
        $("#userStatus").parent().append('<span class="text-danger validation">Please select status.</span>');
    }

    if(userFallow=="" && loadId != ""){
        $("#userFallow").addClass("input-error");
        $("#userFallow").parent().append('<span class="text-danger validation">Please enter follow up count.</span>');
    }

    if(userLastCall=="" && loadId != ""){
        $("#userLastCall").addClass("input-error");
        $("#userLastCall").parent().append('<span class="text-danger validation">Please select last call date.</span>');
    }

    if(userNextCall=="" && loadId != ""){
        $("#userNextCall").addClass("input-error");
        $("#userNextCall").parent().append('<span class="text-danger validation">Please select next call date.</span>');
    }

    if(unsubscribe=="" && loadId != ""){
        $("#unsubscribe").addClass("input-error");
        $("#unsubscribe").parent().append('<span class="text-danger validation">Please select unsubscribe value.</span>');
    }

    if(loadId && userName){
        let url = BaseUrl + "/leadsApi/updateUserDetails";
        $.ajax({
            type: "POST",
            headers: {
                'email': email,
                'password': passw,
            },
            url: url,
            data:{
                "loadId":loadId,
                "userName" : userName,
                "userStatus": userStatus,
                "userFallow": userFallow,
                "userLastCall":userLastCall,
                "userNextCall":userNextCall,
                "unsubscribe":unsubscribe
            },
            dataType:'json',
            success: function (data) {
                
                Swal.fire(
                  'Success!',
                  'User details changed successfully!',
                  'success'
                );  
                $("#userId").val("");
                $("#userName").val("");
                $("#userStatus").val("");
                $("#userFallow").val("");
                $("#userLastCall").val("");
                $("#userNextCall").val("");
                $('#subscribeYes').prop('checked', false);
                $('#subscribeNo').prop('checked', false);
                loadtAllLeads();

            },
            error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    alert('No data found');
                }
                if(jqxhr.responseJSON.messages.userStatus){
                    $("#userStatus").addClass("input-error");
                    $("#userStatus").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.userStatus+'</span>');
                }
                if(jqxhr.responseJSON.messages.userName){
                    $("#userName").addClass("input-error");
                    $("#userName").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.userName+'</span>');
                }
                if(jqxhr.responseJSON.messages.loadId && !jqxhr.responseJSON.messages.userName){
                    $("#userName").addClass("input-error");
                    $("#userName").parent().append('<span class="text-danger validation">Please select lead</span>');
                }
            }
        });
    }
});

$("#userName").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#userStatus").change(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#userFallow").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#comments").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

// Modal page js code
function onFileUpload(input, id) {
    id = id || '#ajaxImgUpload';
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(id).attr('src', e.target.result).width(300)
        };
        reader.readAsDataURL(input.files[0]);
    }
}    

$('#newLeadForm').on('submit', function(e) {
    e.preventDefault();
    $(".validation").remove();
    var formData = new FormData(this);
    let url = BaseUrl + '/leadsApi/insertLead';
    $.ajax({
        type: "POST",
        headers: {
            'email': email,
            'password': passw,
        },
        url: url,
        cache: false,
        data: formData,
        processData: false,
        contentType: false,
       
        success: function (data) {
            var parseData = JSON.parse(data);
            if(parseData['status']=="failed"){
                if(parseData['errors']['FollouUpCounts']){
                    $("#FollouUpCounts").addClass("input-error");
                    $("#FollouUpCounts").parent().append('<span class="text-danger validation">'+parseData['errors']['FollouUpCounts']+'</span>');
                }
                if(parseData['errors']['FollowUpDays']){
                    $("#FollowUpDays").addClass("input-error");
                    $("#FollowUpDays").parent().append('<span class="text-danger validation">'+parseData['errors']['FollowUpDays']+'</span>');
                }
                if(parseData['errors']['followUpComment']){
                    $("#followUpComment").addClass("input-error");
                    $("#followUpComment").parent().append('<span class="text-danger validation">'+parseData['errors']['followUpComment']+'</span>');
                }
                if(parseData['errors']['keyComment']){
                    $("#keyComment").addClass("input-error");
                    $("#keyComment").parent().append('<span class="text-danger validation">'+parseData['errors']['keyComment']+'</span>');
                }
                if(parseData['errors']['status']){
                    $("#status").addClass("input-error");
                    $("#status").parent().append('<span class="text-danger validation">'+parseData['errors']['status']+'</span>');
                }
                if(parseData['errors']['courseValue']){
                    $("#courseValue").addClass("input-error");
                    $("#courseValue").parent().append('<span class="text-danger validation">'+parseData['errors']['courseValue']+'</span>');
                }
                if(parseData['errors']['email']){
                    $("#email").addClass("input-error");
                    $("#email").parent().append('<span class="text-danger validation">'+parseData['errors']['email']+'</span>');
                }
                if(parseData['errors']['enqCourse']){
                    $("#enqCourse").addClass("input-error");
                    $("#enqCourse").parent().append('<span class="text-danger validation">'+parseData['errors']['enqCourse']+'</span>');
                }
                if(parseData['errors']['leadEnqDate']){
                    $("#leadEnqDate").addClass("input-error");
                    $("#leadEnqDate").parent().append('<span class="text-danger validation">'+parseData['errors']['leadEnqDate']+'</span>');
                }
                
                if(parseData['errors']['leadOwner']){
                    $("#leadOwner").addClass("input-error");
                    $("#leadOwner").parent().append('<span class="text-danger validation">'+parseData['errors']['leadOwner']+'</span>');
                }
                if(parseData['errors']['location']){
                    $("#location").addClass("input-error");
                    $("#location").parent().append('<span class="text-danger validation">'+parseData['errors']['location']+'</span>');
                }
                if(parseData['errors']['mob_1']){
                    $("#mob_1").addClass("input-error");
                    $("#mob_1").parent().append('<span class="text-danger validation">'+parseData['errors']['mob_1']+'</span>');
                }
                if(parseData['errors']['mob_2']){
                    $("#mob_2").addClass("input-error");
                    $("#mob_2").parent().append('<span class="text-danger validation">'+parseData['errors']['mob_2']+'</span>');
                }
                if(parseData['errors']['name']){
                    $("#name").addClass("input-error");
                    $("#name").parent().append('<span class="text-danger validation">'+parseData['errors']['name']+'</span>');
                }
                if(parseData['errors']['source']){
                    $("#source").addClass("input-error");
                    $("#source").parent().append('<span class="text-danger validation">'+parseData['errors']['source']+'</span>');
                }
                if(parseData['errors']['status']){
                    $("#status").addClass("input-error");
                    $("#status").parent().append('<span class="text-danger validation">'+parseData['errors']['status']+'</span>');
                }
                if(parseData['errors']['sysName']){
                    $("#sysName").addClass("input-error");
                    $("#sysName").parent().append('<span class="text-danger validation">'+parseData['errors']['sysName']+'</span>');
                }
                if(parseData['errors']['leadUserName']){
                    $("#leadUserName").addClass("input-error");
                    $("#leadUserName").parent().append('<span class="text-danger validation">'+parseData['errors']['leadUserName']+'</span>');
                }
                if(parseData['errors']['leadCity']){
                    $("#leadCity").addClass("input-error");
                    $("#leadCity").parent().append('<span class="text-danger validation">'+parseData['errors']['leadCity']+'</span>');
                }
                if(parseData['errors']['leadLocation']){
                    $("#leadLocation").addClass("input-error");
                    $("#leadLocation").parent().append('<span class="text-danger validation">'+parseData['errors']['leadLocation']+'</span>');
                }
                if(parseData['errors']['enqDate']){
                    $("#enqDate").addClass("input-error");
                    $("#enqDate").parent().append('<span class="text-danger validation">'+parseData['errors']['enqDate']+'</span>');
                }
                if(parseData['errors']['FollowUpDate']){
                    $("#FollowUpDate").addClass("input-error");
                    $("#FollowUpDate").parent().append('<span class="text-danger validation">'+parseData['errors']['FollowUpDate']+'</span>');
                }
            }else{
                document.getElementById("newLeadForm").reset();
                loadtAllLeads();
                $("#leadModel").modal("hide");
                Swal.fire(
                  'Success!',
                  'New lead added successfully!',
                  'success'
                ); 
            }
        },
        error: function (jqxhr, eception) {
            console.log(jqxhr);
            if(jqxhr.status == 400){
                if(jqxhr.responseJSON.messages.FollouUpCounts){
                    $("#FollouUpCounts").addClass("input-error");
                    $("#FollouUpCounts").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.FollouUpCounts+'</span>');
                }

                if(jqxhr.responseJSON.messages.FollowUpDate){
                    $("#FollowUpDate").addClass("input-error");
                    $("#FollowUpDate").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.FollowUpDate+'</span>');
                }

                if(jqxhr.responseJSON.messages.FollowUpDays){
                    $("#FollowUpDays").addClass("input-error");
                    $("#FollowUpDays").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.FollowUpDays+'</span>');
                }

                if(jqxhr.responseJSON.messages.courseValue){
                    $("#courseValue").addClass("input-error");
                    $("#courseValue").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.courseValue+'</span>');
                }

                if(jqxhr.responseJSON.messages.enqCourse){
                    $("#enqCourse").addClass("input-error");
                    $("#enqCourse").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.enqCourse+'</span>');
                }

                if(jqxhr.responseJSON.messages.followUpComment){
                    $("#followUpComment").addClass("input-error");
                    $("#followUpComment").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.followUpComment+'</span>');
                }


                if(jqxhr.responseJSON.messages.keyComment){
                    $("#keyComment").addClass("input-error");
                    $("#keyComment").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.keyComment+'</span>');
                }

                if(jqxhr.responseJSON.messages.email){
                    $("#email").addClass("input-error");
                    $("#email").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.email+'</span>');
                }
                if(jqxhr.responseJSON.messages.leadCity){
                    $("#leadCity").addClass("input-error");
                    $("#leadCity").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.leadCity+'</span>');
                }
                if(jqxhr.responseJSON.messages.leadEnqDate){
                    $("#leadEnqDate").addClass("input-error");
                    $("#leadEnqDate").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.leadEnqDate+'</span>');
                }
                if(jqxhr.responseJSON.messages.leadLocation){
                    $("#leadLocation").addClass("input-error");
                    $("#leadLocation").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.leadLocation+'</span>');
                }
                if(jqxhr.responseJSON.messages.leadOwner){
                    $("#leadOwner").addClass("input-error");
                    $("#leadOwner").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.leadOwner+'</span>');
                }
                if(jqxhr.responseJSON.messages.mob_1){
                    $("#mob_1").addClass("input-error");
                    $("#mob_1").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.mob_1+'</span>');
                }
                if(jqxhr.responseJSON.messages.mob_2){
                    $("#mob_2").addClass("input-error");
                    $("#mob_2").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.mob_2+'</span>');
                }
                if(jqxhr.responseJSON.messages.name){
                    $("#name").addClass("input-error");
                    $("#name").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.name+'</span>');
                }
                if(jqxhr.responseJSON.messages.source){
                    $("#source").addClass("input-error");
                    $("#source").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.source+'</span>');
                }
                if(jqxhr.responseJSON.messages.status){
                    $("#status").addClass("input-error");
                    $("#status").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.status+'</span>');
                }
                if(jqxhr.responseJSON.messages.sysName){
                    $("#sysName").addClass("input-error");
                    $("#sysName").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.sysName+'</span>');
                }
                if(jqxhr.responseJSON.messages.leadUserName){
                    $("#leadUserName").addClass("input-error");
                    $("#leadUserName").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.leadUserName+'</span>');
                }                
            }
        }
    });
});


$("#FollouUpCounts").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#FollowUpDays").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#followUpComment").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#FollouUpCounts").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#keyComment").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#courseValue").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#email").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#enqCourse").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#leadEnqDate").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#leadEnqDate").change(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#mob_1").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#mob_2").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#name").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#sysName").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#leadUserName").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#leadCity").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#leadLocation").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#FollowUpDate").keyup(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#FollowUpDate").change(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#FollowUpDays").change(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#status").change(function(event) {
    var value = "";
    value = $("#status option:selected").text();
    $("#statusValue").val(value);
    $(this).parent().find('.validation').remove();
});
$("#enqCourse").change(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#leadOwner").change(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#source").change(function(event) {
    $(this).parent().find('.validation').remove();
});
$("#status").change(function(event) {
    $(this).parent().find('.validation').remove();
});


$('#import_form').on('submit', function (e) {
    e.preventDefault();
    $(".validation").remove();
    let url = BaseUrl + `/leadsApi/import`;
    var formData = new FormData(this);
    if (formData) {
        $.ajax({
            type: "post",
            url: url,
            data: formData,
            headers: {
                'email': email,
                'password': passw,
            },
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                if (data.status == 200) {
                    document.getElementById("import_form").reset();
                    loadtAllLeads();
                    $('#leadModelImport').modal('hide');
                    // Notiflix.Notify.success(data.messages.success);
                    // setTimeout(() => { window.location.reload() }, 600);
                    Swal.fire(
                        'Success!',
                        data.messages.success,
                        'success'
                    ); 
                }
                console.log("aaa");

            }, error: function (jqxhr, eception) {
                if (jqxhr.status == 404) {
                    // Notiflix.Notify.warning(data.messages.success);
                    // setTimeout(() => { window.location.reload() }, 600);
                    Swal.fire(
                        'Failed!',
                        data.messages.success,
                        'failed'
                    );
                }
                if(jqxhr.status == 400){
                    if(jqxhr.responseJSON.messages.file_csv){
                        $("#file_csv").addClass("input-error");
                        $("#file_csv").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.file_csv+'</span>');
                    }
                    if(jqxhr.responseJSON.messages.importCourseVaue){
                        $("#importCourseVaue").addClass("input-error");
                        $("#importCourseVaue").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.importCourseVaue+'</span>');
                    }else{
                        Swal.fire(
                            'Failed!',
                            jqxhr.responseJSON.messages.error,
                            'failed'
                        );
                    }
                }
            }
        });
    }
});

$("#importCourseVaue").change(function(event) {
    $(this).parent().find('.validation').remove();
});

$("#file_csv").change(function(event) {
    $(this).parent().find('.validation').remove();
});
