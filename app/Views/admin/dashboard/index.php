
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
                <label>User</label>
                <select name="emp_id" id="emp_id_val" class="form-control">
                  <option>--select--</option>
                  <?php if($user): foreach($user as $val):?>
                  <option value="<?php echo $val['emp_id'];?>"><?php echo $val['full_name']; ?></option>                  
                  <?php endforeach; endif;?>
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
            <?php 
            
            $card= array(
              array(
                'title'=>"Today's Leads",
                'count'=>'10',
              ),
              array(
                'title'=>'Pending Leads',
                'count'=>'85',
              ),
              array(
                'title'=>'Next Week Lead',
                'count'=>'24',
              ),
              array(
                'title'=>'This Month Lead',
                'count'=>'100',
              ),
              array(
                'title'=>'Touched',
                'count'=>'24',
              ),
              array(
                'title'=>'Untouched',
                'count'=>'100',
              ),
              array(
                'title'=>'Business',
                'count'=>'456320',
              ),
              array(
                'title'=>'Revenue',
                'count'=>'<i class="fas fa-rupee-sign"></i> 2,34,778',
              ),
              array(
                'title'=>'Admission',
                'count'=>'9',
              ),
              array(
                'title'=>'Collection',
                'count'=>'21000',
              ),
            );

            foreach($card as $c)
            {?>
            <div class="col-md-3 mt-2">
              <div class="card card-widgit">
                <div class="card-body">
                  <div class="statistics-item">
                    <p>
                      <?php echo $c['title']; ?>
                    </p>
                    <h2>
                      <?php echo $c['count']; ?>
                    </h2>
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

<script>
  $("#emp_id_val").change(function(){
    var id = $('#emp_id_val').val(); 
  alert("The text has been changed. :- "+id);
});
</script>