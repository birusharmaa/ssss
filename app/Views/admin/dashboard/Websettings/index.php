<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $pageTitle ?></title>
  <?php include __DIR__ . '/../../layout/cssLinks.php'; ?>
</head>

<body class="sidebar-icon-only">
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
            <?php
            // echo '<pre>';

            // print_r($settingData);
            ?>
            <div class="row">
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="">Name</label>
                  <input type="text" class="form-control form-control-sm" name="company_name" value="<?= isset($settingData) ? $settingData[7]['setting_value'] : '' ?>" required>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="">Phone</label>
                  <input type="text" class="form-control form-control-sm" name="company_phone" id="company-phone" value="<?= isset($settingData) ? $settingData[8]['setting_value'] : '' ?>" required>
                </div>
              </div>

              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" class="form-control form-control-sm" name="company_email" id="company-email" value="<?= isset($settingData) ? $settingData[6]['setting_value'] : '' ?>" required>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="company-vat-number">GST Number</label>
                  <input type="text" class="form-control form-control-sm" name="company_gst_number" id="company_gst_number" value="<?= isset($settingData) ? $settingData[9]['setting_value'] : '' ?>" required>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="company-vat-number">Address</label>
                  <textarea class="form-control" name="company_address" id="" cols="" rows="3"><?= isset($settingData) ? $settingData[5]['setting_value'] : '' ?></textarea>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="company-vat-number">Apps Title</label>
                  <input type="text" class="form-control form-control-sm" name="app_title" id="app_title" value="<?= isset($settingData) ? $settingData[3]['setting_value'] : '' ?>" required>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="company-vat-number">Accepted file format</label>
                  <input type="text" class="form-control form-control-sm" name="accepted_file_formats" id="accepted_file_formats" value="<?= isset($settingData) ? $settingData[0]['setting_value'] : '' ?>" required>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="company-vat-number">Date format</label>
                  <input type="text" class="form-control form-control-sm" name="date_format" id="date_format" value="<?= isset($settingData) ? $settingData[14]['setting_value'] : '' ?>" required>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="company-vat-number">Website</label>
                  <input type="text" class="form-control form-control-sm" name="company_website" id="company_website" value="<?= isset($settingData) ? $settingData[10]['setting_value'] : '' ?>" required>
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-group">
                  <label for="company-vat-number">Logo</label>
                  <input type="file" class="form-control form-control-sm" name="logo" id="logo" value="<?= isset($settingData) ? $settingData[76]['setting_value'] : '' ?>">
                  <input type="hidden" name="site_logo" id="site_logo" value="<?= isset($settingData) ? $settingData[76]['setting_value'] : '' ?>">
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <?php if (!empty($settingData[76]['setting_value'])) : ?>
                  <a href="" class="navbar-brand brand-logo">
                    <img src="<?= $settingData[76]['setting_value'] ?>" alt="logo" height="100">
                  </a>
                <?php endif; ?>
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