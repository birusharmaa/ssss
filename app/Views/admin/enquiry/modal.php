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
        <div class="modal fade" id="leadModelImport" tabindex="-1" role="dialog" aria-labelledby="leadModelImportLabel" 
          aria-hidden="true ">
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

                  <input name="file_csv" type="file" id="file_csv" /> -->
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