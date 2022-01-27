
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
                        <img src="<?=base_url();?>/assets/images/faces/face12.jpg" alt="profile" class="img-lg rounded-circle mb-3"/>
                        <h3>David Grey. H</h3>
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
                            9898989898
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            E-mail
                          </span>
                          <span class="float-right text-muted">
                            Jacod@testmail.com
                          </span>
                        </p>
                      </div>
                    </div>
                    <div class="col-lg-8 pl-lg-5">
                      <div class="tab-content tab-content-vertical">
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                          <div class="card">
                            <div class="card-body">
                              <h4 class="card-title">General Settings</h4>
                              <form class="forms-sample">
                                <div class="form-group">
                                  <label for="exampleInputName1">Name</label>
                                  <input type="text" class="form-control" id="exampleInputName1" placeholder="Name">
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail3">Email address</label>
                                  <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
                                </div>
                                <div class="form-group">
                                  <label for="exampleSelectGender">Gender</label>
                                    <select class="form-control" id="exampleSelectGender">
                                      <option>Male</option>
                                      <option>Female</option>
                                    </select>
                                  </div>
                                <div class="form-group">
                                  <label for="exampleInputCity1">City</label>
                                  <input type="text" class="form-control" id="exampleInputCity1" placeholder="Location">
                                </div>
                                <div class="form-group">
                                  <label for="exampleTextarea1">Textarea</label>
                                  <textarea class="form-control" id="exampleTextarea1" rows="4"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="profile-pic" role="tabpanel">
                          <div class="card">
                            <div class="card-body">
                              <h4 class="card-title">Edit Profile Picture</h4>
                              <form class="forms-sample" enctype="multipart/form-data">
                                <div class="form-group">
                                  <label>File upload</label>
                                  <input type="file" name="img[]" class="file-upload-default"
                                    accept="image/*">
                                  <div class="input-group col-xs-12">
                                    <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image"
                                    >
                                    <span class="input-group-append">
                                      <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                    </span>
                                  </div>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Change Profile</button>
                              </form>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel">
                          <div class="card">
                            <div class="card-body">
                              <h4 class="card-title">Password Setting</h4>
                              <form class="forms-sample">
                                <div class="form-group">
                                  <label for="oldPass">Old Password</label>
                                  <input type="password" class="form-control" id="oldPass" placeholder="Old Pasword">
                                </div>
                                <div class="form-group">
                                  <label for="newPass">New Password</label>
                                  <input type="password" class="form-control" id="newPass" placeholder="New Pasword">
                                </div>
                                <div class="form-group">
                                  <label for="confPass">Confirm Password</label>
                                  <input type="password" class="form-control" id="confPass" placeholder="Confirm Pasword">
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