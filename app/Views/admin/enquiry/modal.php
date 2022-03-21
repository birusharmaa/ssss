<div class="modal fade " id="leadModel" tabindex="-1" role="dialog" aria-labelledby="leadModelLabel" aria-hidden="true">
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
                <form class="forms-sample" id="newLeadForm" action="javascript:void(0)" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="sysName">Sys_Name</label>
                                <input type="text" class="form-control " id="sysName" name="sysName" placeholder="System Name" value="">
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="userName">User Name</label>
                                <input type="text" class="form-control" id="leadUserName" name="leadUserName" placeholder="User Name" value="<?php echo $session->get('loginInfo')['full_name'];?>" readonly="readonly" />
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="" />
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="">
                            </div>
                        </div>
                        <div class="col-md-2 p-0">

                            <div class="form-group mb-0">
                                <label for="mob_1">Mobile 1</label>
                                <input type="text" maxlength="10" onkeyup="validatePhone(this, 'mob_1')" class="form-control" id="mob_1" name="mob_1" placeholder="Phone" value="">
                                <span class="text-danger mob_1 d-none">Please enter valid mobile number.</span>
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="mob_2">Mobile 2</label>
                                <input type="text" class="form-control" maxlength="10" onkeyup="validatePhone(this, 'mob_2')" id="mob_2" name="mob_2" placeholder="Phone" value="">
                                <span class="text-danger mob_2 d-none">Please enter valid mobile number.</span>
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="city">City</label>
                                <!-- <input type="text" class="form-control" id="leadCity" name="leadCity" placeholder="city" value="">z -->
                                <select class="form-control" id="leadCity" name="leadCity" placeholder="city">
                                    <option value="">Select City</option>
                                <?php foreach($cities as $city):
                                    ?>
                                    <option value="<?= $city['id'];?>"><?= $city['name'];?></option>
                                <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="location">Location</label>
                                <!-- <input type="text" class="form-control" id="leadLocation" name="leadLocation" placeholder="Location" value=""> -->
                                <select class="form-control" id="leadLocation" name="leadLocation" placeholder="Location" >
                                    <option value="">Select city</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="enqDate">Enquiry Date</label>
                                <input type="date" class="form-control" id="leadEnqDate" name="leadEnqDate" placeholder="Location" value="">
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="FollowUpDate">Follow up date</label>
                                <input type="date" class="form-control" id="FollowUpDate" name="FollowUpDate" placeholder="Location" value="">
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="leadOwner">Lead Owner</label>
                                <select class="form-control" id="leadOwner" name="leadOwner">
                                    <option value="">Select</option>
                                    <?php if (!empty($usersData)) : ?>
                                        <?php foreach ($usersData as $user_data) : ?>
                                            <option value="<?= $user_data['emp_id'] ?>"><?= $user_data['full_name'] ?></option>
                                        <?php endforeach;
                                        else : ?>
                                            <option value="">Not Found</option>
                                        <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="source">Source</label>
                                <select class="form-control" id="source" name="source">
                                    <option value="">Select</option>
                                    <?php if (!empty($sourceModel)) : ?>
                                        <?php foreach ($sourceModel as $source_model) : ?>
                                            <option value="<?= $source_model['id'] ?>"><?= $source_model['title'] ?></option>
                                        <?php endforeach;
                                        else : ?>
                                            <option value="">Not Found</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="enqCourse">Enqury Course</label>
                                <select class="form-control" id="enqCourse" name="enqCourse">
                                    <option value="">Select</option>
                                    <?php if (!empty($courseName)) : ?>
                                        <?php foreach ($courseName as $course_name) : ?>
                                            <option value="<?= $course_name['id'] ?>"><?= $course_name['title'] ?></option>
                                        <?php endforeach;
                                        else : ?>
                                            <option value="">Not Found</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="courseValue">Course value</label>
                                <input type="number" class="form-control" id="courseValue" name="courseValue" placeholder="Course Value">
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <input type="hidden" name="statusValue" value="" id="statusValue" />
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">Select</option>
                                    <?php if (!empty($enqStatus)) : ?>
                                        <?php foreach ($enqStatus as $enq_status) : ?>
                                            <option value="<?= $enq_status['id'] ?>"><?= $enq_status['title'] ?></option>
                                        <?php endforeach;
                                        else : ?>
                                            <option value="">Not Found</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="keyComment">Comment</label>
                                <textarea class="form-control" id="keyComment" name="keyComment" placeholder="Comment" value="" ></textarea>
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="followUpComment">Follow up comment</label>
                                <textarea class="form-control" id="followUpComment" name="followUpComment" placeholder="Comment" value="" ></textarea>
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="FollowUpDays">Follow up days</label>
                                <input type="date" class="form-control" id="FollowUpDays" name="FollowUpDays" placeholder="FollowUpDays" value="">
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <div class="form-group mb-0">
                                <label for="FollouUpCounts">Follow up counts</label>
                                <input type="number" class="form-control" id="FollouUpCounts" name="FollouUpCounts" placeholder="Follow up counts">
                            </div>
                        </div>

                        <div class="col-md-2 p-0">      
                            <div class="form-group mb-0">
                                <label for="FollouUpCounts">Unsubscribe</label><br/>
                                <label class="radio-inline" for="leadSubscribeYes">
                                    <input class="radio-inline" type="radio" name="leadUnsubscribe" id="leadSubscribeYes" value="1" />
                                    <span class="radio-btn-text"> Yes</span>
                                </label>
                                &nbsp&nbsp&nbsp
                                <label class="radio-inline" for="leadSubscribeNo">
                                    <input class="" type="radio" name="leadUnsubscribe" id="leadSubscribeNo" value="0" checked="">
                                    <span class="radio-btn-text">No</span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 p-0 mt-2">
                            <div class="form-group mb-0">
                                <label for="Photo">Photo</label>
                                <input type="file" class="form-control form-control-sm" id="photo" name="photo" onchange="onFileUpload(this);" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-2 p-0">
                            <img class="mb-3 img img-fluid" id="ajaxImgUpload" alt="Preview Image" src="https://via.placeholder.com/100" />
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button class="btn btn-primary" id="submitLead">Save Lead</button> -->
                <button type="submit" class="btn btn-primary">Save Lead</button>
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
                    <input type="hidden" name="username" value="<?php echo $session->get('loginInfo')['full_name'];?>">
                    <div class="row">
                        <div class="col-sm-6">
                            <span class="text-danger"><strong>Only CSV file is allowed. Please check demo file before upload.</strong></span><br>
                            <!-- <div class="custom-file">
                                <input type="file" class="custom-file-input" name="file_csv">
                                <label class="custom-file-label"></label>
                            </div> -->
                            <input name="file_csv" class="form-control" type="file" id="file_csv" accept=".csv" />
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="importCourseVaue">Course</label>
                                <select class="form-control" id="importCourseVaue" name="importCourseVaue">
                                    <option value="">Select</option>
                                    <?php if (!empty($courseName)) : ?>
                                        <?php foreach ($courseName as $course_name) : ?>
                                            <option value="<?= $course_name['id'] ?>"><?= $course_name['title'] ?></option>
                                        <?php endforeach;
                                        else : ?>
                                            <option value="">Not Found</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="col-md-3">
                            <div class="form-group">
                                <label for="subcategory">Sub Category</label>
                                <select class="form-control" id="subcategory1" name="subcategory1">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div> -->
                    </div>
            </div>
            <div class="modal-footer">
                <div class="row" style="margin-right: auto;">
                    Click Here :
                    <a href="<?php echo base_url('file/Lead_demo_file.csv') ?>" download="<?php echo 'lead_demo_' . rand() . '_file.csv'; ?>"> Download Sample File</a>
                </div>
                <button type="button" class="btn" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>