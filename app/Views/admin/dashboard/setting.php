<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $pageTitle ?></title>
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
              <?= $pageHeading ?>
            </h3>
          </div>
          <div class="row">
            <div class="col-md-3 mt-2">
              <div class="form-group">
                <label for="">Company Name</label>
                <input type="text" class="form-control form-control-sm">
              </div>
            </div>
            <div class="col-md-3 mt-2">
              <div class="form-group">
                <label for="">Company Phone</label>
                <input type="text" class="form-control form-control-sm" name="company-phone" id="company-phone">
              </div>
            </div>
            <div class="col-md-3 mt-2">
            <div class="form-group">
                <label for="">Company Email</label>
                <input type="email" class="form-control form-control-sm" name="company-phone" id="company-phone">
              </div>
            </div>
            <div class="col-md-3 mt-2">
              <div class="form-group">
                <label for="company-vat-number">Company Vat Number</label>
                <input type="text" class="form-control form-control-sm" id="company-vat-number">
              </div>
            </div>
          </div>
        
          <div class="row grid-margin" id="setting-page">
            <section>

            </section>
          </div>
        </div>
        <?php include __DIR__ . '/../layout/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../layout/jsLinks.php'; ?>
</body>

</html>