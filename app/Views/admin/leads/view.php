<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>XLAcademy Admin</title>
  <?php include __DIR__ . '/../layout/cssLinks.php'; ?>
  <script src="<?= base_url(); ?>/public/assets/js/jquery-3.6.0.min.js"></script>
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
              Lead-Views
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Lead</li>
              </ol>
            </nav>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="border-bottom text-center pb-4">
                        <?php if (!empty($lead->Photo)) : ?>
                          <img src="<?= $lead->Photo ?>" alt="profile" class="img-lg rounded-circle mb-3" />
                        <?php else : ?>
                          <img src="<?= base_url(); ?>/public/assets/images/faces/face12.jpg" alt="profile" class="img-lg rounded-circle mb-3" />
                        <?php endif; ?>
                        <h3><?= $lead->Name ?></h3>
                      </div>
                      <div class="py-4">
                        <p class="clearfix">
                          <span class="float-left">
                            Status
                          </span>
                          <span class="float-right text-muted">
                            Active
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Phone
                          </span>
                          <span class="float-right text-muted">
                            <?= $lead->Mob_1 ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            E-mail
                          </span>
                          <span class="float-right text-muted">
                            <?= $lead->Email ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            City
                          </span>
                          <span class="float-right text-muted">
                            <?= $lead->City ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Location
                          </span>
                          <span class="float-right text-muted">
                            <?= $lead->Location ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            System
                          </span>
                          <span class="float-right text-muted">
                            <?= $lead->Sys_Name ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Owner
                          </span>
                          <span class="float-right text-muted">
                            <?= $lead->Lead_Owner ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                          Course
                          </span>
                          <span class="float-right text-muted">
                            <?= $lead->Course_Value ?>
                          </span>
                        </p>
                      </div>
                    </div>
                    <div class="col-lg-8 pl-lg-5">
                      <div class="tab-content tab-content-vertical">
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                          <div class="card">
                            <div class="card-body">
                            <div id="alertMessage"></div>
                              <h4 class="card-title">Upadate lead</h4>
                              <form class="forms-sample" id="update-lead-form">
                                <input type="hidden" id="empid" value="<?= (isset($lead->id) == true) ? $lead->id : '' ?>">
                                <div class="form-group">
                                  <label for="name">Name</label>
                                  <input type="text" class="form-control" id="name" name="Name" placeholder="Name" value="<?= $lead->Name ?>">
                                </div>
                                <div class="form-group">
                                  <label for="email">Email address</label>
                                  <input type="email" class="form-control" id="email" name="Email" placeholder="Email" value="<?= $lead->Email ?>">
                                </div>
                                <div class="form-group">
                                  <label for="email">Phone</label>
                                  <input type="text" class="form-control" id="phone" name="Mob_1" placeholder="Phone" value="<?= $lead->Mob_1 ?>">
                                </div>
                                <div class="form-group">
                                  <label for="category">Category</label>
                                  <select class="form-control" id="category" name="Category">
                                    <option value="">Select</option>
                                    <?php if (!empty($categories)) : ?>
                                      <?php foreach ($categories as $item) : ?>
                                        <option value="<?= $item->id ?>" <?= ($item->id == $lead->Course_Value) ? 'selected' : '' ?>><?= $item->title ?></option>
                                      <?php endforeach;
                                    else : ?>
                                      <option value="">Not Found</option>
                                    <?php endif; ?>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="City">City</label>
                                  <input type="text" class="form-control" id="City" name="City" placeholder="City" value="<?= $lead->City ?>">
                                </div>
                                <div class="form-group">
                                  <label for="Location">Location</label>
                                  <input type="text" class="form-control" id="Location" name="Location" placeholder="Location" value="<?= $lead->Location ?>">
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Update</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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