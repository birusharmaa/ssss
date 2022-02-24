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
          <div class="row">
            <div class="col-md-4">
              <ul class="list-group">
                <?php if (!empty($roles)) : ?>
                  <?php foreach ($roles as $role) : ?>
                    <li class="list-group-item show-permission" data-id="<?= $role->id ?>">
                      <div class="row">
                        <div class="col-sm-6"><?= $role->title ?></div>
                        <div class="col-sm-6"><span class="float-right">
                            <i class="fas fa-edit text-info" title="Edit"></i>
                            <i class="fas fa-trash-alt text-danger" title="Delete"></i>
                          </span></div>
                      </div>
                    </li>
                  <?php endforeach; ?>
                <?php else : ?>
                  <li class="list-group-item">
                    <a href="">Not Found</a>
                  </li>
                <?php endif; ?>

              </ul>
            </div>
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  Module Permission
                </div>
                <div class="card-body">
                  <ul class="list-group">
                    <?php if (!empty($modules)) : ?>
                      <?php foreach ($modules as $module) : ?>
                        <li class="list-group-item" data-id="<?= $module->id ?>">
                          <div class="row">
                            <div class="col-sm-6"><?= $module->title ?></div>
                            <div class="col-sm-6">
                              <div class="row">
                                <div class="col-md-6">
                                  <input class="form-check-input flaot-right" type="radio" name="rolepermission<?= $module->id?>" id="trolepermission<?= $module->id?>">
                                  <label class="form-check-label" for="trolepermission<?= $module->id?>">
                                    True
                                  </label>
                                </div>
                                <div class="col-md-6">
                                  <input class="form-check-input" type="radio" name="rolepermission<?= $module->id?>" id="frolepermission<?= $module->id?>">
                                  <label class="form-check-label" for="frolepermission<?= $module->id?>">
                                    False
                                  </label>
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <li class="list-group-item">
                        <a href="">Not Found</a>
                      </li>
                    <?php endif; ?>

                  </ul>
                </div>
              </div>
            </div>
          </div>

        </div>
        <?php include __DIR__ . '/../../layout/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../../layout/jsLinks.php'; ?>
  <script src="<?= base_url(); ?>/public/assets/js/xla-role-permission.js"></script>
</body>

</html>