<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $pageTitle ?></title>
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
              <?= $pageHeading  ?>            
            </h3>
          </div>    
          <form id="statusForm">  
          <div class="row">
              <div class="col-md-4">
               <input type ="hidden" name="created_by" value="<?= $empid; ?>">
                  <div class="form-group"> 
                     <lable> Title</lable>                    
                        <input type="text" class="form-control form-control-sm" name="title" id="title"  required>
                    </div> 
               </div>
               <div class="col-md-7">                
                  <div class="form-group"> 
                    <lable>Description</lable>                    
                       <textarea class="form-control" rows="1" cols="50" name="description" id="description"></textarea>
                  </div>
              </div>
              <div class="col-md-1">
                  <button type="submit" style="margin-top: 20px;" class="btn btn-primary">Submit</button>
            </div>               
          </div>
          </form>  
              <input type="hidden" id="statusid">   
            <div class="row">            
              <div class="col-md-12 mt-2">        
            
                <div class="table-responsive">
                    <table class="table" id="allstatus">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Title</th>
                          <th scope="col">Description</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                    </table>
                  </div>                
                </div>
              </div>           
         
        </div>
        <?php include __DIR__ . '/../../layout/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../../layout/jsLinks.php'; ?>
  <script src="<?= base_url(); ?>/assets/js/call-status.js"></script>
</body>

</html>