<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $pageTitle ?></title>
  <?php include __DIR__ . '/../../layout/cssLinks.php'; ?>
</head>

<body class="sidebar-fixed">
  <div class="container-scroller">
    <?php include __DIR__ . '/../../layout/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include __DIR__ . '/../../layout/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <?= $pageHeading ?>
            </h3>
          </div>
          <div id="alertMessage"></div>
          <form id="settingForm">
            <div class="row">
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="">Company Name</label>
                  <input type="text" class="form-control form-control-sm" name="company_name" value="<?= isset($settingData)?$settingData[7]['setting_value']:''?>" required>
                </div>
              </div>
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="">Company Phone</label>
                  <input type="text" class="form-control form-control-sm" name="company_phone" id="company-phone" value="<?= isset($settingData)?$settingData[8]['setting_value']:''?>" required>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="">Company Email</label>
                  <input type="email" class="form-control form-control-sm" name="company_email" id="company-email"  value="<?= isset($settingData)?$settingData[6]['setting_value']:''?>" required>
                </div>
              </div>
              <div class="col-md-6 mt-2">
                <div class="form-group">
                  <label for="company-vat-number">Company Vat Number</label>
                  <input type="text" class="form-control form-control-sm" name="company_vat_number" id="company_vat_number"  value="<?= isset($settingData)?$settingData[9]['setting_value']:''?>" required>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 mt-2">
                <div class="form-group">
                  <button type="submit" class="btn btn-success float-right">Save Changes</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <?php include __DIR__ . '/../../layout/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../../layout/jsLinks.php'; ?>
</body>

</html>