<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $pageTitle ?></title>
  <?php include __DIR__ . '/../layout/cssLinks.php'; ?>
  <script src="<?= base_url(); ?>/assets/js/jquery-3.6.0.min.js"></script>
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
              <?= $pageHeading ?>
            </h3>
          </div>
          <div class="page-content">
            <table id="follow-ups-table" class="table table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Contact</th>
                  <th>Course</th>
                  <th>Latest comments</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($followUpsLeads)) :?>
                  <?php foreach ($followUpsLeads as $lead) : ?>
                    <tr>
                      <td><a href="<?= base_url('admin/add_lead/' . $lead['lead_id']) ?>" class="text-info"><?= $lead['Name'] ?></a></td>
                      <td><?= $lead['Email'] ?></td>
                      <td><?= $lead['Mob_1'] ?></td>
                      <td><?= $lead['course_name'] ?></td>
                      <td><?= $lead['comments'] ?></td>
                      <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary next-followup-btn" data-id="<?= $lead['lead_id']?>" data-lead-title="<?= $lead['Name']?>">
                          Follow ups
                        </button>

                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>

              </tbody>

            </table>
          </div>
        </div>
        <?php include __DIR__ . '/../layout/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include __DIR__ . '/../layout/jsLinks.php'; ?>

  <script>
    $(document).ready(function() {
      $('#follow-ups-table').DataTable();
    });
  </script>

  <script src="<?= base_url(); ?>/assets/js/xla-followups.js"></script>
  <!-- Modal -->
  <div class="modal fade" id="followupsModal" tabindex="-1" role="dialog" aria-labelledby="followupsModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="followupsModalLongTitle">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="followps-lead-forms">
            <input type="hidden" name="lead_id" id="lead_id">
            <div class="row mt-2" id="calltype">
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
                    <?php if ($callStatus):
                      foreach($callStatus as $value): ?>
                        <option value="<?= $value->id; ?>"><?= $value->title; ?></option>
                      <?php endforeach;
                    endif;?> 
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

</body>

</html>