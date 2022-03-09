<?php
$session = session();
// echo "<pre>";
// print_r($follow_comment);
// exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $pageTitle ?></title>
    <?php include __DIR__ . '/../layout/cssLinks.php'; ?>    
    <style type="text/css">
        .bottom-row{
            min-height: 186px;
        }
        div.dataTables_wrapper {
            width: 1050px;
            margin: 0 auto;
        }
        .hide_me {
          display: none!important;
        }
        .select2-results__option[aria-selected=true]{
            display: none;
        }
        /*.select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: yellowgreen;
            color: white;
        }*/

        .row.card-title {
            border: 2px solid;
            /*padding: 10px;*/
        }
        .row {
    margin-left: 0px;
    margin-right: 0px;
    white-space: nowrap;
}
.row .col-md-8, .row .col-md-4{
    align-items: center;
    display: flex;
}
.form-control myform-control:focus{
    outline: none !important;
}
label{
    margin-bottom: 0;
}
.myform-control{
    border:none;
    outline:none;
}

.select2-container--default .select2-selection--multiple{
    border: 0px solid red!important;
}
button#saveUserDetials {
    border-top: 2px solid black !important;
    border-left: 2px solid black !important;
    border-radius: 0px;
    padding: 6px !important;
}

button#saveComments {
    border-top: 2px solid black !important;
    border-left: 2px solid black !important;
    border-radius: 0px;
    padding: 8px !important;
}

button#sendMessage {
    border-top: 2px solid black !important;
    border-left: 2px solid black !important;
    border-radius: 0px;
    padding: 6px !important;
    /*position: absolute;
    bottom: 0;
    right: 0;*/
}
span.select2.select2-container.select2-container--default.select2-container--focus.select2-container--below.select2-container--open {
    width: 150px;
}
.font-size{
    font-size: 14px !important;
}
.myform-control{
    height: calc(1.5rem + 2px);
    padding: 0px !important;
    font-size: 10px;
}
select#enqStatus, select#ownerId, select#sourceId , select#userStatus, select#bulkSms{
    height: calc(1.5rem + 2px);
}
.margin-left{
    margin-left: -10px;
}
input#searchValue {
    border-top: 2px solid;
    border-left: 2px solid;
    border-radius: 0px;

    /*position: absolute;
    bottom: 0;
    outline:none;
    right: 0;*/
}
select {
    border: none !important;
}
div.dataTables_wrapper {
    width: 100% !important;
    margin: 0 auto;
}

textarea#comments {
    height: calc(1.7rem + 2px);
    padding: 0px !important;
    font-size: 14px;
    border: none;
    outline: none;
    margin-top: 5px;
    
}
.councler-state{
    height: 130px;
    overflow-y: auto;
}

    </style>
</head>
<body class="sidebar-fixed">
    <?php include __DIR__ . '/../layout/loader.php'; ?>

    <div class="container-scroller">
        <?php include __DIR__ . '/../layout/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include __DIR__ . '/../layout/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper p-0">
                    <div class="page-header mb-0">
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
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-9 font-size p-0">
                                    <div class="row card-title" style="font-size:smaller;">
                                        <div class="col-md-5 offset-md-1">
                                            <div class="row">
                                                <div class="col-md-4 text-right pt-1">
                                                    <span ><?= $last_month_count[0]['id']; ?>
                                                </div>
                                                <div class="col-md-4 pt-1">
                                                    Total Leads
                                                </div>
                                                <div class="col-md-4 pt-1">
                                                    <span ><?= $current_month_count[0]['id']; ?>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <span><?= $last_open_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-4">
                                                    Open Leads
                                                </div>
                                                <div class="col-md-4">
                                                    <span><?= $open_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    <?= $last_leads[0]['id']; ?>
                                                </div>
                                                <div class="col-md-4">
                                                    Current Leads
                                                </div>
                                                <div class="col-md-4">
                                                    <?= $current_leads[0]['id']; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-4 text-right">
                                                    30
                                                </div>
                                                <div class="col-md-4">
                                                    Sales
                                                </div>
                                                <div class="col-md-4">
                                                    30
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    10
                                                </div>
                                                <div class="col-md-4">
                                                    Revenue
                                                </div>
                                                <div class="col-md-4">
                                                    10
                                                </div>
                                                <div class="col-md-4 text-right">
                                                    10
                                                </div>
                                                <div class="col-md-4">
                                                    Due
                                                </div>
                                                <div class="col-md-4">
                                                    20
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-2 text-right">
                                            <button type="button" class="btn btn-primary float-right m-2" data-toggle="modal" data-target     ="#leadModel">
                                                New Lead
                                            </button>
                                            <!-- <button type="button" class="btn btn-primary float-right m-0" data-toggle="modal" data-target     ="#leadModelImport">
                                                Import Lead
                                            </button> -->
                                        </div>
                                    </div>
                                  
                                    <!-- part 2 -->
                                    <div class="row card-title" style="font-size:smaller;">
                                        <div class="col-sm-4">
                                            <div class="row">
                                                <div class="col-md-4 pr-0">
                                                    <label>Status</label>
                                                </div>
                                                <div class="col-md-8 pl-0 margin-left">
                                                    <select name="" id="enqStatus" class="form-control myform-control" onchange="fetchData()">
                                                        <option value="">Select</option>
                                                        <?php foreach ($enqStatus as $enq_status) {
                                                            ?>
                                                            <option value="<?= $enq_status['id'];?>"><?= $enq_status['title'];?></option>
                                                            <?php
                                                        }?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4  pr-0">
                                                    <label>Lead Owner</label>
                                                </div>
                                                <div class="col-md-8 margin-left pl-0">
                                                    <select name="" id="ownerId" class="form-control myform-control" onchange="fetchData()">
                                                        <option value="">Select</option>
                                                        <?php foreach ($usersData as $user_data) {
                                                            ?>
                                                            <option value="<?= $user_data['emp_id'];?>"><?= $user_data['full_name'];?></option>
                                                            <?php
                                                        }?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4  pr-0">
                                                    <label>Source</label>
                                                </div>
                                                <div class="col-md-8 margin-left pl-0">
                                                    <select name="" id="sourceId" class="form-control myform-control" onchange="fetchData()">
                                                        <option value="">Select</option>
                                                        <?php foreach ($sourceModel as $source_model) {
                                                            ?>
                                                            <option value="<?= $source_model['id'];?>"><?= $source_model['title'];?></option>
                                                            <?php
                                                        }?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4  pr-0">
                                                    <label>Follow-up</label>
                                                </div>
                                                <div class="col-md-8 margin-left pl-0" onchange="fetchData()" onkeyup="fetchData()">
                                                    <input type="number" id="followUp" class="form-control myform-control" placeholder="Follow-up" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="row">
                                                <div class="col-md-4 margin-left pl-0 pr-0">
                                                    <label>Enq_Dt</label>
                                                </div>
                                                <div class="col-md-8 pl-0">
                                                    
                                                    <input class="form-control myform-control input-group" id="enqDate" onchange="fetchData()" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" />
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                </div>
                                                <div class="col-md-4 margin-left pl-0  pr-0">
                                                    Follow-up Date
                                                </div>
                                                <div class="col-md-8 pl-0">
                                                    <!-- <input type="date" id="followUpDate" class="form-control myform-control" onchange="fetchData()" onkeyup="fetchData()" /> -->
                                                     <input class="form-control myform-control input-group" id="followUpDate" onchange="fetchData()" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" />
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                </div>
                                                
                                                <div class="col-md-4 margin-left pl-0  pr-0">
                                                    <label>Location</label>
                                                </div>
                                                <div class="col-md-8  pl-0">
                                                    <input type="text" onkeyup="fetchData()" id="location" placeholder="Location" class="form-control myform-control" />
                                                </div>
                                                <div class="col-md-4 margin-left pl-0  pr-0">
                                                    <label>City</label>
                                                </div>
                                                <div class="col-md-8  pl-0">
                                                    <input type="text" onkeyup="fetchData()" id="city" placeholder="City" class="form-control myform-control" />
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3 pl-0 pr-0">
                                            <div class="row mt-4">
                                                <div class="col-md-3 text-right">
                                                    <span id="totalLeadsLastMonth"><?= $last_month_count[0]['id']; ?>
                                                </div>
                                                <div class="col-md-6">
                                                    Total Leads
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="totalLeads"><?= $current_month_count[0]['id']; ?>
                                                </div>
                                                <div class="col-md-3 text-right">
                                                    <span class="" id="openLeadsLastMonth"><?= $last_open_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-6">
                                                    Open Leads
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="" id="openLeads"><?= $open_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-3 text-right">
                                                    <span class="" id="currentLeadsLastMonth"><?= $last_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-6">
                                                    Current Leads
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="" id="currentLeads"><?= $current_leads[0]['id']; ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-2 pl-0">
                                            <div class="row mt-4">
                                                <div class="col-md-3 text-right">
                                                    <span class="">12</span>
                                                </div>
                                                <div class="col-md-5">
                                                    Sales
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="">10</span>
                                                </div>
                                                <div class="col-md-3 text-right">
                                                    <span class="">30</span>
                                                </div>
                                                <div class="col-md-5" >
                                                    Revenue
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="">10</span>
                                                </div>
                                                <div class="col-md-3 text-right">
                                                    <span class="">10</span>
                                                </div>
                                                <div class="col-md-5">
                                                    Due
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="">20</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-5 pr-0 offset-7">
                                            <div class="row">
                                                <div class="col-md-2 text-right pr-0"><label class="mt-1">Search</label></div>
                                                <div class="col-md-10 pr-0">
                                                    <input class="form-control" id="searchValue" type="text" placeholder="Search" aria-label="Search" style="height: 30px;" onkeyup="searchValue()">
                                                </div>
                                            </div>    
                                        </div>
                                    </div>

                                    <div class="row card-title p-0 m-0"  style="font-size:smaller;">
                                            <div class="table-responsive p-0 m-0">
                                                <table id="leads-table" class="p-0 m-0" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr.No.</th>
                                                            <th>Lead _Id</th>
                                                            <th>Name</th>
                                                            <th>Owner</th>
                                                            <th>Source</th>
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
                                
                                <div class="col-md-3 font-size pr-0 card-title">
                                    <div class="ml-1">
                                        <input type="hidden" id="userId" value="" />
                                        <div class="row mb-0 border-bottom-0 card-title" style="font-size:smaller;"     >
                                            <div class="col-12 pr-0">
                                                <div class="row">
                                                    <div class="col-5 mt-2 ">
                                                        Name :
                                                    </div>
                                                    <div class="col-7">
                                                        <input type="text" name="" placeholder="Name" id="userName" class="form-control myform-control" />
                                                    </div>
                                                    <div class="col-5 mt-2">
                                                        Status :
                                                    </div>
                                                    <div class="col-7  mt-2">
                                                        <select id="userStatus" class="form-control myform-control">
                                                            <option value="">Select Status</option>
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
                                                        <input type="text" name="" placeholder="Followup Count" id="userFallow" class="form-control myform-control" />
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        Last Call :
                                                    </div>
                                                    <div class="col-7 mt-2">
                                                        <!-- <input type="date" name="" placeholder="Last Call" id="userLastCall" class="form-control myform-control" /> -->
                                                        <input class="form-control myform-control input-group" id="userLastCall" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" />
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        Next Call:
                                                    </div>
                                                    <div class="col-7 mt-2">
                                                        <!-- <input type="date" name="" placeholder="Next Call" id="userNextCall" class="form-control myform-control" /> -->
                                                        <input class="form-control myform-control input-group" id="userNextCall" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" />
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        Unsubscribe
                                                    </div>
                                                    <div class="col-6 mt-3"> 
                                                        <label class="radio-inline" for="subscribeYes">
                                                            <input class="radio-inline" type="radio" name="userUnsubscribe" id="subscribeYes" value="1" /><span class="radio-btn-text"> Yes</span>
                                                        </label>
                                                        &nbsp&nbsp&nbsp
                                                        <label class="radio-inline" for="subscribeNo">
                                                            <input class="" type="radio" name="userUnsubscribe" id="subscribeNo" value="0">   <span class="radio-btn-text">No</span>
                                                        </label>
                                                    </div>

                                                    <div class="col-7 offset-5 mt-2 pr-0 text-right">
                                                        <button class="btn btn-primary border" id="saveUserDetials">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-0 border-bottom-0 card-title " style="font-size:smaller;"    >
                                            <div class="col-12 pr-0">
                                                <div class="row">
                                                    <div class="col-5 mt-2">
                                                        Bulk SMS :
                                                    </div>
                                                    <div class="col-7">
                                                        <select id="bulkSms" class="form-control myform-control">
                                                            <option value="">Select</option>
                                                            <option value="all">All</option>
                                                        </select>
                                                        
                                                    </div>
                                                    <div class="col-5 mt-2">
                                                        Smart SMS :
                                                    </div>
                                                    <div class="col-7  mt-2">
                                                        <select id="smartSms" class="form-control myform-control" multiple="multiple">
                                                            <?php if(count($allFirstMobiles)>0){foreach($allFirstMobiles as $mobile){
                                                                ?>
                                                                <option value="<?= $mobile['Mob_1'] ;?>"><?= $mobile['Mob_1'] ;?></option>
                                                                <?php
                                                            }}?>
                                                        </select>

                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        What'sApp :
                                                    </div>
                                                    <div class="col-7 mt-2">
                                                        <!-- <div class="radioButton mt-2">
                                                            <label class="radio-inline">
                                                                <input type="radio" name="optradio" checked>All
                                                            </label>
                                                            <label class="radio-inline">
                                                                <input type="radio" name="optradio">Select
                                                            </label>
                                                        </div>
                                                        <select id="whatsApp" class="form-control myform-control" multiple="multiple">
                                                            <option value="All" class="all" data-type="all">All</option>
                                                        </select> -->
                                                        <select id="whatsApp" class="form-control myform-control" multiple="multiple" >

                                                            <?php if(count($allFirstMobiles)>0){foreach($allFirstMobiles as $mobile){
                                                                ?>
                                                                <option class="singlewhatsApp" data-type="number" value="+91<?= $mobile['Mob_1'] ;?>"><?= $mobile['Mob_1'] ;?></option>
                                                                <?php
                                                            }}?>
                                                        </select>
                                                    </div>
                                                    <div class="col-5 mt-3">
                                                        Bulk Email :
                                                    </div>
                                                    <div class="col-7 mt-2">
                                                        <select id="bulkEmails" class="form-control myform-control" multiple="multiple">
                                                            <?php if(count($allEmails)>0){foreach($allEmails as $all_email){
                                                                ?>
                                                                <option class="single" data-type="number" value="<?= $all_email['Email'] ;?>"><?= $all_email['Email'] ;?></option>
                                                                <?php
                                                            }}?>
                                                        </select>
                                                    </div>
                                                    <div class="col-7 offset-5 mt-2 pr-0 text-right">
                                                        <button id="sendMessage" class="btn btn-primary">Send</button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-0 border-bottom-0 card-title" style="font-size:smaller;">
                                            <div class="col-12">
                                                <div class="row" >
                                                  <div class="col-12 councler-state">
                                                    <div class="row" id="counsellerStates">
                                                         <?php if(count($follow_comment)>0){foreach($follow_comment as $comment){
                                                                ?>
                                                               <div class="col-12 mt-2"><?= $comment['comments'];?></div>
                                                                <div class="col-12 text-right"><?= $comment['full_name'];?> ,  <?= $comment['fallow_comments_time'];?></div>
                                                                <?php
                                                            }}?>
                                                        
                                                    </div>
                                                  </div>                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row card-title" style="font-size:smaller">
                                            <div class="col-12 pr-0">
                                                <div class="row" >
                                                        <div class="col-9 pr-0">
                                                            <textarea name="" placeholder="Comments" id="comments" class="form-control p-0" ></textarea>
                                                        </div>
                                                        <div class="col-3 text-right pr-0">
                                                            <button class="btn btn-primary" id="saveComments">Save</button>
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
        </div>
        
        <?php include __DIR__ . '/../layout/jsLinks.php'; ?>
    </div>
    <?= require("modal.php");?>
    <script src="<?= base_url(); ?>/assets/js/xla-update-lead.js"></script>
    <script src="<?= base_url(); ?>/assets/js/dropzone.js"></script>
    <script src="<?= base_url(); ?>/assets/js/sweetalert2.js"></script>
    <script src="<?= base_url(); ?>/assets/js/pages/enquiry.js"></script>
    

    <script type="text/javascript">

        // Mobile number valid
        function validatePhone(e, id){
            $(e).parent().find('.validation').remove();
            if($('#'+id).val().length>0){
                if(!validate_Phone_Number(id)){
                    console.log("Not validate"+id);
                    $("#"+id).addClass("input-error");
                    $("."+id).removeClass("d-none");
                }else{
                    $("."+id).addClass("d-none");
                }
            }else{
                $("."+id).addClass("d-none");
            }
        }
        function validate_Phone_Number(id) {
            var number = $('#'+id).val();
            var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
            if (filter.test(number) && (number.length >9 && number.length<14)) {
                return true;
            }
            else {
                return false;
            }
        }
    </script>
</body>
</html>
