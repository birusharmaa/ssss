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
    <script src="<?= base_url(); ?>/assets/js/jquery-3.6.0.min.js"></script>
</head>

<body class="sidebar-icon-only">
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
                    <li class="breadcrumb-item active" aria-current="page">Accounts</li>
                  </ol>
                </nav>
              </div>

              
              <div class="page-content">
                <div class="card">
                  <div class="card-header">
                    <div class="row m-0">
                      <div class="col-12">
                        <input type="hidden" name="accountId" id="accountId" value="" />
                        <form id="acoountName">
                          <input type="hidden" name="created_by" value="<?= $data['emp_id']; ?>" />
                          <input type="hidden" name="updated_by" value="<?= $data['emp_id']; ?>" />
                          <div class="row">
                            <div class="col-md-6">
                              <div class="input-field" id="inputField" style="display: none;">
                                <input type="text" name="account_name" class="form-control account" placeholder="Enter Account" id="account_name" required  />
                                <a href="javascript:void(0)" onclick="hideAccountFeild()"><i class="fas fa-times mt-3 pl-2"></i></a>
                              </div>
                            </div>
                            <div class="col-md-6 text-right">
                              <button class="btn btn-primary add-new"><i class="fas fa-plus"></i> Add New</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive border p-2">
                      <table id="accountDatatables" class="display responsive nowrap">
                        <thead>
                          <tr>
                            <th>Sr.No.</th>
                            <th>Account</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php if (!empty($leads)) :
                            $i = 1;
                          ?>
                            <?php foreach ($leads as $lead) : ?>
                              <tr>
                                <td><?= $i++ ?></td>
                                <td> <a href="<?= base_url('admin/add_lead/' . $lead->lead_id) ?>"> <?= $lead->Name ?></a></td>
                                <td>
                                  <button class="btn btn-outline-primary"> <a href="<?= base_url('admin/add_lead/' . $lead->lead_id) ?>">View</a> </button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                          <?php endif; ?>
                        </tbody>
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
    <script src="<?= base_url(); ?>/assets/js/xla-profile.js"></script>
    <script src="<?= base_url(); ?>/assets/js/accounts.js"></script>
    <script>
        $(document).ready(function() {
            $('#leads-table').DataTable();
        });

        $(".add-new").click(function (e) {
          e.preventDefault();
          $("#inputField").show();
          $("#inputField").addClass("d-flex");
          $("#account_name").focus();
          $(".add-new").removeClass('add-new').addClass('save-account');
          $(".save-account").html('');
          $(".save-account").html('<i class="far fa-save mr-2"></i>Save Account');
        });
     
    </script>
</body>
</html>