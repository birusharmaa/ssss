
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>XLAcademy Admin</title>
  <?php include __DIR__ . '/../layout/cssLinks.php'; ?>
  <script src="<?=base_url();?>/assets/js/jquery-3.6.0.min.js"></script>
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
              Leads
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Leads</a></li>
                <li class="breadcrumb-item active" aria-current="page">leads</li>
              </ol>
            </nav>
          </div>
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Leads</h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="leads-table" class="table">
                      <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Purchased On</th>
                            <th>Customer</th>
                            <th>Ship to</th>
                            <th>Base Price</th>
                            <th>Purchased Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for($i=1; $i<=20; $i++){ ?>
                          <tr>
                              <td><?= $i ?></td>
                              <td>2012/08/03</td>
                              <td>Edinburgh</td>
                              <td>New York</td>
                              <td>$1500</td>
                              <td>$3200</td>
                              <td>
                                <label class="badge badge-info">On hold</label>
                              </td>
                              <td>
                                <button class="btn btn-outline-primary">View</button>
                              </td>
                          </tr>
                        <?php }?>
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

  <script>
  $(document).ready(function() {
    $('#leads-table').DataTable();
  });
</script>
</body>
</html>