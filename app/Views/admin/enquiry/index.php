<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $pageTitle ?></title>
    <?php include __DIR__ . '/../layout/cssLinks.php'; ?>
    <style type="text/css">
        .bottom-row{
            min-height: 215px;
        }
    </style>
</head>
<body class="sidebar-fixed">
    <div class="container-scroller">
        <?php include __DIR__ . '/../layout/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include __DIR__ . '/../layout/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <?= $pageHeading?>
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Enquiry</a></li>
                                <li class="breadcrumb-item active" aria-current="page">leads</li>
                            </ol>
                        </nav>
                    </div>
                    <div id="alertMessageview"></div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row card-title shadow-lg p-3 mb-2 bg-white rounded border" style="font-size:smaller;">
                                        <div class="col-md-2 offset-6">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    Total Leads
                                                </div>
                                                <div class="col-md-4">
                                                    <span ><?= $cound_leads; ?>
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    Open Leads
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    10
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    Current Leads
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    20
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    Sales
                                                </div>
                                                <div class="col-md-6">
                                                    30
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    Revenue
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    10
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    Due
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    20
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-primary float-right m-2" data-toggle="modal" data-target     ="#leadModel">
                                                Add
                                            </button>
                                        </div>
                                    </div>
                                  
                                    <!-- part 2 -->
                                    <div class="row card-title shadow-lg p-3 mb-2 bg-white rounded border" style="font-size:smaller;">
                                        <div class="col-sm-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Status</label>
                                                </div>
                                                <div class="col-md-7">
                                                    <select name="" id="enqStatus" class="form-control" onchange="fetchData()">
                                                        <option value="">select</option>
                                                        <?php foreach ($enqStatus as $enq_status) {
                                                            ?>
                                                            <option value="<?= $enq_status['id'];?>"><?= $enq_status['title'];?></option>
                                                            <?php
                                                        }?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label>Lead Owner</label>
                                                </div>
                                                <div class="col-md-7 mt-2">
                                                    <select name="" id="ownerId" class="form-control" onchange="fetchData()">
                                                        <option value="">select</option>
                                                        <?php foreach ($usersData as $user_data) {
                                                            ?>
                                                            <option id="<?= $user_data['emp_id'];?>"><?= $user_data['full_name'];?></option>
                                                            <?php
                                                        }?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label>Source</label>
                                                </div>
                                                <div class="col-md-7 mt-2">
                                                    <select name="" id="sourceId" class="form-control" onchange="fetchData()">
                                                        <option value="">select</option>
                                                        <?php foreach ($sourceModel as $source_model) {
                                                            ?>
                                                            <option id="<?= $source_model['id'];?>"><?= $source_model['title'];?></option>
                                                            <?php
                                                        }?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label>Follow-up</label>
                                                </div>
                                                <div class="col-md-7 mt-2" onchange="fetchData()" onkeyup="fetchData()">
                                                    <input type="number" id="followUp" class="form-control" placeholder="Follow-up" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Enq_Dt</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="date" id="enqDate" class="form-control" onchange="fetchData()" onkeyup="fetchData()"/>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    Follow-up Date
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    <input type="date" id="followUpDate" class="form-control" onchange="fetchData()" onkeyup="fetchData()" />
                                                </div>
                                                
                                                <div class="col-md-4 mt-2">
                                                    <label>Location</label>
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    <input type="text" onkeyup="fetchData()" id="location" placeholder="Location" class="form-control" />
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <label>City</label>
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    <input type="text" onkeyup="fetchData()" id="city" placeholder="City" class="form-control" />
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-2">
                                            <div class="row mt-5">
                                                <div class="col-md-8">
                                                    Total Leads
                                                </div>
                                                <div class="col-md-4">
                                                    <span id="totalLeads"><?= $cound_leads; ?>
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    Open Leads
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="">30</span>
                                                </div>
                                                <div class="col-md-8 mt-2">
                                                    Current Leads
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="">30</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="row mt-5">
                                                <div class="col-md-6">
                                                    Sales
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="">30</span>
                                                </div>
                                                <div class="col-md-6 mt-2 mt-2" >
                                                    Revenue
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <span class="">10</span>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    Due
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <span class="">20</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 shadow-lg p-3 mb-5 bg-white rounded border">
                                            <div class="table-responsive">
                                                <table id="leads-table" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr.No.</th>
                                                            <th>Lead _Id</th>
                                                            <th>Owner</th>
                                                            <th>Source</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Mob_1</th>
                                                            <th>Mob_2</th>
                                                            <th>Days</th>
                                                            <th>Last Call</th>
                                                            <th>Next Call</th>
                                                            <!-- <th>Actions</th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="ml-2">
                                        <input type="hidden" id="userId" value="" />
                                        <div class="row mb-0 card-title shadow-lg p-3 bg-white rounded border" style="font-size:smaller;"     >
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-5 mt-2">
                                                        Name :
                                                    </div>
                                                    <div class="col-7">
                                                        <input type="text" name="" placeholder="Name" id="userName" class="form-control" />
                                                    </div>
                                                    <div class="col-5 mt-2">
                                                        Status :
                                                    </div>
                                                    <div class="col-7  mt-2">
                                                        <select id="userStatus" class="form-control">
                                                            <option value=""> Select Status</option>
                                                            <?php foreach ($enqStatus as $enqStatu) {
                                                                ?>
                                                                <option value="<?= $enqStatu['id'];?>"><?= $enqStatu['title'];?></option>
                                                                <?php
                                                            }?>
                                                        </select>
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        Followup Count:
                                                    </div>
                                                    <div class="col-7 mt-2">
                                                        <input type="text" name="" placeholder="Followup Count" id="userFallow" class="form-control" />
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        Last Call :
                                                    </div>
                                                    <div class="col-7 mt-2">
                                                        <input type="date" name="" placeholder="Last Call" id="userLastCall" class="form-control" />
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        Next Call:
                                                    </div>
                                                    <div class="col-7 mt-2">
                                                        <input type="date" name="" placeholder="Next Call" id="userNextCall" class="form-control" />
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        Unsubscribe
                                                    </div>
                                                    <div class="col-6 offset-1 mt-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="userUnsubscribe" id="subscribeYes" value="1">
                                                            <label class="form-check-label ml-0" for="subscribeYes">
                                                                Yes
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="userUnsubscribe" id="subscribeNo" value="0">
                                                            <label class="form-check-label ml-0" for="subscribeNo">
                                                              No
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-7 offset-5 mt-2 text-right">
                                                        <button class="btn btn-primary" id="saveUserDetials">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-0 card-title shadow-lg p-3 bg-white rounded border" style="font-size:smaller;"    >
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-5 mt-2">
                                                        Bulk SMS :
                                                    </div>
                                                    <div class="col-7">
                                                        <input type="text" name="" placeholder="Bulk SMS" id="bulkSms" class="form-control" />
                                                    </div>
                                                    <div class="col-5 mt-2">
                                                        Smart SMS :
                                                    </div>
                                                    <div class="col-7  mt-2">
                                                        <input type="text" name="" placeholder="Smart SMS" id="smartSms" class="form-control" />
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        What'sApp :
                                                    </div>
                                                    <div class="col-7 mt-2">
                                                        <input type="text" name="" placeholder="What'sApp" id="whatapp" class="form-control" />
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        Bulk Email :
                                                    </div>
                                                    <div class="col-7 mt-2">
                                                        <input type="text" name="" placeholder="Bulk Email" id="bulkEmail" class="form-control" />
                                                    </div>
                                                    <div class="col-7 offset-5 mt-2 text-right">
                                                        <button class="btn btn-primary">Send</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row card-title shadow-lg p-3 bg-white rounded border bottom-row" style="font-size:smaller;">
                                            <div class="col-12">
                                                <div class="row" >
                                                  <div class="col-12">
                                                    <div class="row" id="counsellerStates">
                                                    </div>
                                                  </div>
                                                    <hr/>
                                                    <div class="col-8 mt-2 border-top">
                                                        <textarea name="" placeholder="Comments" id="comments" class="mt-2 form-control" ></textarea>
                                                    </div>

                                                    <div class="col-4 mt-2 border-top text-right">
                                                        <button class="mt-2 btn btn-primary" id="saveComments">Save</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/../layout/jsLinks.php'; ?>
    </div>

    <script src="<?= base_url(); ?>/assets/js/xla-update-lead.js"></script>
    <script src="<?= base_url(); ?>/assets/js/dropzone.js"></script>
    <script src="<?= base_url(); ?>/assets/js/sweetalert2.js"></script>
    <script>
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
            let ownerId = $("#ownerId").val();
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
                    $('#totalLeads').text(data.count_leads);
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

        

    </script>
</body>
</html>
