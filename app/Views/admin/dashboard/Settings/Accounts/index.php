<?php $session = session();
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
                <li class="breadcrumb-item active" aria-current="page">Accounts</li>
              </ol>
            </nav>
          </div>
          <div class="page-content">
            <div class="card">
              <div class="card-header">
                <div class="row m-0">
                  <div class="col-md-8"></div>
                  <div class="col-md-8 offset-11"><button class="btn btn-primary"> <i class="fas fa-plus"></i> Add New</button></div>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="leads-table" class="table">
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
  </div>
  </div>
  <?php include __DIR__ . '/../../../layout/jsLinks.php'; ?>
  <script src="<?= base_url(); ?>/assets/js/xla-profile.js"></script>

  <script>
    $(document).ready(function() {
      $('#leads-table').DataTable();
    });
  </script>
</body>

</html>