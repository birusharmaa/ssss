<?php
$session = session();
$sessData = $session->get('loginInfo');
// echo "<pre>";
// print_r($sessData);
// exit;
$model = new \App\Models\SettingModel();
$settingData = $model->get()->getResult('array');
$logo = !empty($settingData[76]['setting_value'])? $settingData[76]['setting_value'] : base_url() . '/assets/images/logo.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $pageTitle ?></title>
    <?php include __DIR__ . '/../layout/cssLinks.php'; ?>   
    <link href="<?= base_url('assets/dist/css/bootstrap-select.css');?>"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/assets/js/pages/jquery.dataTables.colResize.css">
    <style type="text/css">
        .bottom-row {
            min-height: 186px;
        }

        div.dataTables_wrapper {
            width: 1050px;
            margin: 0 auto;
        }

        .hide_me {
            display: none !important;
        }

        .select2-results__option[aria-selected=true] {
            display: none;
        }

        .row.card-title {
            border: 2px solid;
            margin-bottom: 0;
        }

        .table-sm td {
            padding: 0;
        }

        .row {
            margin-left: 0px;
            margin-right: 0px;
            white-space: nowrap;
        }

        .row .col-md-8,
        .row .col-md-4 {
            align-items: center;
            display: flex;
        }

        .form-control myform-control:focus {
            outline: none !important;
        }

        label {
            margin-bottom: 0;
        }

        .myform-control {
            border: none;
            outline: none;
        }

        .select2-container--default .select2-selection--multiple {
            border: 0px solid red !important;
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
        }

        span.select2.select2-container.select2-container--default.select2-container--focus.select2-container--below.select2-container--open {
            width: 150px;
        }

        .font-size {
            font-size: 14px !important;
        }

        .myform-control {
            height: calc(1.5rem + 2px);
            padding: 0px !important;
            font-size: 10px;
        }

        select#enqStatus,
        select#ownerId,
        select#sourceId,
        select#userStatus,
        select#bulkSms {
            height: calc(1.5rem + 2px);
        }

        .margin-left {
            margin-left: -10px;
        }

        input#searchValue {
            border-top: 2px solid;
            border-left: 2px solid;
            border-radius: 0px;
            /* height: 20px; */
            width: 100%;
            border-right: 0;
            border-bottom: 0;
        }

        select {
            border: none !important;
        }

        div.dataTables_wrapper {
            width: 100% !important;
            margin: 0 auto;
        }

        .myform-control {
            height: calc(1rem) !important;
        }

        textarea#comments {
            height: 100%;
            padding: 0px !important;
            font-size: 14px;
            border: none;
            outline: none;
            margin-top: 5px;

        }

        .councler-state {
            height: 200px;
            overflow-y: auto;
        }

        div#commentsRow {
            height: 100px;
        }
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 1px;
            text-overflow: '';
        }

        .mtn-3 {
            margin-top: -3px;
        }

        .cmw-80 {
            max-width: 80px !important;
        }

        .button-div {
            position: relative;
        }

        .button-div button {
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .comment-box {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        #leadModel {
            padding-left: 0 !important;
        }

        #leadModel .modal-dialog {
            margin: 0 !important;
            max-width: 100% !important;
        }

        #leadModel .modal-dialog .modal-content .modal-header {
            padding: 5px 26px;
        }

        #leadModel .modal-dialog .modal-content .modal-body {
            padding: 0;
        }

        .councler-state .row .col-12:nth-child(1) {
            background-color: #fbe1bf;
            white-space: break-spaces;
        }
        .councler-state .row .col-12:nth-child(2) {
            background-color: #b2e4f7;
        }

        tr.odd {
            background-color: #c6c6c6 !important
        }

        .bg-cgray {
            background-color: #c6c6c6 !important
        }
        .card .card-title {
            padding-bottom: 0.5px;
        }
        .comment-box{
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }    
        div#leadModel {
            padding-right: 0px !important;
        }


        .multiselect {
            width: 100%;
        }

        .selectBox {
            position: relative;
        }

        .selectBox select {
            width: 100%;
        }

        .overSelect {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
        }

        .btn.dropdown-toggle:focus {
            outline: none !important;
        }

        button.multiselect.dropdown-toggle.btn.btn-default {
            padding: 1px;
            font-size: 11px;
        }
        .multiselect-container>li>a>label {
            margin: 0;
            height: 100%;
            cursor: pointer;
            font-weight: 400;
            padding: 0px 0px 2px 8px !important;
            font-size: 11px;
        }
        li {
            line-height: 0px !important;
        }

        .multiselect-container>li>a>label>input[type=checkbox]{
            width: 10px!important;
        }

        .dropdown-menu {
            min-width: 7em;
            max-height: 250px;
            overflow-y: auto;
        }
    </style>
</head>
<body class="sidebar-icon-only">
    <?php include __DIR__ . '/../layout/loader.php'; ?>

    <div class="container-scroller">
        <?php include __DIR__ . '/../layout/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include __DIR__ . '/../layout/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper p-0">
                    <!-- <div class="page-header mb-0">
                        <h3 class="page-title">
                            <?= $pageHeading?>
                        </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Enquiry</a></li>
                                <li class="breadcrumb-item active" aria-current="page">leads</li>
                            </ol>
                        </nav>
                    </div> -->
                    <div id="alertMessageview"></div>

                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-10 font-size p-0">
                                    <div class="row card-title border-bottom-0 border-right-0" style="font-size:smaller;">
                                        <div class="col-md-3">
                                            <!-- <img src="<?= $logo;?>" alt="logo" width="100" height="50" /> -->
                                            <a class="navbar-brand brand-logo-mini" href=""><img src="<?= base_url(); ?>/assets/images/logo-sm.png" alt="logo" width="50" /></a>
                                        </div>
                                        <div class="col-md-3">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td><strong><?= $last_month_count[0]['id']; ?></strong></td>
                                                        <td> <div class="mx-1"> Total Leads</div></td>
                                                        <td><strong><?= $current_month_count[0]['id']; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong><?= $last_open_leads[0]['id']; ?></strong></td>
                                                        <td> <div class="mx-1"> Open Leads</div></td>
                                                        <td><strong><?= $open_leads[0]['id']; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong><?= $last_leads[0]['id']; ?></strong></td>
                                                        <td> <div class="mx-1"> Current Leads</div></td>
                                                        <td><strong><?= $current_leads[0]['id']; ?></strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-3 button-div">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td><strong>20</strong></td>
                                                        <td><div class="mx-1">Sales</div></td>
                                                        <td><strong>10</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>20</strong></td>
                                                        <td><div class="mx-1">Revenue</div></td>
                                                        <td><strong>10</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>20</strong></td>
                                                        <td><div class="mx-1">Due</div></td>
                                                        <td><strong>10</strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-3 position-relative">
                                            <table class="myTable">
                                                <tbody>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 font-weight-bold">Name</div></td>
                                                        <td>
                                                            <?= $sessData['full_name'];?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 font-weight-bold">Email</div></td>
                                                        <td>
                                                            <?= $sessData['email'];?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 font-weight-bold">Phone</div></td>
                                                        <td>
                                                            <?= $sessData['personal_number'];?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <!-- <img src="http://localhost:8080/assets/images/ logo-sm.png" alt=""
                                                class="position-absolute rounded-circle" width="50" height="50" style="top:0; right:0;"> -->
                                                <!-- <img src="<?= $logo;?>" class="position-absolute rounded-circle" alt="logo" width="100" height="50" style="top:0; right:0;"/> -->
                                                <?php if (!empty($sessData['picture_attachment'])) : ?>
                                                <img src="<?= $sessData['picture_attachment'] ?>" alt="profile" class="position-absolute rounded-circle"  width="75" style="top:0; right:0;"/>
                                              <?php else : ?>
                                                <img src="<?= base_url(); ?>/assets/images/faces/face12.jpg" alt="profile" class="position-absolute rounded-circle" width="100" style="top:0; right:0;"/>
                                              <?php endif; ?>
                                        </div>
                                    
                                    </div>
                                  
                                    <!-- part 2 -->
                                    <div class="row card-title border-bottom-0 border-right-0" style="font-size:smaller;">
                                        <div class="col-md-3 p-0">
                                            <table class="myTable">
                                                <tbody>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 bg-cgray">Status</div></td>
                                                        <td>
                                                            <select id="enqStatus" onchange="fetchData(this)" name="enqStatus[]" multiple >
                                                                <?php foreach ($enqStatus as $enq_status) {
                                                                    ?>
                                                                    <option value="<?= $enq_status['id'];?>"><?= $enq_status['title'];?></option>
                                                                    <?php
                                                                }?>
                                                            </select>   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 bg-cgray">Lead Owner</div></td>
                                                        <td>
                                                            <select id="ownerId" onchange="fetchData(this)" name="ownerId[]" multiple >
                                                                <?php foreach ($usersData as $user_data) {
                                                                    ?>
                                                                    <option value="<?= $user_data['emp_id'];?>"><?= $user_data['full_name'];?></option>
                                                                    <?php
                                                                }?>
                                                            </select>   
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 bg-cgray">Source</div></td>
                                                        <td>
                                                            <select id="sourceId" onchange="fetchData(this)" name="sourceId[]" multiple >
                                                                <?php foreach ($sourceModel as $source_model) {
                                                                    ?>
                                                                    <option value="<?= $source_model['id'];?>"><?= $source_model['title'];?></option>
                                                                    <?php
                                                                }?>
                                                            </select> 
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 bg-cgray">Follow-up</div></td>
                                                        <td>
                                                        <input type="number" id="followUp" class="form-control myform-control cmw-80" placeholder="Follow up" onchange="fetchData()" onkeyup="fetchData()"/>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-3 p-0">
                                            <table class="myTable">
                                                <tbody>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 bg-cgray">Enq_Dt</div></td>
                                                        <td>
                                                            <input class="form-control myform-control input-group" id="enqDate" onchange="fetchData(this,'enqDate')" onkeyup="fetchDatasss(this,'enqDate')" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" />
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 bg-cgray">Follow-up Date</div></td>
                                                        <td>
                                                            <input class="form-control myform-control input-group" id="followUpDate" onchange="fetchData()" onkeyup="fetchDatasss(this,'followUpDate')" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" />
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 bg-cgray">City</div></td>
                                                        <td>
                                                           
                                                            <select id="city" onchange="fetchData(this)" name="city[]" multiple >
                                                                <?php foreach ($cities as $city) {
                                                                    ?>
                                                                    <option value="<?= $city['id'];?>"><?= $city['name'];?></option>
                                                                    <?php
                                                                }?>
                                                            </select> 

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><div class="mr-1 mtn-3 bg-cgray">Location</div></td>
                                                        <td>
                                                            <select id="location" onchange="fetchData(this)" name="location[]" multiple >
                                                                <?php foreach ($locations as $location) {
                                                                    ?>
                                                                    <option value="<?= $location['id'];?>"><?= 
                                                                    $location['location_name'];?></option>
                                                                    <?php
                                                                }?>
                                                            </select> 
                                                            
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-2 offset-md-1">
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td><strong id="totalLeadsLastMonth"><?= $last_month_count[0]['id']; ?></strong></td>
                                                        <td> <div class="mx-1"> Total Leads</div></td>
                                                        <td><strong id="totalLeads"><?= $current_month_count[0]['id']; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong id="openLeadsLastMonth"><?= $last_open_leads[0]['id']; ?></strong></td>
                                                        <td> <div class="mx-1"> Open Leads</div></td>
                                                        <td><strong id="openLeads"><?= $open_leads[0]['id']; ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong id="currentLeadsLastMonth"><?= $last_leads[0]['id']; ?></strong></td>
                                                        <td> <div class="mx-1"> Current Leads</div></td>
                                                        <td><strong id="currentLeads"><?= $current_leads[0]['id']; ?></strong></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-2">
                                            <table>
                                            <tbody>
                                                        <tr>
                                                            <td><strong>20</strong></td>
                                                            <td><div class="mx-1">Sales</div></td>
                                                            <td><strong>10</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>20</strong></td>
                                                            <td><div class="mx-1">Revenue</div></td>
                                                            <td><strong>10</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>20</strong></td>
                                                            <td><div class="mx-1">Due</div></td>
                                                            <td><strong>10</strong></td>
                                                        </tr>
                                                    </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-1">
                                        <button type="button" class="btn btn-primary float-right m-2 btn-sm" data-toggle="modal" data-target     ="#leadModel">
                                                New Lead
                                            </button>
                                        </div>
                                    <div class="col-md-6 ml-auto p-0">
                                        <div class="row">
                                            <div class="col-md-5 text-right pr-0"></div>
                                            <div class="col-md-7 pr-0 d-flex align-items-center">
                                                <label class="mt-0 bg-primary border-bottom-0 border-right-0" style="padding-block:1px; border:2px solid black; cursor:pointer;">Search <i class="fas fa-search"></i> &nbsp;</label>
                                                <input  id="searchValue" type="text" placeholder="Search" aria-label="Search"  onkeyup="searchValue()">
                                            </div>
                                        </div> 
                                    </div>
                                </div>


                                <div class="row card-title p-0 m-0 border-right-0"  style="font-size:smaller;">
                                        <div class="table-responsive p-0 m-0">
                                            <table id="leads-table" class="p-0 m-0 table display nowrap"
                                            width="100%">
                                                <thead>
                                                    <tr>
                                                        <th class="border-right">Sr.No.</th>
                                                        <th class="border-right">Lead _Id</th>
                                                        <th class="border-right">Owner</th>
                                                        <th class="border-right">Name</th>
                                                        <th class="border-right">Email</th>
                                                        <th class="border-right">Mob_1</th>
                                                        <th class="border-right">Mob_2</th>
                                                        <th class="border-right">Source</th>
                                                        <th class="border-right">Days</th>
                                                        <th class="border-right">Last Call</th>
                                                        <th class="border-right">Next Call</th>
                                                        <!-- <th>Actions</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-2 font-size p-0 card-title">
                                    <div>
                                        <input type="hidden" id="userId" value="" />
                                        <div class="row mb-0 border-bottom-0 card-title" style="font-size:smaller;"     >
                                            <div class="col-12 p-0">
                                                <div class="row">
                                                    <div class="col-12 p-0 button-div">
                                                        <table class="table-borderless table-sm">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Name :</td>
                                                                    <td>
                                                                        <input type="text" name="" placeholder="Name" onkeyup="myFunction()" id="userName" class="form-control myform-control" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Status :</td>
                                                                    <td>
                                                                        <select id="userStatus" onkeyup="myFunction()" onchange="myFunction()" class="form-control myform-control" style="-webkit-appearance: auto;">
                                                                            <option value="">Select Status</option>
                                                                            <?php foreach ($enqStatus as $enqStatu) {
                                                                                ?>
                                                                                <option value="<?= $enqStatu['id'];?>"><?= $enqStatu['title'];?></option>
                                                                                <?php
                                                                            }?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <td>Last Call :</td>
                                                                    <td>
                                                                     <input class="form-control myform-control input-group" id="userLastCall" onkeyup="fetchDatasss(this,'userLastCall')" onchange="fetchDatasss(this,'userLastCall')"  data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Next Call :</td>
                                                                    <td>
                                                                        <input class="form-control myform-control input-group" id="userNextCall" onkeyup="fetchDatasss(this,'userNextCall')" onchange="fetchDatasss(this,'userNextCall')" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" />
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Followup Count :</td>
                                                                    <td>
                                                                     <input type="text" name="" placeholder="Followup Count" id="userFallow" class="form-control myform-control" disabled/>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Unsubscribe :</td>
                                                                    <td>
                                                                        <label class="radio-inline" for="subscribeYes">
                                                                            <input class="radio-inline" type="radio" name="userUnsubscribe" id="subscribeYes" value="1" /><span class="radio-btn-text"> Yes</span>
                                                                        </label>
                                                                        &nbsp&nbsp&nbsp
                                                                        <label class="radio-inline" for="subscribeNo">
                                                                            <input class="" type="radio" name="userUnsubscribe" id="subscribeNo" value="0">   <span class="radio-btn-text">No</span>
                                                                        </label>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                        <button class="btn btn-primary border d-none btn-sm" id="saveUserDetials">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-0 border-bottom-0 card-title " style="font-size:smaller;"    >
                                            <div class="col-12 pr-0">
                                                <div class="row">
                                                <div class="col-12 p-0 button-div">
                                                        <table class="table-borderless table-sm">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Bulk SMS :</td>
                                                                    <td>
                                                                    <select id="bulkSms" class="form-control myform-control" style="-webkit-appearance: auto;">
                                                                        <option value="">Select</option>
                                                                        <option value="all">All</option>
                                                                    </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> Smart SMS :</td>
                                                                    <td>
                                                                    <select id="smartSms" class="form-control myform-control" multiple="multiple" style="-webkit-appearance: auto;">
                                                            <?php if(count($allFirstMobiles)>0){foreach($allFirstMobiles as $mobile){
                                                                ?>
                                                                <option value="<?= $mobile['Mob_1'] ;?>"><?= $mobile['Mob_1'] ;?></option>
                                                                <?php
                                                            }}?>
                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>What'sApp :</td>
                                                                    <td>
                                                                        <select id="whatsApp" class="form-control myform-control" multiple="multiple" style="-webkit-appearance: auto;">

                                                                        <?php if(count($allFirstMobiles)>0){foreach($allFirstMobiles as $mobile){
                                                                            ?>
                                                                            <option class="singlewhatsApp" data-type="number" value="+91<?= $mobile['Mob_1'] ;?>"><?= $mobile['Mob_1'] ;?></option>
                                                                            <?php
                                                                        }}?>
                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Bulk Email :</td>
                                                                    <td>
                                                                    <select id="bulkEmails" class="form-control myform-control" multiple="multiple" style="-webkit-appearance: auto;">
                                                                        <?php if(count($allEmails)>0){foreach($allEmails as $all_email){
                                                                            ?>
                                                                            <option class="single" data-type="number" value="<?= $all_email['Email'] ;?>"><?= $all_email['Email'] ;?></option>
                                                                            <?php
                                                                        }}?>
                                                                    </select>
                                                                    </td>
                                                                </tr> 
                                                            </tbody>
                                                        </table>
                                                        <button id="sendMessage" class="btn btn-primary btn-sm">Send</button>
                                                    </div>
                                                   
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-0 border-bottom-0 card-title" style="font-size:smaller;">
                                            <div class="col-12 p-0">
                                                <div class="row" >
                                                  <div class="col-12 councler-state p-0" id="counsellerStates">
                                                         <?php if(count($follow_comment)>0){foreach($follow_comment as $comment){ ?>
                                                            <div class="row">
                                                               <div class="col-12 mt-2"><?= $comment['comments'];?></div>
                                                                <div class="col-12 text-right" style="font-size: x-small;"><em><?= $comment['full_name'];?> ,  <?= $comment['fallow_comments_time'];?></em></div>
                                                            </div>
                                                        <?php }}?>
                                                  </div>                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row card-title" style="font-size:smaller">
                                            <div class="col-12 pr-0">
                                                <div class="row" id="commentsRow">
                                                        <div class="col-9 pr-0 comment-box" id="commentBox">
                                                            <textarea name="" placeholder="Key comments" id="comments" class="form-control p-0" ></textarea>
                                                        </div>
                                                        <div class="col-3 text-right comment-box p-0" id="commentBtn">
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
    <?php include("modal.php");?>
    <script src="<?= base_url(); ?>/assets/js/xla-update-lead.js"></script>
    <script src="<?= base_url(); ?>/assets/js/dropzone.js"></script>
    <script src="<?= base_url(); ?>/assets/js/sweetalert2.js"></script>
    <script src="<?= base_url(); ?>/assets/js/pages/enquiry.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <!-- <script src="<?= base_url(); ?>/assets/js/pages/resizableColumns.min.js"></script> -->
<!--     <script src="<?= base_url(); ?>/assets/js/pages/colReorderWithResize.js"></script>
 -->

    <script src="<?= base_url(); ?>/assets/js/pages/jquery.dataTables.colResize.js"></script>
   
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
