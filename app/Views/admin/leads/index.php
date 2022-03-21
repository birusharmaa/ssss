<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $pageTitle ?></title>
  <?php include __DIR__ . '/../layout/cssLinks.php'; ?>
  <script src="<?= base_url(); ?>/assets/js/jquery-3.6.0.min.js"></script>
  <script src="<?= base_url(); ?>/assets/css/dropzone.css"></script>
</head>

<body class="sidebar-icon-only">
  <div class="container-scroller">
    <?php include __DIR__ . '/../layout/navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include __DIR__ . '/../layout/sidebar.php'; ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
             <?= $pageHeading?>
            </h3>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Leads</a></li>
                <li class="breadcrumb-item active" aria-current="page">leads</li>
              </ol>
            </nav>
          </div>
          <div id="alertMessageview"></div>
          <div class="card">
            <div class="card-body">

              <div class="row card-title">
                <div class="col-sm-12">
                  <button type="button" class="btn btn-primary float-right m-2" data-toggle="modal" data-target="#leadModel">
                    Add
                  </button>
                  <button type="button" class="btn btn-primary float-right m-2" data-toggle="modal" data-target="#leadModelImport">
                    Import
                  </button>
                  <!-- Button trigger modal -->

                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="leads-table" class="table">
                      <thead>
                        <tr>
                          <th>Sr.No.</th>
                          <th>Lead Name</th>
                          <th>Email</th>
                          <th>Contact No.</th>
                          <th>City</th>
                          <th>Course</th>
                          <!-- <th>Status</th> -->
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($leads)) :
                          $i = 1;
                        ?>
                          <?php foreach ($leads as $lead) : 
                         
                            ?>
                            <tr>
                              <td><?= $i++ ?></td>
                              <td><a href="<?= base_url('admin/add_lead/' . $lead->id) ?>" class="text-info"><?= $lead->Name ?><?= $lead->Name ?></a></td>
                              <td><?= $lead->Email ?></td>
                              <td><?= $lead->Mob_1 ?></td>
                              <td><?= $lead->City ?></td>
                              <td><?= $lead->course ?></td>
                              <!-- <td>
                                <label class="badge badge-info">On hold</label>
                              </td> -->
                              <td>
                                <button class="btn btn-outline-primary"> <a href="<?= base_url('admin/add_lead/' . $lead->id) ?>">View</a> </button>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                       
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include __DIR__ . '/../layout/jsLinks.php'; ?>


    <!-- Modal -->
    <div class="modal fade" id="leadModel" tabindex="-1" role="dialog" aria-labelledby="leadModelLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="leadModelLabel">Add Lead</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="alertMessage"></div>
            <form class="forms-sample" id="new-lead-form">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control " id="name" name="Name" placeholder="Name" value="" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="Email" placeholder="Email" value="" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="email">Phone</label>
                    <input type="text" class="form-control" id="phone" name="Mob_1" placeholder="Phone" value="" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category" name="Enq_Course" required>
                      <option value="">Select</option>
                      <?php if (!empty($categories)) : ?>
                        <?php foreach ($categories as $item) : ?>
                          <option value="<?= $item->id ?>"><?= $item->title ?></option>
                        <?php endforeach;
                      else : ?>
                        <option value="">Not Found</option>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="subcategory">Sub Category</label>
                    <select class="form-control" id="subcategory" name="SubCategory">
                      <option value="">Select</option>

                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="City">City</label>
                    <input type="text" class="form-control" id="City" name="City" placeholder="City" value="">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="Location">Location</label>
                    <input type="text" class="form-control" id="Location" name="Location" placeholder="Location" value="">
                  </div>
                </div>
                <div class="col-md-3 mt-2">
                  <div class="form-group">
                    <label for="Enq_Dt">Enquiry Date</label>
                    <input type="date" class="form-control form-control-sm" id="Enq_Dt" name="Enq_Dt">
                  </div>
                </div>
                <div class="col-md-3 mt-2">
                  <div class="form-group">
                    <label for="">Follow Up Date</label>
                    <input type="date" class="form-control form-control-sm" id="followUpDate" name="Follow_Up_Dt">
                  </div>
                </div>
                <div class="col-md-3 mt-2">
                  <div class="form-group">
                    <label for="Photo">Avatar</label>
                    <input type="file" class="form-control form-control-sm" id="photo" name="Photo" accept="image/*">
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="leadModelImport" tabindex="-1" role="dialog" aria-labelledby="leadModelImportLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
          <div class="modal-header">
            <h5 class="modal-title" id="leadModelImportLabel">Import Lead</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <div id="alertMessage"></div>
          </div>
          <div class="modal-body">

            <form class="forms-sample" id="import_form">
              <input type="hidden" name="username" value="<?= $username ?>">
              <div class="row">
                <div class="col-sm-6">
                  <span class="text-danger"><strong>Only CSV file is allowed. Please check demo file before upload.</strong></span><br>
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="file_csv" required>
                    <label class="custom-file-label"></label>
                  </div>
                </div>
              </div>

              <!-- <input name="file_csv" type="file" id="file_csv" /> -->
              <div class="row mt-3">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" id="category1" name="category1" required onchange="subcate(this.value)">
                      <option value="">Select</option>
                      <?php if (!empty($categories)) : ?>
                        <?php foreach ($categories as $item) : ?>
                          <option value="<?= $item->id ?>"><?= $item->title ?></option>
                        <?php endforeach;
                      else : ?>
                        <option value="">Not Found</option>
                      <?php endif; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="subcategory">Sub Category</label>
                    <select class="form-control" id="subcategory1" name="subcategory1">
                      <option value="">Select</option>
                    </select>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <div class="row" style="margin-right: auto;">
              Click Here :
              <a href="<?php echo base_url('public/file/lead_demo_file.csv') ?>" download="<?php echo 'lead_demo_' . rand() . '_file.csv'; ?>"> Download Sample File</a>
            </div>
            <button type="button" class="btn" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Upload</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="<?= base_url(); ?>/assets/js/xla-update-lead.js"></script>
  <script src="<?= base_url(); ?>/assets/js/dropzone.js"></script>
  <script>
    $(document).ready(function() {
      $('#leads-table').DataTable();
    });
  </script>
</body>

</html>

<script>
  function subcate(id) {
    var html = '';
    var urli = '<?php echo base_url() ?>/admin/subcategory/' + id;
    $.ajax({
      url: urli,
      type: "get",
      success: function(data) {
          console.log(data);
        if (data.data.length > 0) {
          html += "<option>select</option>";
          data.data.forEach((c) => {
            html += `<option value="${c.id}"> ${c.title} </option>`;
          });
        } else {
          html = '<option>select</option>';
        }
        $('#subcategory1').html(html);
      }
    });
  }
</script>