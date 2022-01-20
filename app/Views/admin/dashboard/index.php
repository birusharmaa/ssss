<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>XLAcademy Admin</title>
  <?php include __DIR__ . '/../layout/cssLinks.php'; ?>
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
              Dashboard
            </h3>
          </div>
          <div class="row">
            <div class="col-md-3 mt-2">
              <div class="form-group">
                <label for="">User</label>
                <select name="" id="" class="form-control">
                  <option value="">Name</option>
                  <option value="">Name</option>
                  <option value="">Name</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 mt-2">
              <div class="form-group">
                <label for="">Source</label>
                <select name="" id="" class="form-control">
                  <option value="">Source</option>
                  <option value="">Source</option>
                  <option value="">Source</option>
                </select>
              </div>
            </div>
            <div class="col-md-3 mt-2">
              <div class="form-group">
                <label for="">From</label>
                <input type="date" class="form-control form-control-sm">
              </div>
            </div>
            <div class="col-md-3 mt-2">
              <div class="form-group">
                <label for="">To</label>
                <input type="date" class="form-control form-control-sm">
              </div>
            </div>
          </div>
          <div class="row grid-margin">
            <?php for($i=1; $i<=10; $i++) {?>
            <div class="col-md-3 mt-2">
              <div class="card card-widgit">
                <div class="card-body">
                  <div class="statistics-item">
                    <p>
                      Collection
                    </p>
                    <h2>7500</h2>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
        </div>
        <?php include __DIR__ . '/../layout/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../layout/jsLinks.php'; ?>
</body>
</html>