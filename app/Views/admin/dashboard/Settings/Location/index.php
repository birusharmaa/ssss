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
                <li class="breadcrumb-item active" aria-current="page">Location</li>
              </ol>
            </nav>
          </div>


          <div class="page-content">
            <div class="card">
              <div class="card-header">
                <div class="row m-0">
                  <div class="col-12">
                    <input type="hidden" name="locationid" id="locationid" value="" />
                    <form id="locationForm">
                      <input type="hidden" name="created_by" value="<?= $data['emp_id']; ?>" />
                      <div class="row">
                        <div class="col-md-6">
                          <div class="input-field" id="inputField" style="display: none;">
                            <input type="text" name="location_name" class="form-control location" placeholder="Enter Location" id="location_name" required />
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
                  <table id="locationDatatables" class="display responsive nowrap">
                    <thead>
                      <tr>
                        <th>Sr.No.</th>
                        <th>Location Name</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
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
  <script src="<?= base_url(); ?>/assets/js/location.js"></script>

</body>

</html>