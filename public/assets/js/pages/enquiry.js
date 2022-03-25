$(document).ready(function() {       
    $('#enqStatus').multiselect({   
        nonSelectedText: 'Select'        
    });
    $('#ownerId').multiselect({   
        nonSelectedText: 'Select'        
    });
    $('#sourceId').multiselect({   
        nonSelectedText: 'Select'        
    });
    $('#city').multiselect({   
        nonSelectedText: 'Select',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
    });
    $('#location').multiselect({   
        nonSelectedText: 'Select'        
    });
});

$.extend($.fn.dataTable.defaults, {
    responsive: true,
});
$(document).ready(function() {
    loadtAllLeads();
    //searchLeads();
});



//Select 2 declarition
$(document).ready(function() {
    $("#smartSms").select2({
        allowClear: false,
        minimumResultsForSearch: 5,
        placeholder: "Select",
        // theme: "classic"
    });

    $("#whatsApp").select2({
        allowClear: false,
        minimumResultsForSearch: -1,
        placeholder: "Select",
        selectOnClose: false,
    });

    $("#whatsApp").on("select2:select", function(evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });

    $("#bulkEmails").select2({
        allowClear: false,
        minimumResultsForSearch: -1,
        placeholder: "Select",
    });

    $(".multiselect-search").attr('onClick','appendData()');
    $(".loader").hide();
});

function appendData(){
    // let searchCity = $('.multiselect-search').val();
    // let url = BaseUrl + "/leadsApi/searchcity";
    // $.ajax({
    //     type: "POST",
    //     headers: {
    //         email: email,
    //         password: passw,
    //     },
    //     url: url,
    //     data: {
    //         searchCity: searchCity
    //     },
    //     dataType: "json",
    //     success: function(data) {
    //       if(data.cities){
    //         $("#city").empty();
    //         $('#city').multiselect('destroy');
    //         $.each(data.cities, function (i, citie) {
    //                 $("#city").append('<option value="' + citie.Value + '">' + citie.Text + '</option>');
    //         });
    //         $('#city').multiselect();
    //       }
            
    //     },
    //     error: function(jqxhr, eception) {
    //         if (jqxhr.status == 404) {
                
    //         }
    //     },
    // });
}



var currentTime = new Date();
var minDate = new Date(currentTime.getFullYear(), currentTime.getMonth(), 1);
var maxDate =  new Date(currentTime.getFullYear(), currentTime.getMonth() + 1, 0);

$("#enqDate").datepicker({
    autoclose: true,
    todayHighlight: false,
     minDate: minDate, 
    maxDate: maxDate ,
    beforeShow: function(){ 
        $(".ui-datepicker").css('font-size', 5)
    }
}).datepicker();

$("#followUpDate").datepicker({
    autoclose: true,
    todayHighlight: false,
}).datepicker();

$("#userLastCall").datepicker({
    autoclose: true,
    todayHighlight: false,
    orientation: "bottom",
}).datepicker();

$("#userNextCall").datepicker({
    autoclose: true,
    todayHighlight: false,
    orientation: "bottom",
    width: "300px",
}).datepicker();

$("#leadEnqDate").datepicker({
    autoclose: true,
    todayHighlight: false,
    orientation: "bottom",
    width: "300px",
}).datepicker();

$("#FollowUpDate").datepicker({
    autoclose: true,
    todayHighlight: false,
    orientation: "bottom",
    width: "300px",
}).datepicker();

$("#FollowUpDays").datepicker({
    autoclose: true,
    todayHighlight: false,
    orientation: "bottom",
    width: "300px",
}).datepicker();



const ChangeDateFormat = (oldDate) => {
    const date = new Date(oldDate);
    //extract the parts of the date
    let day = date.getDate();
    let month = date.getMonth() + 1;
    const year = date.getFullYear();
    if (day < 10) {
        day = `0${day}`;
    }
    if (month < 10) {
        month = "0" + month;
    }
    let finalDate = `${day + "-" + month + "-" + year}`;
    return finalDate;
};

function loadtAllLeads() {
    let url = BaseUrl + "/leadsApi/all";
    $.ajax({
        type: "Get",
        headers: {
            email: email,
            password: passw,
        },
        url: url,
        success: function(data) {
            getAllLeads(data);
        },
        error: function(jqxhr, eception) {
            if (jqxhr.status == 404) {
               
            }
        },
    });
}

//Load datatables data
function getAllLeads(data) {
    let html = ``;
    var first = 0;
    var num = 0;  
    let table = $("#leads-table").DataTable();  
    let dataSet = [];
    if (data) {
        num = data.length;
        data.forEach((e) => {
            if (first == 0) {
                first = e.id;
            }
            
            
            const d = new Date();
            let date = formatDate(d);
            let f_date = "";
            if(e.Follow_Up_Dt){
                f_date = ChangeDateFormat(e.Follow_Up_Dt);
            }
            
            let e_date = "";
            if(e.Enq_Dt){
                e_date = ChangeDateFormat(e.Enq_Dt);
            }
            
            finalDate = getNumberOfDays(date, e.FollowUp_Days);
            if(isNaN(finalDate)) {
                finalDate = "";
            } else {
                finalDate = finalDate + " Days";
            }


            let name = `<a href= "#" class="text-info"  onclick="leadDetails(${e.id}, this)">${e.Name}</a>`;
            let row = [
                num--,
                e.id,
                e.owner_name,
                name,
                e.Email,
                e.Mob_1,
                e.mob_2,
                e.source_name,
                finalDate,
                e_date,
                f_date,
            ];
            dataSet.push(row);
        });
    }
    //$("#leads-table").destroy();
    table.destroy();
    $("#leads-table").DataTable({
        data: dataSet,
        responsive: true,
        bFilter: false,
        pageLength: 20,
        bLengthChange: false, //thought this line could hide the LengthMenu
        bInfo: false,
        scrollY: "297px",
        paging: true,
        sDom: 'Rlfrtip',
        order:[1,"desc"],
        columnDefs: [
            {
                targets: [],
                visible: false,
                searchable: false,
            },
            {
                targets: [],
                visible: false,
            },
        ],
        scrollX: true,
        colResize: {
            isEnabled: true,
            hoverClass: 'dt-colresizable-hover',
            hasBoundCheck: true,
            minBoundClass: 'dt-colresizable-bound-min',
            maxBoundClass: 'dt-colresizable-bound-max',
            saveState: true,
            isResizable: function (column) {
                return column.idx !== 2;
            },
            onResize: function (column) {
                //console.log('...resizing...');
            },
            onResizeEnd: function (column, columns) {
                console.log('I have been resized!');
            },
            stateSaveCallback: function (settings, data) {
                let stateStorageName = window.location.pathname + "/colResizeStateData";
                localStorage.setItem(stateStorageName, JSON.stringify(data));
            },
            stateLoadCallback: function (settings) {
                let stateStorageName = window.location.pathname + "/colResizeStateData",
                data = localStorage.getItem(stateStorageName);
                return data != null ? JSON.parse(data) : null;
            }
        }
    });
}

function checkRowSelection(e) {
    $("#leads-table tbody tr").removeClass("selected");
    $(e).closest("tr").addClass("selected");
}


function myFunction(){
    if($("#userId").val()!=""){
        localStorage.setItem("changesSet", "Yes");
    }
}


if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
    localStorage.setItem("changesSet", "");
}

//Get select user details
function leadDetails(id = null, e) {
    var check = localStorage.getItem("changesSet");
    if(check=="Yes"){
        Swal.fire({
            title: 'Are you sure?',
            text: "Lead changes not saved yet. Do you really want to move this lead.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed){
                if(id){
                localStorage.setItem("changesSet", "");
                checkRowSelection(e);
                let url = BaseUrl + "/leadsApi/show/" + id;
                $.ajax({
                    type: "Get",
                    headers: {
                        email: email,
                        password: passw,
                    },
                    url: url,
                    success: function(data) {
                        //getAllLeads(data)
                        $("#counsellerStates").html("");

                        if (data) {
                            $("#counsellerStates").closest(".card-title").removeClass("d-none");
                            $("#userId").val(data.data["id"]);
                            $("#userName").val(data.data["name"]);
                            $("#userStatus").val(data.data["status"]);
                            $("#userStatus select").val(data.data["status"]);

                            $("#userFallow").val(data.comment_counts);
                            //$('#userLastCall').val(data.data['Enq_Dt']);

                            if (data.data["Enq_Dt"] && data.data["Enq_Dt"] != "0000-00-00") {
                                let enqDate = ChangeDateFormat(data.data["Enq_Dt"]);
                                $("#userLastCall").val(enqDate);
                            } else {
                                $("#userLastCall").val("");
                            }

                            if (
                                data.data["Follow_Up_Dt"] &&
                                data.data["Follow_Up_Dt"] != "0000-00-00"
                            ) {
                                let followUpDate = ChangeDateFormat(data.data["Follow_Up_Dt"]);
                                $("#userNextCall").val(followUpDate);
                            } else {
                                $("#userNextCall").val("");
                            }

                            if (data.data["Unsubscribe"] == "1") {
                                $("#subscribeYes").prop("checked", true);
                                $("#subscribeNo").prop("checked", false);
                            } else {
                                $("#subscribeNo").prop("checked", true);
                                $("#subscribeYes").prop("checked", false);
                            }
                        }
                        if (data.follow_comment.length > 0) {
                            $("#userId").val(data.data["id"]);
                            for (var i = 0; i < data.follow_comment.length; i++) {
                                $("#counsellerStates").prepend(
                                    '<div class="row"><div class="col-12 mt-2">' +
                                    data.follow_comment[i].comments +
                                    "</div>" +
                                    '<div class="col-12 text-right"><em>' +
                                    data.follow_comment[i].full_name +
                                    ", " +
                                    data.follow_comment[i].fallow_comments_time +
                                    "</em></div></div>"
                                );
                            }
                        }
                    },
                    error: function(jqxhr, eception) {
                        if (jqxhr.status == 404) {
                            
                        }
                    },
                });
              }
            }
        })
    }else{
        if(id){
            localStorage.setItem("changesSet", "");
            checkRowSelection(e);
            let url = BaseUrl + "/leadsApi/show/" + id;
            $.ajax({
                type: "Get",
                headers: {
                    email: email,
                    password: passw,
                },
                url: url,
                success: function(data) {
                    //getAllLeads(data)
                    $("#counsellerStates").html("");
                    if (data) {
                        $("#counsellerStates").closest(".card-title").removeClass("d-none");
                        $("#userId").val(data.data["id"]);
                        $("#userName").val(data.data["name"]);
                        $("#userStatus").val(data.data["status"]);
                        $("#userStatus select").val(data.data["status"]);
                        $("#userFallow").val(data.comment_counts);
                     
                        if (data.data["Enq_Dt"] && data.data["Enq_Dt"] != "0000-00-00") {
                            let enqDate = ChangeDateFormat(data.data["Enq_Dt"]);
                            $("#userLastCall").val(enqDate);
                        } else {
                            $("#userLastCall").val("");
                        }

                        if (data.data["Follow_Up_Dt"] &&
                            data.data["Follow_Up_Dt"] != "0000-00-00" ){
                            
                            let followUpDate = ChangeDateFormat(data.data["Follow_Up_Dt"]);
                            $("#userNextCall").val(followUpDate);
                        } else {
                            $("#userNextCall").val("");
                        }

                        if (data.data["Unsubscribe"] == "1") {
                            $("#subscribeYes").prop("checked", true);
                            $("#subscribeNo").prop("checked", false);
                        } else {
                            $("#subscribeNo").prop("checked", true);
                            $("#subscribeYes").prop("checked", false);
                        }
                    }
                    if (data.follow_comment.length > 0) {
                        $("#userId").val(data.data["id"]);
                        for (var i = 0; i < data.follow_comment.length; i++) {
                            $("#counsellerStates").prepend(
                                '<div class="row"><div class="col-12 mt-2">' +
                                data.follow_comment[i].comments +
                                "</div>" +
                                '<div class="col-12 text-right"><em>' +
                                data.follow_comment[i].full_name +
                                ", " +
                                data.follow_comment[i].fallow_comments_time +
                                "</em></div></div>"
                            );
                        }
                    }
                },
                error: function(jqxhr, eception) {
                    if (jqxhr.status == 404) {
                      
                    }
                },
            });
        }
    }
}

getStatus = function(e){
    var values ="";
    values 
    return values;
}

function fetchDatasss(e, type=null){
    var userDate = $("#"+type).val();
    if(userDate.length==6){
        var d = userDate.slice(0, 2); 
        var m = userDate.slice(2, 4); 
        var y = userDate.slice(4, 6); 
        let currentyear =  new Date().getFullYear();
        var current_y = currentyear.toString().slice(2, 4);
        console.log(current_y+" = "+y);
        if(current_y<=y){
           var finalDate = d+"-"+m+"-"+"20"+y; 
        }else{
          var finalDate = d+"-"+m+"-"+"20"+y;
        }
        
        $("#"+type).val(finalDate);
    }
    if(userDate.length==8){
        var d = userDate.slice(0, 2); 
        var m = userDate.slice(2, 4); 
        var y = userDate.slice(4, 8); 
        var finalDate = d+"-"+m+"-"+y;
        $("#"+type).val(finalDate);
    }
}
//On key up or key change function
function fetchData(e, type = null, val = null){

    let enqStatus = $('#enqStatus').val();
    let ownerId = $('#ownerId').val();
    let sourceId = $("#sourceId").val();
    let followUp = $("#followUp").val();
    let enqDate = $("#enqDate").val();
    let followUpDate = $("#followUpDate").val();
    let location = $("#location").val();
    let city = $("#city").val();

    let url = BaseUrl + "/leadsApi/fetchData";
    $.ajax({
        type: "POST",
        headers: {
            email: email,
            password: passw,
        },
        url: url,
        data: {
            enqStatus: enqStatus,
            ownerId: ownerId,
            sourceId: sourceId,
            followUp: followUp,
            enqDate: enqDate,
            followUpDate: followUpDate,
            location: location,
            city: city,
        },
        dataType: "json",
        success: function(data) {
            $("#totalLeads").text(data.total_leads[0].id);
            $("#totalLeadsLastMonth").text(data.total_leads_last_month[0].id);
            $("#currentLeads").text(data.current_leads[0].id);
            $("#currentLeadsLastMonth").text(data.current_leads_last_month[0].id);
            $("#openLeads").text(data.open_leads[0].id);
            $("#openLeadsLastMonth").text(data.open_leads_last_month[0].id);
            getAllLeads(data.details);
        },
        error: function(jqxhr, eception) {
            if (jqxhr.status == 404) {
                
            }
        },
    });
}

//On key up or key change function
function searchValue() {
    let enqStatus = $("#enqStatus").val();
    let ownerId = $("#ownerId option:selected").val();
    let sourceId = $("#sourceId").val();
    let followUp = $("#followUp").val();
    let enqDate = $("#enqDate").val();
    let followUpDate = $("#followUpDate").val();
    let location = $("#location").val();
    let city = $("#city").val();
    let searchValue = $("#searchValue").val();

    let url = BaseUrl + "/leadsApi/searchValue";
    $.ajax({
        type: "POST",
        headers: {
            email: email,
            password: passw,
        },
        url: url,
        data: {
            enqStatus: enqStatus,
            ownerId: ownerId,
            sourceId: sourceId,
            followUp: followUp,
            enqDate: enqDate,
            followUpDate: followUpDate,
            location: location,
            city: city,
            searchValue: searchValue,
        },
        dataType: "json",
        success: function(data) {
            getAllLeads(data.details);
        },
        error: function(jqxhr, eception) {
            if (jqxhr.status == 404) {
                // alert("No data found");
            }
        },
    });
}

//Change date formate
function formatDate(date) {
    var d = new Date(date),
    month = "" + (d.getMonth() + 1),
    day = "" + d.getDate(),
    year = d.getFullYear();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;
    return [year, month, day].join("-");
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
$(document).on("click", "#saveComments", function() {
    $(".validation").remove();

    var loadId = $("#userId").val();
    var comments = $("#comments").val();
    var userName = $("#userName").val();
    var userStatus = $("#userStatus").val();
    var userLastCall = $("#userLastCall").val();
    var userNextCall = $("#userNextCall").val();
    var unsubscribe = $('input[name="userUnsubscribe"]:checked').val();

    if (loadId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to save lead details and key comment.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!'
        }).then((result) => {
            if (result.isConfirmed) {
              localStorage.setItem("changesSet", "");
                let url = BaseUrl + "/leadsApi/saveComment";
                $.ajax({
                    type: "POST",
                    headers: {
                        email: email,
                        password: passw,
                    },
                    url: url,
                    data: {
                        loadId: loadId,
                        comments: comments,
                        userName: userName,
                        userStatus: userStatus,
                        userLastCall: userLastCall,
                        userNextCall: userNextCall,
                        unsubscribe: unsubscribe,
                    },
                    dataType: "json",
                    success: function(data) {
                        loadtAllLeads();
                        $("#userId").val("");
                        if (data.follow_comment.length > 0) {
                            $("#counsellerStates").html("");
                            for (var i = 0; i < data.follow_comment.length; i++) {
                                $("#counsellerStates").prepend(
                                    '<div class="row"><div class="col-12 mt-2">' +
                                    data.follow_comment[i].comments +
                                    "</div>" +
                                    '<div class="col-12 text-right">' +
                                    data.follow_comment[i].full_name +
                                    ", " +
                                    data.follow_comment[i].fallow_comments_time +
                                    "</div></div>"
                                );
                            }
                            $("#comments").val("");
                            Swal.fire("Success!", "Lead updated successfully!", "success");
                        }
                    },
                    error: function(jqxhr, eception) {
                        if (jqxhr.status == 404) {
                            //alert("No data found");
                        }
                        if (jqxhr.responseJSON.messages.comments) {
                            $("#comments").addClass("input-error");
                            $("#comments")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.comments +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.loadId) {
                            $("#comments").addClass("input-error");
                            $("#comments")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">Please select lead</span>'
                                );
                        }
                    },
                });
            }
        })
    } else {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Please select lead.',
            showConfirmButton: false,
            timer: 1500
        })
    }
});

//Save seleceted user details
$(document).on("click", "#saveUserDetials", function() {
    $(".validation").remove();

    var loadId = $("#userId").val();
    var userName = $("#userName").val();
    var userStatus = $("#userStatus").val();
    var userFallow = $("#userFallow").val();
    var userLastCall = $("#userLastCall").val();
    var userNextCall = $("#userNextCall").val();
    var unsubscribe = $('input[name="userUnsubscribe"]:checked').val();
    if (loadId == "") {
        $("#userName").addClass("input-error");
        $("#userName")
            .parent()
            .append(
                '<span class="text-danger validation">Please select lead.</span>'
            );
    }

    if (userName == "" && loadId != "") {
        $("#userName").addClass("input-error");
        $("#userName")
            .parent()
            .append('<span class="text-danger validation">Please enter name.</span>');
    }

    if (userStatus == "" && loadId != "") {
        $("#userStatus").addClass("input-error");
        $("#userStatus")
            .parent()
            .append(
                '<span class="text-danger validation">Please select status.</span>'
            );
    }

    if (userFallow == "" && loadId != "") {
        $("#userFallow").addClass("input-error");
        $("#userFallow")
            .parent()
            .append(
                '<span class="text-danger validation">Please enter follow up count.</span>'
            );
    }

    if (userLastCall == "" && loadId != "") {
        $("#userLastCall").addClass("input-error");
        $("#userLastCall")
            .parent()
            .append(
                '<span class="text-danger validation">Please select last call date.</span>'
            );
    }

    if (userNextCall == "" && loadId != "") {
        $("#userNextCall").addClass("input-error");
        $("#userNextCall")
            .parent()
            .append(
                '<span class="text-danger validation">Please select next call date.</span>'
            );
    }

    if (unsubscribe == "" && loadId != "") {
        $("#unsubscribe").addClass("input-error");
        $("#unsubscribe")
            .parent()
            .append(
                '<span class="text-danger validation">Please select unsubscribe value.</span>'
            );
    }

    if (loadId && userName) {
        let url = BaseUrl + "/leadsApi/updateUserDetails";
        $.ajax({
            type: "POST",
            headers: {
                email: email,
                password: passw,
            },
            url: url,
            data: {
                loadId: loadId,
                userName: userName,
                userStatus: userStatus,
                userFallow: userFallow,
                userLastCall: userLastCall,
                userNextCall: userNextCall,
                unsubscribe: unsubscribe,
            },
            dataType: "json",
            success: function(data) {
                Swal.fire("Success!", "User details changed successfully!", "success");
                $("#userId").val("");
                $("#userName").val("");
                $("#userStatus").val("");
                $("#userFallow").val("");
                $("#userLastCall").val("");
                $("#userNextCall").val("");
                $("#subscribeYes").prop("checked", false);
                $("#subscribeNo").prop("checked", false);
                loadtAllLeads();
            },
            error: function(jqxhr, eception) {
                if (jqxhr.status == 404) {
                    //alert("No data found");
                }
                if (jqxhr.responseJSON.messages.userStatus) {
                    $("#userStatus").addClass("input-error");
                    $("#userStatus")
                        .parent()
                        .append(
                            '<span class="text-danger validation">' +
                            jqxhr.responseJSON.messages.userStatus +
                            "</span>"
                        );
                }
                if (jqxhr.responseJSON.messages.userName) {
                    $("#userName").addClass("input-error");
                    $("#userName")
                        .parent()
                        .append(
                            '<span class="text-danger validation">' +
                            jqxhr.responseJSON.messages.userName +
                            "</span>"
                        );
                }
                if (
                    jqxhr.responseJSON.messages.loadId &&
                    !jqxhr.responseJSON.messages.userName
                ) {
                    $("#userName").addClass("input-error");
                    $("#userName")
                        .parent()
                        .append(
                            '<span class="text-danger validation">Please select lead</span>'
                        );
                }
            },
        });
    }
});

$("#userName").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#userStatus").change(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#userFallow").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#comments").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

// Modal page js code
function onFileUpload(input, id) {
    id = id || "#ajaxImgUpload";
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(id).attr("src", e.target.result).width(300);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

$("#newLeadForm").on("submit", function(e) {
    e.preventDefault();
    $(".validation").remove();
    var formData = new FormData(this);
    // Swal.fire({
    //     title: 'Are you sure?',
    //     text: "Do you want to save lead details.",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes, save it!'
    // }).then((result) => {
    //     if (result.isConfirmed) {

            let url = BaseUrl + "/leadsApi/insertLead";
            $.ajax({
                type: "POST",
                headers: {
                    email: email,
                    password: passw,
                },
                url: url,
                cache: false,
                data: formData,
                processData: false,
                contentType: false,

                success: function(data) {
                    var parseData = JSON.parse(data);
                    if (parseData["status"] == "failed") {
                        if (parseData["errors"]["FollouUpCounts"]) {
                            $("#FollouUpCounts").addClass("input-error");
                            $("#FollouUpCounts")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["FollouUpCounts"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["FollowUpDays"]) {
                            $("#FollowUpDays").addClass("input-error");
                            $("#FollowUpDays")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["FollowUpDays"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["followUpComment"]) {
                            $("#followUpComment").addClass("input-error");
                            $("#followUpComment")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["followUpComment"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["keyComment"]) {
                            $("#keyComment").addClass("input-error");
                            $("#keyComment")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["keyComment"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["status"]) {
                            $("#status").addClass("input-error");
                            $("#status")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["status"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["courseValue"]) {
                            $("#courseValue").addClass("input-error");
                            $("#courseValue")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["courseValue"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["email"]) {
                            $("#email").addClass("input-error");
                            $("#email")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["email"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["enqCourse"]) {
                            $("#enqCourse").addClass("input-error");
                            $("#enqCourse")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["enqCourse"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["leadEnqDate"]) {
                            $("#leadEnqDate").addClass("input-error");
                            $("#leadEnqDate")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["leadEnqDate"] +
                                    "</span>"
                                );
                        }

                        if (parseData["errors"]["leadOwner"]) {
                            $("#leadOwner").addClass("input-error");
                            $("#leadOwner")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["leadOwner"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["location"]) {
                            $("#location").addClass("input-error");
                            $("#location")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["location"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["mob_1"]) {
                            $("#mob_1").addClass("input-error");
                            $("#mob_1")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["mob_1"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["mob_2"]) {
                            $("#mob_2").addClass("input-error");
                            $("#mob_2")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["mob_2"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["name"]) {
                            $("#name").addClass("input-error");
                            $("#name")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["name"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["source"]) {
                            $("#source").addClass("input-error");
                            $("#source")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["source"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["status"]) {
                            $("#status").addClass("input-error");
                            $("#status")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["status"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["sysName"]) {
                            $("#sysName").addClass("input-error");
                            $("#sysName")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["sysName"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["leadUserName"]) {
                            $("#leadUserName").addClass("input-error");
                            $("#leadUserName")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["leadUserName"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["leadCity"]) {
                            $("#leadCity").addClass("input-error");
                            $("#leadCity")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["leadCity"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["leadLocation"]) {
                            $("#leadLocation").addClass("input-error");
                            $("#leadLocation")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["leadLocation"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["enqDate"]) {
                            $("#enqDate").addClass("input-error");
                            $("#enqDate")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["enqDate"] +
                                    "</span>"
                                );
                        }
                        if (parseData["errors"]["FollowUpDate"]) {
                            $("#FollowUpDate").addClass("input-error");
                            $("#FollowUpDate")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    parseData["errors"]["FollowUpDate"] +
                                    "</span>"
                                );
                        }
                    } else {
                        document.getElementById("newLeadForm").reset();
                        loadtAllLeads();
                        $("#leadModel").modal("hide");
                        Swal.fire("Success!", "New lead added successfully!", "success");
                    }
                },
                error: function(jqxhr, eception) {
                    console.log(jqxhr);
                    if (jqxhr.status == 400) {
                        if (jqxhr.responseJSON.messages.FollouUpCounts) {
                            $("#FollouUpCounts").addClass("input-error");
                            $("#FollouUpCounts")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.FollouUpCounts +
                                    "</span>"
                                );
                        }

                        if (jqxhr.responseJSON.messages.FollowUpDate) {
                            $("#FollowUpDate").addClass("input-error");
                            $("#FollowUpDate")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.FollowUpDate +
                                    "</span>"
                                );
                        }

                        if (jqxhr.responseJSON.messages.FollowUpDays) {
                            $("#FollowUpDays").addClass("input-error");
                            $("#FollowUpDays")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.FollowUpDays +
                                    "</span>"
                                );
                        }

                        if (jqxhr.responseJSON.messages.courseValue) {
                            $("#courseValue").addClass("input-error");
                            $("#courseValue")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.courseValue +
                                    "</span>"
                                );
                        }

                        if (jqxhr.responseJSON.messages.enqCourse) {
                            $("#enqCourse").addClass("input-error");
                            $("#enqCourse")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.enqCourse +
                                    "</span>"
                                );
                        }

                        if (jqxhr.responseJSON.messages.followUpComment) {
                            $("#followUpComment").addClass("input-error");
                            $("#followUpComment")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.followUpComment +
                                    "</span>"
                                );
                        }

                        if (jqxhr.responseJSON.messages.keyComment) {
                            $("#keyComment").addClass("input-error");
                            $("#keyComment")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.keyComment +
                                    "</span>"
                                );
                        }

                        if (jqxhr.responseJSON.messages.email) {
                            $("#email").addClass("input-error");
                            $("#email")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.email +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.leadCity) {
                            $("#leadCity").addClass("input-error");
                            $("#leadCity")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.leadCity +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.leadEnqDate) {
                            $("#leadEnqDate").addClass("input-error");
                            $("#leadEnqDate")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.leadEnqDate +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.leadLocation) {
                            $("#leadLocation").addClass("input-error");
                            $("#leadLocation")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.leadLocation +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.leadOwner) {
                            $("#leadOwner").addClass("input-error");
                            $("#leadOwner")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.leadOwner +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.mob_1) {
                            $("#mob_1").addClass("input-error");
                            $("#mob_1")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.mob_1 +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.mob_2) {
                            $("#mob_2").addClass("input-error");
                            $("#mob_2")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.mob_2 +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.name) {
                            $("#name").addClass("input-error");
                            $("#name")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.name +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.source) {
                            $("#source").addClass("input-error");
                            $("#source")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.source +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.status) {
                            $("#status").addClass("input-error");
                            $("#status")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.status +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.sysName) {
                            $("#sysName").addClass("input-error");
                            $("#sysName")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.sysName +
                                    "</span>"
                                );
                        }
                        if (jqxhr.responseJSON.messages.leadUserName) {
                            $("#leadUserName").addClass("input-error");
                            $("#leadUserName")
                                .parent()
                                .append(
                                    '<span class="text-danger validation">' +
                                    jqxhr.responseJSON.messages.leadUserName +
                                    "</span>"
                                );
                        }
                    }
                },
            });
    //     }
    // })
});

$("#FollouUpCounts").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#FollowUpDays").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#followUpComment").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#FollouUpCounts").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#keyComment").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#courseValue").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#email").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#enqCourse").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#leadEnqDate").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#leadEnqDate").change(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#mob_1").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#mob_2").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#name").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#sysName").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#leadUserName").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#leadCity").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#leadLocation").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#FollowUpDate").keyup(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#FollowUpDate").change(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#FollowUpDays").change(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#status").change(function(event) {
    var value = "";
    value = $("#status option:selected").text();
    $("#statusValue").val(value);
    $(this).parent().find(".validation").remove();
});
$("#enqCourse").change(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#leadOwner").change(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#source").change(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#status").change(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#import_form").on("submit", function(e) {
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
                email: email,
                password: passw,
            },
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status == 200) {
                    document.getElementById("import_form").reset();
                    loadtAllLeads();
                    $("#leadModelImport").modal("hide");
                    // Notiflix.Notify.success(data.messages.success);
                    // setTimeout(() => { window.location.reload() }, 600);
                    Swal.fire("Success!", data.messages.success, "success");
                }
            },
            error: function(jqxhr, eception) {
                if (jqxhr.status == 404) {
                    // Notiflix.Notify.warning(data.messages.success);
                    // setTimeout(() => { window.location.reload() }, 600);
                    Swal.fire("Failed!", data.messages.success, "failed");
                }
                if (jqxhr.status == 400) {
                    if (jqxhr.responseJSON.messages.file_csv) {
                        $("#file_csv").addClass("input-error");
                        $("#file_csv")
                            .parent()
                            .append(
                                '<span class="text-danger validation">' +
                                jqxhr.responseJSON.messages.file_csv +
                                "</span>"
                            );
                    }
                    if (jqxhr.responseJSON.messages.importCourseVaue) {
                        $("#importCourseVaue").addClass("input-error");
                        $("#importCourseVaue")
                            .parent()
                            .append(
                                '<span class="text-danger validation">' +
                                jqxhr.responseJSON.messages.importCourseVaue +
                                "</span>"
                            );
                    } else {
                        Swal.fire("Failed!", jqxhr.responseJSON.messages.error, "failed");
                    }
                }
            },
        });
    }
});

$("#importCourseVaue").change(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#file_csv").change(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#whatsApp").on("select2:open", function() {
    // get values of selected option
    var values = $(this).val();
    // get the pop up selection
    var pop_up_selection = $(".select2-results__options");
    if (values != null) {
        // hide the selected values
        pop_up_selection.find("li[aria-selected=true]").hide();
    } else {
        // show all the selection values
        pop_up_selection.find("li[aria-selected=true]").show();
    }
});

$("#sendMessage").click(function(e) {
    e.preventDefault();
    let bulkSms = $("#bulkSms").val();
    let smartSms = $("#smartSms").val();
    let whatsApp = $("#whatsApp").val();
    let bulkEmails = $("#bulkEmails").val();
    let url = BaseUrl + "/leadsApi/sendMessage";
    $(".loader").show();
    $.ajax({
        type: "POST",
        headers: {
            email: email,
            password: passw,
        },
        url: url,
        data: {
            bulkSms: bulkSms,
            smartSms: smartSms,
            whatsApp: whatsApp,
            bulkEmails: bulkEmails,
        },

        dataType: "json",
          success: function(data) {
            $(".loader").hide();
            Swal.fire("Success!", "Message sent successfully!", "success");
            $("#bulkSms").val("");
            $("#smartSms").val("").trigger("change");
            $("#whatsApp").val("").trigger("change");
            $("#bulkEmails").val("").trigger("change");
        },
        error: function(jqxhr, eception) {
            $(".loader").hide();
            if (jqxhr.status == 404) {
                
            }
            // if(jqxhr.responseJSON.messages.bulkEmails){
            //     $("#bulkEmails").addClass("input-error");
            //     $("#bulkEmails").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.bulkEmails+'</span>');
            // }
            // if(jqxhr.responseJSON.messages.bulkSms){
            //     $("#bulkSms").addClass("input-error");
            //     $("#bulkSms").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.bulkSms+'</span>');
            // }
            // if(jqxhr.responseJSON.messages.smartSms){
            //     $("#smartSms").addClass("input-error");
            //     $("#smartSms").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.smartSms+'</span>');
            // }
            // if(jqxhr.responseJSON.messages.whatsApp){
            //     $("#whatsApp").addClass("input-error");
            //     $("#whatsApp").parent().append('<span class="text-danger validation">'+jqxhr.responseJSON.messages.whatsApp+'</span>');
            // }
        },
    });
});

$("#bulkEmails").change(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#bulkSms").change(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#smartSms").change(function(event) {
    $(this).parent().find(".validation").remove();
});
$("#whatsApp").change(function(event) {
    $(this).parent().find(".validation").remove();
});

$("#leadCity").change(function(e) {
    e.preventDefault();
    let url = BaseUrl + "/leadsApi/getLocation/" + $("#leadCity").val();
    if ($("#leadCity").val() != "") {
        $.ajax({
            type: "GET",
            headers: {
                email: email,
                password: passw,
            },
            url: url,
            data: {},
            dataType: "json",
            success: function(data) {
                $("#leadLocation").html("");
                if (data.length > 0) {
                    let html = "<option value=''>Select location</option>";
                    for (let i = 0; i < data.length; i++) {
                        html += `<option value="${data[i].id}">${data[i].location_name}</option>`;
                    }
                    $("#leadLocation").append(html);
                } else {
                    $("#leadLocation").html("<option value=''>No location Found</option>");
                }
            },
            error: function(jqxhr, eception) {
                $(".loader").hide();
                $("#leadLocation").append("");
            }
        })
    } else {
        $("#leadLocation").html("<option value=''>Select city</option>");
    }
});

function searchLeads() {
    let url = BaseUrl + "/leadsApi/searchlead";
    $.ajax({
        type: "Get",
        headers: {
            email: email,
            password: passw,
        },
        url: url,
        success: function(data) {
            searchAllLeads(data);
        },
        error: function(jqxhr, eception) {
            if (jqxhr.status == 404) {
                
            }
        },
    });
}

function searchAllLeads(data = null) {
    let html = ``;
    var first = 0;
    var num = 0;
    table = $("#leadsTable").DataTable();
    let dataSet = [];
    if(data){
      data.forEach((e) => {
        if (first == 0) {
            first = e.id;
        }
        // let action = `<i class="fas fa-edit text-info"  id="${e.id}" onClick="editCat_click(this.id)"></i>
        // <i class="fas fa-trash-alt text-danger" id="${e.id}"  onClick="deleteCat_click(this.id)"></i>`;
        // let title =`<a href= "#" style="color: #000000;" onclick="loadAllSubCategories(${e.id})">${e.title}</a>`;
        //console.log(e.FollowUp_Days);
        const d = new Date();

        let date = formatDate(d);
        finalDate = getNumberOfDays(date, e.FollowUp_Days);
        if (isNaN(finalDate)) {
            finalDate = "";
        } else {
            finalDate = finalDate + " Days";
        }
        //let name = `<a href= "#" class="text-info"  onclick="leadDetails(${e.id}, this)">${e.Name}</a>`;
        let row = [
            ++num,
            e.id,
            e.owner_name,
            e.Name,
            e.Email,
            e.Mob_1,
            e.mob_2,
            e.source_name,
            finalDate,
            e.Enq_Dt,
            e.Follow_Up_Dt,
        ];
        dataSet.push(row);
      });
    }

    table.destroy();
    $("#leadsTable").DataTable({
        data: dataSet,
        responsive: true,
        bFilter: false,
        pageLength: 20,
        bLengthChange: false, //thought this line could hide the LengthMenu
        bInfo: false,
        // scrollY: "297px",
        paging: true,
        dom: "Rlfrtip",
        columnDefs: [{
                targets: [0],
                visible: false,
                searchable: false,
            },
            {
                targets: [],
                visible: false,
            },
        ],
        scrollX: true,
    });
    //$('#leads-table').DataTable().ajax.reload();
}

function searchData() {
    let name = $("#name").val();
    let email_field = $("#email").val();
    let mob_1 = $("#mob_1").val();
    let mob_2 = $("#mob_2").val();
    let keyComment = $("#keyComment").val();
    let followUpComment = $("#followUpComment").val();

    let url = BaseUrl + "/leadsApi/searchData";
    $.ajax({
        type: "POST",
        headers: {
            email: email,
            password: passw,
        },
        url: url,
        data: {
            name: name,
            email: email_field,
            mob_1: mob_1,
            mob_2: mob_2,
            keyComment: keyComment,
            followUpComment: followUpComment,
        },
        dataType: "json",
        success: function(data) {
            searchAllLeads(data.details);
        },
        error: function(jqxhr, eception) {
            if (jqxhr.status == 404) {}
        },
    });
}