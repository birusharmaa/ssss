<?php
$session = session();
$emp = $session->get('loginInfo');


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>XLAcademy Admin</title>
  <?php include __DIR__ . '/../layout/cssLinks.php'; ?>
  <script src="<?= base_url(); ?>/public/assets/js/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="<?= base_url(); ?>/public/assets/css/timeline.css">
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
             Fee Collection
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Daily Activity</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fee Collection</li>
              </ol>
            </nav>
          </div>          
          <div id="alertMessage"></div>
          <div class="card">
            <div class="card-body">

              <div class="row card-title">
                <div class="col-sm-12">
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <div class="table-responsive">
                    <table id="leads-table" class="table">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php $num=0;
                         if (!empty($leads)) : $i = 1; ?>
                          <?php foreach ($leads as $lead) : ?>
                            <?php if($num==0){ $num= $lead->id; }?>                            
                            <tr>
                              <td><?= $i++ ?></td>
                              <td>
                              <a href="#" style="color: #000000;" onclick="loadTimeline(<?= $lead->lead_id ?>);" ><?php echo $lead->Name;?></a>
                              </td>
                              <td><?= $lead->Email ?></td>                              
                              <td>                             
                                <button class="btn btn-outline-primary fee_btn" data-toggle="modal" value="<?= $lead->id; ?>" data-target=".bd-example-modal-lg">
                                    Collect Fee
                                </button>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                          <input type="hidden" id="first_id" name="first_id" value="<?php echo $num?>">
                        <?php else : ?>                           
                          <tr>
                            <td colspan="8">No lead found</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>           
                <div class="col-6">  
                  <div class="row">                    
                      <div class="history-tl-container" >
                        <ul class="tl" id="dy_timeline"></ul>
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

     
<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fee Collection Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">            
        <form id="fee_collection">           
            <input type="hidden" id="lead_id" name="lead_id">  
              <div class="row">
                <div id="note" class="text-danger"></div>              
              </div>                      
              <div class="row">               
                <div class="col-4">
                    <div class="form-group">
                        <lable>Current Pay Amount</lable>
                        <input type="number" name="paid_amount" id="paid_amound" class="form-control" onkeyup="changeStatus(this.value)" required>   
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <lable>Payment Circle</lable>                        
                        <select class="form-control" name="payment_circle" onchange="payment(this.value);" required>
                            <option value=''>select </option>
                            <option value='1'>Monthly </option>
                            <option value='2'>Yearly</option>                            
                        </select> 
                      </div>    
                </div> 
                <div class="col-4">
                    <div class="form-group">
                        <lable>Payment Type</lable> 
                        <input type="text" name="payment_type" id="payment_type" class="form-control" readonly> 
                      </div>
                </div>
            </div>                         
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <lable>Payment mode</lable>
                        <select class="form-control" name="payment_mode" required>
                            <option value=''>select </option>
                            <option value='1'>Cash </option>
                            <option value='2'>Check</option>
                            <option value='3'>Online</option>
                        </select>
                    </div>    
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <lable>Paid By</lable>
                        <select class="form-control" name="paid_by" required>
                            <option value=''>select </option>
                            <option value='1'>Student </option>
                            <option value='2'>Parents</option>
                            <option value='3'>Other</option>                           
                        </select> 
                    </div>
                </div>
            </div>            
            <div class="row">
                <div class="col-6">
                    <div class="text-group">
                        <lable>Remark</lable>
                        <textarea class="form-control" name="remark" required></textarea>
                    </div>                    
                </div>
                <div class="col-6">
                <div class="row mt-2"> 
                  <div class="col-md-6"></div>              
                    <div class="col-md-6">
                          <div class="row">
                            <h5 class="text-primary mr-4" >Total Fee :- </h5> 
                            <h5 id="total_fee"></h5> 
                          </div>                        
                          <div class="row">
                            <h5 class="text-primary mr-4">Total Paid :- </h5>
                            <h5 id="total_Paid"></h5> 
                          </div> 
                          <div class="row">
                            <h5 class="text-primary mr-4">Total Balance :-</h5>
                            <h5 id="balance_amount"></h5>
                          </div>                                                           
                        </div>         
                    </div>
                  </div>        
                </div>          
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div> 
        </form>       
      </div>    
    </div>
  </div>
</div>
<script src="<?= base_url(); ?>/public/assets/js/xla_fee_collection.js"></script>                       
<script src="<?= base_url(); ?>/public/assets/js/xla-update-lead.js"></script>
   
    <script>
      $(document).ready(function() {
        $('#leads-table').DataTable();
      });
    </script>
</body>

</html>

