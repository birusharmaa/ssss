<?php $session = session();
$data = $session->get('loginInfo');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>XLAcademy Admin</title>
  <?php include __DIR__ . '/../../layout/cssLinks.php'; ?>
  <script src="<?= base_url(); ?>/assets/js/jquery-3.6.0.min.js"></script>
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
              Profile
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
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

                        <?php if (!empty($user['picture_attachment'])) : ?>
                          <img src="<?= $user['picture_attachment'] ?>" alt="profile" class="img-lg rounded-circle mb-3" />
                        <?php else : ?>
                          <img src="<?= base_url(); ?>/assets/images/faces/face12.jpg" alt="profile" class="img-lg rounded-circle mb-3" />
                        <?php endif; ?>
                        <h3><?= $user['full_name'] ?? '' ?></h3>
                      </div>

                      <input type="hidden" value="<?= $data['emp_id'] ?>" id="employee_id">
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
                            <?= $user['personal_number'] ?? '' ?>
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            E-mail
                          </span>
                          <span class="float-right text-muted">
                            <?= $user['personal_email'] ?? '' ?>
                          </span>
                        </p>
                      </div>
                      <div class="py-4">

                        <ul class="nav nav-tabs nav-tabs-vertical" role="tablist">
                          <li class="nav-item ">
                            <a class="show align-items-center d-flex nav-link justify-content-between" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="false">
                              General Settings
                              <i class="fas fa-cog text-info ml-2"></i>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="align-items-center d-flex nav-link justify-content-between" data-toggle="tab" href="#profile-pic" role="tab" aria-controls="profile-pic" aria-selected="false">
                              Profile Picture
                              <i class="fas fa-user text-info ml-2"></i>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a class="align-items-center d-flex nav-link justify-content-between" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">
                              Password
                              <i class="fas fa-lock text-info ml-2"></i>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-lg-8 pl-lg-5">
                      <div id="alertMessage"></div>
                      <div class="tab-content tab-content-vertical">
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                          <div class="card">
                            <div class="card-body">
                              <h4 class="card-title">General Settings</h4>
                              <form class="forms-sample" id="general-setting-form">
                                <div class="form-group">
                                  <label for="full_name">Name</label>
                                  <input type="text" class="form-control" id="full_name" name="full_name" value="<?= $user['full_name'] ?? '' ?>" placeholder="Name">
                                </div>
                                <div class="form-group">
                                  <label for="personal_email">Email address</label>
                                  <input type="email" class="form-control" id="personal_email" name="personal_email" placeholder="Email" value="<?= $user['personal_email'] ?? '' ?>">
                                </div>
                                <div class="form-group">
                                  <label for="personal_number">Personal number</label>
                                  <input type="text" class="form-control" id="personal_number" name="personal_number" placeholder="Personal number" value="<?= $user['personal_number'] ?? '' ?>">
                                </div>
                                <div class="form-group">
                                  <label for="office_number">Office number</label>
                                  <input type="text" class="form-control" id="office_number" name="office_number" placeholder="Office number" value="<?= $user['office_number'] ?? '' ?>">
                                </div>
                                <div class="form-group">
                                  <label for="exampleSelectGender">Gender</label>
                                  <select class="form-control" id="gender" name="gender">
                                    <option value="">Select</option>
                                    <option <?= ($user['gender'] == 'm') ? 'selected' : '' ?> value="m">Male</option>
                                    <option <?= ($user['gender'] == 'f') ? 'selected' : '' ?> value="f">Female</option>
                                    <option <?= ($user['gender'] == 'o') ? 'selected' : '' ?> value="f">Other</option>
                                  </select>
                                </div>
                                <div class="form-group">
                                  <label for="location">City</label>
                                  <input type="text" class="form-control" id="location" name="location" value="<?= $user['location'] ?? '' ?>" placeholder="Location">
                                </div>
                                <div class="form-group">
                                  <label for="address">Address</label>
                                  <textarea class="form-control" id="address" name="address" rows="4"><?= $user['address'] ?? '' ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                              
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="profile-pic" role="tabpanel">
                          <div class="card">
                            <div class="card-body">
                              <h4 class="card-title">Edit Profile Picture</h4>
                              <form class="forms-sample" enctype="multipart/form-data" id="update-image-form">
                                <div class="form-group">
                                  <label>File upload</label>
                                  <div class="input-group col-xs-12">
                                    <input type="file" name="img" class="form-control file-upload-info" accept="image/*" placeholder="Upload Image">
                                    <span class="input-group-append">
                                      <button class="file-upload-browse btn btn-primary" id="uploadImage" type="button">Upload</button>
                                    </span>
                                  </div>
                                </div>
                                <?php if (!empty($user['picture_attachment'])) : ?>
                                  <button type="button" class="btn btn-primary mr-2" id="remove-pic" data-empid="<?= $user['emp_id'] ?>">Remove Profile Picture</button>
                                <?php endif; ?>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel">
                          <div class="card">
                            <div class="card-body">
                              <h4 class="card-title">Password Setting</h4>
                              <form class="forms-sample" id="update-password-form">
                                <div class="form-group">
                                  <label for="oldPass">Old Password</label>
                                  <input type="password" class="form-control" name="oldPass" id="oldPass" placeholder="Old Pasword">
                                </div>
                                <div class="form-group">
                                  <label for="newPass">New Password</label>
                                  <input type="password" class="form-control" name="newPass" id="newPass" placeholder="New Pasword">
                                </div>
                                <div class="form-group">
                                  <label for="confPass">Confirm Password</label>
                                  <input type="password" class="form-control" name="confPass" id="confPass" placeholder="Confirm Pasword">
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Change Password</button>
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
        <?php include __DIR__ . '/../../layout/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../../layout/jsLinks.php'; ?>
  <script src="<?= base_url(); ?>/assets/js/xla-profile.js"></script>

  <script>
    $(document).ready(function() {
      $('#leads-table').DataTable();
    });
  </script>
</body>

</html>