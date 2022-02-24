<?php 
$session = session();
$data = $session->get('loginInfo');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $pageTitle ?></title>
    <?php include __DIR__ . '/../../../layout/cssLinks.php'; ?>
    <script src="<?= base_url(); ?>/public/assets/js/jquery-3.6.0.min.js"></script>
</head>

<body class="sidebar-fixed">
    <div class="container-scroller">
        <?php include __DIR__ . '/../../../layout/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
          <?php include __DIR__ . '/../../../layout/sidebar.php'; ?>
          <div class="main-panel">
            <div class="content-wrapper">
              <div class="page-header">
                <h3 class="page-title">
                  <?= $pageHeading ?>
                </h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Enquiry Status</li>
                  </ol>
                </nav>
              </div>

              
              <div class="page-content">
                <div class="card">
                  <div class="card-header">
                    <div class="row m-0">
                      <div class="col-12">
                        <input type="hidden" name="enqid" id="enqid" value="" />
                        <form id="enqForm">                                                  
                          <div class="row">
                            <div class="col-md-4">
                                <div class="input-field" id="inputField" style="display: none;">
                                    <input type="text" name="title" class="form-control account" placeholder="Enter Title" id="title" required  />
                                   
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-field" id="descriptionField" style="display: none;">
                                    <textarea class="form-control"  rows="1" cols="50" name="description" id="description" placeholder="Enter description."></textarea>  
                                    <a href="javascript:void(0)" onclick="hideFeild()"><i class="fas fa-times mt-3 pl-2"></i></a>
                                </div>       
                            </div>                             
                            <div class="col-md-4 text-right">
                              <button class="btn btn-primary add-new"><i class="fas fa-plus"></i> Add New</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="enqDatatable" class="table">
                        <thead>
                          <tr>
                            <th>Sr.No.</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody> </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include __DIR__ . '/../../../layout/footer.php'; ?>
    </div>
    <?php include __DIR__ . '/../../../layout/jsLinks.php'; ?>
    <script src="<?= base_url(); ?>/public/assets/js/xla-profile.js"></script>
    <script src="<?= base_url(); ?>/public/assets/js/enqstatus.js"></script>
    <script>
        $(document).ready(function() {
            $('#leads-table').DataTable();
        });

        $(".add-new").click(function (e) {
          e.preventDefault();
          $("#inputField").show();
          $("#descriptionField").show();          
          $("#inputField").addClass("d-flex");
          $("#descriptionField").addClass("d-flex");
          $("#title").focus();
          $(".add-new").removeClass('add-new').addClass('save-enq');
          $(".save-enq").html('');
          $(".save-enq").html('<i class="far fa-save mr-2"></i>Save');
        });

       
    </script>
</body>
</html>