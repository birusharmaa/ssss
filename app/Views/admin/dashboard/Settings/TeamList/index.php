<?php
$session = session();
$data = $session->get('loginInfo');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $pageTitle ?></title>
    <?php include __DIR__ . '/../../../layout/cssLinks.php'; ?>
    <script src="<?= base_url(); ?>/assets/js/jquery-3.6.0.min.js"></script>
</head>
<style>
    .error { color: red;}
    .custom_row {
    height: auto; border-bottom: 1px solid gainsboro;
    padding-top: 10px;  min-height: 40px;
  }
</style>
<body class="sidebar-icon-only">
    <div class="container-scroller">
        <?php include __DIR__ . '/../../../layout/navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include __DIR__ . '/../../../layout/sidebar.php'; ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <?= $pageHeading ?>
                        </h3>
                        <nav aria-label="breadcrumb" id="listpage">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Team</li>
                            </ol>
                        </nav>
                        <nav aria-label="breadcrumb" id="addpage" style="display:none;">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item" aria-current="page"><a href="<?php echo base_url('settings/team');?>">Team</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="page-content">
                        <div class="card" id="listCard">
                            <div class="card-header text-right">
                                <button type="button" onclick="addTeam();" class="btn btn-primary">Add</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive border p-2">
                                    <table id="teamDatatables" class="display responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>Sr.No.</th>
                                                <th>Full Name</th>
                                                <th>Email</th>
                                                <th>Office Number</th>                                              
                                                <th>System Name</th>
                                                <th>Account Name</th>
                                                <th>Location</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card" id="addTeamcCard" style="display:none;">
                            <div class="card-header">
                                <h5>Add new user</h5>
                            </div>
                            <div class="card-body">                            
                                <form id="TeamForm" name="TeamForm" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable>Full Name</lable>
                                                <input type="text" class="form-control" name="full_name" id="full_name">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable>Designation</lable>
                                                <input type="text" class="form-control" name="designation" id="designation">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable>Email</lable>
                                                <input type="text" class="form-control" name="personal_email" id="personal_email">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable>Password</lable>
                                                <input type="password" class="form-control" name="password" id="password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable>Office Number</lable>
                                                <input type="text" class="form-control" name="office_number" id="office_number">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable>Personal Number</lable>
                                                <input type="text" class="form-control" name="personal_number" id="personal_number">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable>Gender</lable>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable> Is Admin</lable>
                                                <select class="form-control" name="isAdmin" id="isAdmin">
                                                    <option value="0">No </option>
                                                    <option value="1">Yes </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable> Addrress</lable>
                                                <input type="text" class="form-control" name="address" id="address">
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable> System Name</lable>
                                                <select class="form-control" name="sys_name" id="sys_name">
                                                    <option value="">select</option>
                                                    <?php if ($system) : foreach ($system as $value) : ?>
                                                            <option value="<?= $value['id']; ?>"><?= $value['sys_name']; ?></option>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable>Account Name</lable>
                                                <select name="account_name" id="account_name" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if ($account) : foreach ($account as $value) : ?>
                                                            <option value="<?= $value['id']; ?>"><?= $value['account_name']; ?></option>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable>Location</lable>
                                                <select name="location" id="location" class="form-control">
                                                    <option value="">Select</option>
                                                    <?php if ($location) : foreach ($location as $value) : ?>
                                                            <option value="<?= $value['id']; ?>"><?= $value['location_name']; ?></option>
                                                    <?php endforeach;
                                                    endif; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <lable> Key</lable>
                                                <input type="text" class="form-control" name="key" id="key">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">submit</button>
                                    </div>

                                </form>
                            </div>
                        </div>                                               
                    </div>
                </div>
            </div>
        </div>
        <?php include __DIR__ . '/../../../layout/footer.php'; ?>
    </div>
    <?php include __DIR__ . '/../../../layout/jsLinks.php'; ?>
    <script src="<?= base_url(); ?>/assets/js/jquery.validate.min.js"></script>
    <script src="<?= base_url(); ?>/assets/js/xla-profile.js"></script>
    <script src="<?= base_url(); ?>/assets/js/team.js"></script>
</body>

</html>