<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $pageTitle ?></title>
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
              <?= $pageHeading?>
              <div id="alertRes"></div>
            </h3>
          </div>
          <div class="content">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="pills-leads-tab" data-toggle="pill" href="#pills-leads" role="tab" aria-controls="pills-leads" aria-selected="true">Leads</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-assignedList-tab" data-toggle="pill" href="#pills-assignedList" role="tab" aria-controls="pills-assignedList" aria-selected="false">All Assigned Lead</a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="pills-unsubslead-tab" data-toggle="pill" href="#pills-unsubslead" role="tab" aria-controls="pills-unsubslead" aria-selected="false">Unsubscribe Leads</a>
              </li>

            </ul>
            <div class="tab-content pt-0" id="pills-tabContent">
              <div class="tab-pane fade show active" id="pills-leads" role="tabpanel" aria-labelledby="pills-leads-tab">

                <form method="POST" id="leadFilterForm">
                  <div class="row">
                    <div class="col-md-2 mt-2">
                      <div class="form-group">
                        <label for="lead-category">Category</label>
                        <select name="lead-category" id="lead-category" class="form-control" required>
                          <option value=""><?= "Select" ?></option>
                          <?php if (!empty($categories)) :
                            foreach ($categories as $item) : ?>
                              <option value="<?= $item->id ?>"><?= $item->title ?></option>
                            <?php endforeach; ?>
                          <?php else : ?>
                            <option value="">No User found</option>
                          <?php endif; ?>

                        </select>
                      </div>
                    </div>
                    <div class="col-md-2 mt-2">
                      <div class="form-group">
                        <label for="sub-category">Sub Category</label>
                        <select name="sub-category" id="sub-category" class="form-control">

                        </select>
                      </div>
                    </div>
                    <div class="col-md-2 mt-2">
                      <div class="form-group">
                        <label for="city">City</label>
                        <select name="city" id="city" class="form-control">
                          <option value=""><?= "Select" ?></option>
                          <?php if (!empty($cities)) :
                            foreach ($cities as $item) : ?>
                              <option value="<?= $item->City ?>"><?= $item->City ?></option>
                            <?php endforeach; ?>
                          <?php else : ?>
                            <option value="">No User found</option>
                          <?php endif; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2 mt-2">
                      <div class="form-group">
                        <label for="">From</label>
                        <input type="date" class="form-control form-control-sm" id="from-lead-date">
                      </div>
                    </div>
                    <div class="col-md-2 mt-2">
                      <div class="form-group">
                        <label for="">To</label>
                        <input type="date" class="form-control form-control-sm" id="to-lead-date">
                      </div>
                    </div>
                    <div class="col-md-2 mt-2">
                      <div class="form-group">
                        <button class="btn btn-primary mt-4" id="search-lead">search</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="grid-margin row m-0" id="widget-container">
                  <div class="col-md-4">
                    <div class="col-md-6" id="leadViewContainer">
                    </div>
                  </div>
                  <div class="col-md-1">
                    <div id="assignContainer"></div>
                  </div>
                  <div class="col-md-6">
                    <div id="assignFormContainer">
                      <form id="leadCommentUpdateForm">
                        <input type="hidden" name="lead_id" id="lead_id">
                        <div class="row mt-2 d-none" id="calltype">
                          <div class="col-sm-4">Call Type</div>
                          <div class="col-sm-8">
                            <select id="calltypesel" class="form-control" required="" name="call_type">
                              <option value="">select</option>
                              <option value="1">Incoming</option>
                              <option value="2">Outgoing </option>
                            </select>
                          </div>
                        </div>
                        <div class="row mt-2 d-none" id="callstatus">
                          <div class="col-sm-4">Call Status</div>
                          <div class="col-sm-8">
                            <select id="callstatussel" class="form-control" name="call_status" required="">
                              <option value="">select</option>
                              <option value="1">Didn't Answer</option>
                              <option value="2">Unreachable</option>
                              <option value="3">Switched off</option>
                              <option value="4">Not Intrested</option>
                              <option value="5">Already Taken</option>
                              <option value="6">Connected</option>
                              <option value="7">Follow Up</option>
                              <option value="8">Intrested</option>
                              <option value="9">Details Shared</option>
                            </select>
                          </div>
                        </div>
                        <div class="row mt-2 d-none" id="subject_div">
                          <div class="col-sm-4">Subject</div>
                          <div class="col-sm-8">
                            <input type="text" class="form-control" name="subject">
                          </div>
                        </div>
                        <div class="row mt-2 d-none" id="comments_div">
                          <div class="col-sm-4">Comments</div>
                          <div class="col-sm-8">
                            <textarea id="comments" class="form-control" cols="30" name="comments"></textarea>
                          </div>
                        </div>
                        <div class="row mt-2 d-none" id="followup_div">
                          <div class="col-sm-4">Follow Up</div>
                          <div class="col-sm-4">
                            <input type="date" class="form-control" name="followup_date">
                          </div>
                          <div class="col-sm-4">
                            <input type="time" class="form-control" name="followup_time">
                          </div>
                        </div>
                        <div class="row mt-2 d-none" id="submit_btn">
                          <div class="col-sm-12">
                            <input type="submit" class="btn btn-success float-right" value="Save" />
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade " id="pills-assignedList" role="tabpanel" aria-labelledby="pills-assignedList-tab">
                <div id="alertRes"></div>
                <div class="table-responsive">
                  <table id="assign-leads-table" class="table" style="width:100%">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Course</th>
                        <!-- <th>Form Status</th> -->
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($assignedLeads)) :
                      ?>
                        <?php foreach ($assignedLeads as $lead) : ?>
                          <tr>
                            <td><a href="<?= base_url('admin/add_lead/' . $lead->id) ?>" class="text-info"><?= $lead->Name ?></a></td>
                            <td><?= $lead->Email ?></td>
                            <td><?= $lead->Mob_1 ?></td>
                            <td><?= $lead->Course_Value ?></td>
                            <td>
                              <button class="btn btn-outline-primary"> <a href="#" class="unsubscribe-leads" data-id="<?= $lead->id ?>" status="<?= ($lead->Unsubscribe == 0) ? 1 : 0; ?>"><i class="fas fa-strikethrough"></i>Unsubscribe</a> </button>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                     
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-unsubslead" role="tabpanel" aria-labelledby="pills-unsubslead-tab">
                <div class="table-responsive">
                  <table id="unsublead-leads-table" class="table" style="width:100%">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Course</th>
                        <!-- <th>Form Status</th> -->
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (!empty($unsubleads)) :
                      ?>
                        <?php foreach ($unsubleads as $lead) : ?>
                          <tr>
                            <td><?= $lead->Name ?></td>
                            <td><?= $lead->Email ?></td>
                            <td><?= $lead->Mob_1 ?></td>
                            <td><?= $lead->Course_Value ?></td>
                            <td>
                              <!-- <button class="btn btn-outline-primary"><i class="fa fa-rocket" aria-hidden="true"></i></button> -->
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
        <?php include __DIR__ . '/../layout/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../layout/jsLinks.php'; ?>
  <script src="<?= base_url(); ?>/public/assets/js/xla-final-leads.js"></script>
  <script>
    $(document).ready(function() {
      $('#assign-leads-table').DataTable();
      $('#unsublead-leads-table').DataTable();
    });
  </script>
</body>


</html>