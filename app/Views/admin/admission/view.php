<?php
helper(['number', 'general']);
// echo '<pre>';
// print_r($lead);die()
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>XLAcademy Admin</title>
  <?php include __DIR__ . '/../layout/cssLinks.php'; ?>
  <script src="<?= base_url(); ?>/assets/js/jquery-3.6.0.min.js"></script>
</head>
<style>
  .custom_row {
    height: auto;
    border-bottom: 1px solid gainsboro;
    padding-top: 10px;
    min-height: 40px;
  }
</style>

<body class="sidebar-fixed">
  <div class="container-scroller">
    <?php include __DIR__ . '/../layout/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include __DIR__ . '/../layout/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              Lead-Views
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>               
                <li class="breadcrumb-item active" aria-current="page">Lead</li>
              </ol>
            </nav>
          </div>

          <div class="container">
            <div class="row">
              <div class="col-md-4">
                <div class="card">
                  <div class="card-body">
                    <div class="text-center pb-4">
                      <?php if (!empty($lead->Photo)) : ?>
                        <!-- <img src="https://www.sarojhospital.com/images/testimonials/dummy-profile.png" alt="profile" class="img-lg rounded-circle mb-3" /> -->
                        <img src="<?= $lead->Photo ?>" alt="profile" class="img-lg rounded-circle mb-3" />
                      <?php else : ?>
                        <img src="/assets/images/faces/face12.jpg" alt="profile" class="img-lg rounded-circle mb-3" />

                      <?php endif; ?>
                      <h3><?= ucfirst($lead->Name) ?></h3>
                      <p class="text-center"><?= $lead->host_name ?></p>
                      <button class="btn btn-primary mr-2 next-followup-btn" data-id="<?= $lead->id ?>" data-lead-title="<?= $lead->Name ?>">Follow Up</button>
                      <button class="btn btn-primary mr-2 unsubscribe-leads" status="<?= ($lead->Unsubscribe == 0) ? 1 : 0; ?>" data-id="<?= $lead->id ?>"><?= ($lead->Unsubscribe == false) ? 'Unsubscribe' : 'Subscribe'; ?></button>
                    </div>
                  </div>
                </div>
                <div class="card mt-2">
                  <div class="card-body">

                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Lead id</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= $lead->id ?></h6>
                      </div>
                    </div>                  
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">System Name</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= $lead->Sys_Name ?></h6>
                      </div>
                    </div>
                   
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">User Name</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"><?= $sessData['full_name'] ?></h6>
                      </div>
                    </div>
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Entry Date</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= dateFormat($lead->Data_Entry) ?></h6>
                      </div>
                    </div>

                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Key Comments</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= $lead->Key_Comment ?></h6>
                      </div>
                    </div>
                    <!-- <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Subscribe Status</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="text-info"><?= ($lead->Unsubscribe == false) ? 'Subscribe' : 'Unsubscribe'; ?></h6>
                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="card" id="Update_card" style="display:none;">
                  <div class="card-body">
                    <div id="alertMessage"></div>
                    <h4 class="card-title"><strong>Upadate lead</strong></h4>
                    <form class="forms-sample" id="update-add-lead">
                      <input type="hidden" id="leadid" value="<?= (isset($lead->id) == true) ? $lead->id : '' ?>">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3">
                            <lable>Full Name</lable>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="Name" placeholder="Name" value="<?= ucfirst($lead->Name) ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3">
                            <lable>Email</lable>
                          </div>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="Email" placeholder="Email" value="<?= $lead->Email ?>">
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3">
                            <lable>Phone</lable>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="phone" name="Mob_1" placeholder="Phone" value="<?= $lead->Mob_1 ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3">
                            <lable>Phone 2</lable>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="phone-1" name="Mob_2" placeholder="Phone" value="<?= $lead->mob_2 ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3">
                            <lable>City</lable>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="City" name="City" placeholder="City" value="<?= $lead->City ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3">
                            <lable>Location</lable>
                          </div>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="Location" name="Location" placeholder="Location" value="<?= $lead->Location ?>">
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3">
                            <lable>Source</lable>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" id="Source" name="Source" onchange="source_other(this.value)">
                              <option value="">Select</option>
                              <?php if (!empty($sources)) : ?>
                                <?php foreach ($sources as $item) : ?>
                                  <option value="<?= $item['id'] ?>" 
                                  <?php
                                      if ($lead->Source) {
                                         echo ($item['id'] == $lead->Source) ? 'selected' : '';
                                      }?>                                  
                                 ><?= $item['title'] ?></option>
                                <?php endforeach;
                              else : ?>
                                <option value="">Not Found</option>
                              <?php endif; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group" id="other_sourse_area" style="display:none;">
                        <div class="row">
                          <div class="col-sm-3">
                            <lable>Other Source Description</lable>
                          </div>
                          <div class="col-sm-9">
                            <textarea class="form-control" rows="1" cols="50" name="other_sourse"></textarea>   
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-sm-3">
                            <lable>Category</lable>
                          </div>
                          <div class="col-sm-9">
                            <select class="form-control" id="category" name="Category">
                              <option value="">Select</option>
                              <?php if (!empty($categories)) : ?>
                                <?php foreach ($categories as $item) : ?>
                                  <option value="<?= $item->id ?>" <?= ($item->id == $lead->Enq_Course) ? 'selected' : '' ?>><?= $item->title ?></option>
                                <?php endforeach;
                              else : ?>
                                <option value="">Not Found</option>
                              <?php endif; ?>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <button type="submit" class="btn btn-primary mr-2">Update</button>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="card" id="View_card">
                  <div class="card-body">
                    <h4 class="card-title"><strong>View Lead</strong></h4>                    
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Full Name</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= ucfirst($lead->Name) ?></h6>
                      </div>
                    </div>
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Email</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= $lead->Email ?></h6>
                      </div>
                    </div>
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Phone</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= $lead->Mob_1 ?></h6>
                      </div>
                    </div>
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Phone 2</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= $lead->mob_2 ?></h6>
                      </div>
                    </div>
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">City</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= $lead->City ?></h6>
                      </div>
                    </div>
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Location</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= $lead->Location ?></h6>
                      </div>
                    </div>
                    
                    <div class="row custom_row">
                      <div class="col-sm-5">
                        <h6 class="mb-0">Course Name</h6>
                      </div>
                      <div class="col-sm-7">
                        <h6 class="mb-0"> <?= $lead->title; ?></h6>
                      </div>
                    </div>
                    <div class="row mt-2">
                      <button onclick="View_Change();" class="btn btn-primary mr-2">Edit</button>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="card mt-2">
                      <div class="card-body">
                        <div class="row">
                          <h5>Last Follow Up</h5>
                        </div>
                        <?php if ($comments) {
                          foreach ($comments as $val) { ?>
                            <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">Subject</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"> <?= $val->subject ?></h6>
                              </div>
                            </div>
                            <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">Last Comment</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"> <?= $val->comments ?></h6>
                              </div>
                            </div>
                            <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">Next Follow up</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"> <?= $val->followup_date . ': ' . $val->followup_time ?></h6>
                              </div>
                            </div>
                            <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">FollouUp Counts</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"> <?= followCount($val->lead_id); ?></h6>
                              </div>
                            </div>
                            <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">Followup Days</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"> <?= getFollowUpDays($val->created_at) ?></h6>
                              </div>
                            </div>
                            <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">Next Followup Date</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"> <?= dateFormat($lead->Follow_Up_Dt) ?></h6>
                              </div>
                            </div>
                            <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">Last updated by</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"> <?= getUser($lead->Last_Updated_By) ?></h6>
                              </div>
                            </div>

                        <?php }
                        } ?>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card mt-2">
                      <div class="card-body">
                        <div class="row">
                          <h5></h5>
                        </div>
                        <div class="row custom_row">
                          <div class="col-sm-5">
                            <h6 class="mb-0">Enquiry Date</h6>
                          </div>
                          <div class="col-sm-7">
                            <h6 class="mb-0"> <?= dateFormat($lead->Enq_Dt) ?></h6>
                          </div>
                        </div>                       

                          <div class="row custom_row">
                            <div class="col-sm-5">
                              <h6 class="mb-0">Lead Owner</h6>
                            </div>
                            <div class="col-sm-7">
                              <h6 class="mb-0"> <?= $lead->User_Name ?></h6>
                            </div>
                          </div>
                          <div class="row custom_row">
                            <div class="col-sm-5">
                              <h6 class="mb-0">Course Value</h6>
                            </div>
                            <div class="col-sm-7">
                              <h6 class="mb-0"> <?= number_to_amount($lead->Course_Value) ?></h6>
                            </div>
                          </div>  
                           <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">Source</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"> <?= !empty($lead->Source)? getSource($lead->Source):'' ?></h6>
                              </div>
                            </div>
                            <?php if($lead->Source == 5): ?>
                              <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">Source Description</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"><?php echo $lead->other_sourse; ?></h6>
                              </div>
                            </div>
                            <?php endif; ?>
                          
                            <div class="row custom_row">
                              <div class="col-sm-5">
                                <h6 class="mb-0">Status</h6>
                              </div>
                              <div class="col-sm-7">
                                <h6 class="mb-0"> <?= !empty($lead->status)? 'Active':'' ?></h6>
                              </div>
                            </div>
                        <?php 
                        // $paid_amount = 0;
                      
                        // if ($paid_amount ==  $lead->Course_Value) {
                        //   $feeStatus = "Full Fee Submitted.";
                        // } else if ($paid_amount < $lead->Course_Value) {
                        //   $feeStatus = "Pending.";
                        // } ?>
                        <!-- <div class="row custom_row">
                          <h5 class="text-info"><?php // echo  $feeStatus; ?></h5>
                        </div> -->
                        <!-- <div class="row mt-2">
                          <strong>Click here for check fee Detials.<strong>
                             <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target=".bd-example-modal-lg">
                                Fee detials.
                              </button>
                        </div> -->
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
    <script src="<?= base_url(); ?>/assets/js/xla-update-lead.js"></script>
    <script src="<?= base_url(); ?>/assets/js/xla_fee_collection.js"></script>
    <script src="<?= base_url(); ?>/assets/js/xla-followups.js"></script>
    <!-- Modal -->
    <div class="modal fade" id="followupsModal" tabindex="-1" role="dialog" aria-labelledby="followupsModalTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="followupsModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="followps-lead-forms">
              <input type="hidden" name="lead_id" id="lead_id">
              <div class="row mt-2" id="calltype">
                <div class="col-sm-4">Call Type</div>
                <div class="col-sm-8">
                  <select id="calltypesel" class="form-control" required="" name="call_type">
                    <option value="">select</option>
                    <option value="1">Incoming</option>
                    <option value="2">Outgoing </option>
                  </select>
                </div>
              </div>
              <div class="row mt-2 d-none" id="callstatus">
                <div class="col-sm-4">Call Status</div>
                <div class="col-sm-8">
                  <select id="callstatussel" class="form-control" name="call_status" required="">
                    <option value="">select</option>
                      <?php if ($callStatus):
                        foreach($callStatus as $value): ?>
                          <option value="<?= $value->id; ?>"><?= $value->title; ?></option>
                        <?php endforeach;
                      endif;?>  
                  </select>
                </div>
              </div>
              <div class="row mt-2 d-none" id="subject_div">
                <div class="col-sm-4">Subject</div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="subject">
                </div>
              </div>
              <div class="row mt-2 d-none" id="comments_div">
                <div class="col-sm-4">Comments</div>
                <div class="col-sm-8">
                  <textarea id="comments" class="form-control" cols="30" name="comments"></textarea>
                </div>
              </div>
              <div class="row mt-2 d-none" id="followup_div">
                <div class="col-sm-4">Follow Up</div>
                <div class="col-sm-4">
                  <input type="date" class="form-control" name="followup_date">
                </div>
                <div class="col-sm-4">
                  <input type="time" class="form-control" name="followup_time">
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
          </form>
        </div>
      </div>
    </div>


    <script>
      $(document).ready(function() {
        $('#leads-table').DataTable();
      });
    </script>
</body>

</html>



<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fee Detials</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th>#</th>
              <th>Paid Amount</th>
              <th>Paid Date</th>
              <th>Paid By</th>
              <th>Payment Mode</th>
              <th>Remark</th>
              <th>User System Name</th>
              <th>User Name</th>
              <th>User Email</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0;
            $num = 0;
            
            if (!empty($feeCollection)) {
              foreach ($feeCollection as $values) { ?>
                <tr>
                  <td><?= ++$num . '.'; ?></td>
                  <td>
                    <?php $total += $values->paid_amount; ?>
                    <?php echo $values->paid_amount . '/-'; ?>
                  </td>
                  <td><?= $values->created_at; ?></td>
                  <td>
                    <?php if ($values->paid_by == 1) :
                      echo "Student";
                    elseif ($values->paid_by == 2) :
                      echo "Parents";
                    else : echo "Other";
                    endif; ?>
                  </td>
                  <td>
                    <?php if ($values->payment_mode == 1) :
                      echo "Cash";
                    elseif ($values->payment_mode == 2) :
                      echo "Check";
                    else : echo "Online";
                    endif; ?>
                  </td>
                  <td><?= $values->remark; ?></td>
                  <td><?= $values->sys_name; ?></td>
                  <td><?= $values->full_name; ?></td>
                  <td><?= $values->personal_email; ?></td>
                </tr>
              <?php } ?>
            <?php  } ?>
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-8"></div>
          <div class="col-md-4">
            <div class="row">
              <div class="col-md-5">
                Total Fee :- </br>
                Total Paid Amount:-</br>
                Balance Amount:-
              </div>
              <div class="col-md-7 text-danger">
                <?= $lead->Course_Value . '/-' ?></br>
                <?php echo $total . '/-'; ?> </br>
                <?php echo $lead->Course_Value - $total . '/-'; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
    function source_other(value){
    console.log(value);
    if(value ==5){
      document.getElementById('other_sourse_area').style.display = "block";
    }else{
      document.getElementById('other_sourse_area').style.display = "none";
    }  
  }
</script>