<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $pageTitle ?></title>
  <?php include __DIR__ . '/../../layout/cssLinks.php'; ?>
  <script src="<?= base_url(); ?>/public/assets/js/jquery-3.6.0.min.js"></script>
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
          <!-- <form id="settingForm"> -->
          <div class="row">
            <div class="col-md-6 mt-2">
              <form id="categoryForm">
                <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm" placeholder="Category Name" name="title" id="CatName" required>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success float-right"><i class="fas fa-plus-square"></i></button>
                    </div>
                  </div>
                </div>
              </form>
              <input type="hidden" id="CatNameid">
              <input type="hidden" id="Catfirstid" name="Catfirstid">
              <div class="table-responsive">
                <table class="table" id="allCategory"></table>
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <form id="subcategoryForm">
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-sm" placeholder=" Sub Category Name" id="SubCatName" name="title" required>
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <select class="form-control" name="cat_id" id="selCat"></select>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <button type="submit" class="btn btn-success float-right"><i class="fas fa-plus-square"></i></button>
                    </div>
                  </div>
                </div>
              </form>
              <input type="hidden" name="subCatNameid" id="subCatNameid">
              <div class="table-responsive">
                <table class="table" id="SuballCategory"></table>
              </div>
            </div>
          </div>
          <!-- </form> -->
        </div>
        <?php include __DIR__ . '/../../layout/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../../layout/jsLinks.php'; ?>

  <script>
    $(document).ready(function() {
      $('#allCategory').dataTable();
      $('#SuballCategory').dataTable();
    });
  </script>
</body>

</html>