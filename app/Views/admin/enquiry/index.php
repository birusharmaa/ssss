<?php
$session = session();
// echo "<pre>";
// print_r($current_leads);
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
                                        <div class="col-md-4 offset-3">
                                            <div class="row">
                                                <div class="col-md-4 text-right">
                                                    <span ><?= $last_month_count[0]['id']; ?>
                                                </div>
                                                <div class="col-md-4">
                                                    Total Leads
                                                </div>
                                                <div class="col-md-4">
                                                    <span ><?= $current_month_count[0]['id']; ?>
                                                </div>
                                                <div class="col-md-4 text-right mt-2">
                                                    <span><?= $last_open_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    Open Leads
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span><?= $open_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-4 text-right mt-2">
                                                    <?= $last_leads[0]['id']; ?>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    Current Leads
                                                </div>
                                                <div class="col-md-4 mt-2">
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
                                                <div class="col-md-4 text-right mt-2">
                                                    10
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    Revenue
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    10
                                                </div>
                                                <div class="col-md-4 text-right mt-2">
                                                    10
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    Due
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    20
                                                </div>
                                            </div>
                                        </div>
                                      
                                        <div class="col-md-1">
                                            <button type="button" class="btn btn-primary float-right m-2" data-toggle="modal" data-target     ="#leadModel">
                                                New Lead
                                            </button>
                                            <!-- <button type="button" class="btn btn-primary float-right m-0" data-toggle="modal" data-target     ="#leadModelImport">
                                                Import Lead
                                            </button> -->
                                        </div>
                                    </div>
                                  
                                    <!-- part 2 -->
                                    <div class="row card-title shadow-lg p-3 mb-2 bg-white rounded border" style="font-size:smaller;">
                                        <div class="col-sm-3">
                                            <div class="row">
                                                <div class="col-md-4 pr-0">
                                                    <label>Status</label>
                                                </div>
                                                <div class="col-md-8 pl-0">
                                                    <select name="" id="enqStatus" class="form-control" onchange="fetchData()">
                                                        <option value="">select</option>
                                                        <?php foreach ($enqStatus as $enq_status) {
                                                            ?>
                                                            <option value="<?= $enq_status['id'];?>"><?= $enq_status['title'];?></option>
                                                            <?php
                                                        }?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2 pr-0">
                                                    <label>Lead Owner</label>
                                                </div>
                                                <div class="col-md-8 mt-2 pl-0">
                                                    <select name="" id="ownerId" class="form-control" onchange="fetchData()">
                                                        <option value="">select</option>
                                                        <?php foreach ($usersData as $user_data) {
                                                            ?>
                                                            <option value="<?= $user_data['emp_id'];?>"><?= $user_data['full_name'];?></option>
                                                            <?php
                                                        }?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2 pr-0">
                                                    <label>Source</label>
                                                </div>
                                                <div class="col-md-8 mt-2 pl-0">
                                                    <select name="" id="sourceId" class="form-control" onchange="fetchData()">
                                                        <option value="">select</option>
                                                        <?php foreach ($sourceModel as $source_model) {
                                                            ?>
                                                            <option value="<?= $source_model['id'];?>"><?= $source_model['title'];?></option>
                                                            <?php
                                                        }?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mt-2 pr-0">
                                                    <label>Follow-up</label>
                                                </div>
                                                <div class="col-md-8 mt-2 pl-0" onchange="fetchData()" onkeyup="fetchData()">
                                                    <input type="number" id="followUp" class="form-control" placeholder="Follow-up" />
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="row">
                                                <div class="col-md-4 pr-0">
                                                    <label>Enq_Dt</label>
                                                </div>
                                                <div class="col-md-8 pl-0">
                                                    <input type="date" id="enqDate" class="form-control" onchange="fetchData()" onkeyup="fetchData()"/>
                                                </div>
                                                <div class="col-md-4 mt-2 pr-0">
                                                    Follow-up Date
                                                </div>
                                                <div class="col-md-8 mt-2 pl-0">
                                                    <input type="date" id="followUpDate" class="form-control" onchange="fetchData()" onkeyup="fetchData()" />
                                                </div>
                                                
                                                <div class="col-md-4 mt-2 pr-0">
                                                    <label>Location</label>
                                                </div>
                                                <div class="col-md-8 mt-2 pl-0">
                                                    <input type="text" onkeyup="fetchData()" id="location" placeholder="Location" class="form-control" />
                                                </div>
                                                <div class="col-md-4 mt-2 pr-0">
                                                    <label>City</label>
                                                </div>
                                                <div class="col-md-8 mt-2 pl-0">
                                                    <input type="text" onkeyup="fetchData()" id="city" placeholder="City" class="form-control" />
                                                </div>

                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="row mt-5">
                                                <div class="col-md-2 text-right">
                                                    <span id="totalLeadsLastMonth"><?= $last_month_count[0]['id']; ?>
                                                </div>
                                                <div class="col-md-6">
                                                    Total Leads
                                                </div>
                                                <div class="col-md-4">
                                                    <span id="totalLeads"><?= $current_month_count[0]['id']; ?>
                                                </div>
                                                <div class="col-md-2 text-right mt-2">
                                                    <span class="" id="openLeadsLastMonth"><?= $last_open_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    Open Leads
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="" id="openLeads"><?= $open_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-2 text-right mt-2">
                                                    <span class="" id="currentLeadsLastMonth"><?= $last_leads[0]['id']; ?></span>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    Current Leads
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="" id="currentLeads"><?= $current_leads[0]['id']; ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div class="row mt-5">
                                                <div class="col-md-4 text-right">
                                                    <span class="">12</span>
                                                </div>
                                                <div class="col-md-4">
                                                    Sales
                                                </div>
                                                <div class="col-md-4">
                                                    <span class="">10</span>
                                                </div>
                                                <div class="col-md-4 text-right mt-2">
                                                    <span class="">30</span>
                                                </div>
                                                <div class="col-md-4 mt-2 mt-2" >
                                                    Revenue
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <span class="">10</span>
                                                </div>
                                                <div class="col-md-4 text-right mt-2">
                                                    <span class="">10</span>
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    Due
                                                </div>
                                                <div class="col-md-4 mt-2">
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
                                                    <div class="col-5 mt-2 ">
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
                                                    <div class="col-6 mt-3"> 
                                                        <label class="radio-inline" for="subscribeYes">
                                                            <input class="radio-inline" type="radio" name="userUnsubscribe" id="subscribeYes" value="1" /><span class="radio-btn-text"> Yes</span>
                                                        </label>
                                                        &nbsp&nbsp&nbsp
                                                        <label class="radio-inline" for="subscribeNo">
                                                            <input class="" type="radio" name="userUnsubscribe" id="subscribeNo" value="0">   <span class="radio-btn-text">No</span>
                                                        </label>
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
