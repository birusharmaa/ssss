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
  <script src="<?= base_url(); ?>/public/assets/css/dropzone.css"></script>
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
              Admission
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Daily Activity</a></li>
                <li class="breadcrumb-item active" aria-current="page">Admission</li>
              </ol>
            </nav>
          </div>          
          <div id="alertMessageview"></div>
          <div class="card">
            <div class="card-body">

              <div class="row card-title">
                <div class="col-sm-12">
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="leads-table" class="table">
                      <thead>
                        <tr>
                          <th>Sr.No.</th>
                          <th>Lead Name</th>
                          <th>Email</th>
                          <th>Contact No.</th>
                          <th>City</th>
                          <th>Course</th>
                          <th>Status</th>
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
                              <td><?= $lead->Email ?></td>
                              <td><?= $lead->Mob_1 ?></td>
                              <td><?= $lead->City ?></td>
                              <td><?= $lead->category_name ?></td>
                              <td>
                                <label class="badge badge-info"><?= $lead->call_status_title?></label>
                              </td>
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
    </div>
    <?php include __DIR__ . '/../layout/jsLinks.php'; ?>
    <script src="<?= base_url(); ?>/public/assets/js/xla-update-lead.js"></script>
    <script>
      $(document).ready(function() {
        $('#leads-table').DataTable();
      });
    </script>
</body>

</html>

