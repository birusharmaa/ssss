<div class="modal fade " id="leadModel" tabindex="-1" role="dialog" aria-labelledby="leadModelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="leadModelLabel">Add Lead</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-2">
                <div id="alertMessage"></div>
                <form class="forms-sample" id="newLeadForm" action="javascript:void(0)" enctype="multipart/form-data" method="post">
                    <div class="row">
                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="sysName">Sys_Name</label>
                                <input type="text" class="form-control bg-color-field p-2 " id="sysName" name="sysName" placeholder="System Name" value="">
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="userName">User Name</label>
                                <input type="text" class="form-control bg-color-field p-2" id="leadUserName" name="leadUserName" placeholder="User Name" value="<?php echo $session->get('loginInfo')['full_name'];?>" readonly="readonly" />
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="name">Name</label>
                                <input type="text" onkeyup="searchData()" onchange="searchData()" class="form-control bg-color-field p-2" id="name" name="name" placeholder="Name" value="" />
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="email">Email address</label>
                                <input type="email" onkeyup="searchData()" onchange="searchData()" class="form-control bg-color-field p-2" id="email" name="email" placeholder="Email" value="">
                            </div>
                        </div>
                        <div class="col-md-2 p-2">

                            <div class="form-group mb-0">
                                <label for="mob_1">Mobile 1</label>
                                <input type="text" onkeyup="searchData()" onchange="searchData()" maxlength="10" onkeyup="validatePhone(this, 'mob_1')" class="form-control bg-color-field p-2" id="mob_1" name="mob_1" placeholder="Phone" value="">
                                <span class="text-danger mob_1 d-none">Please enter valid mobile number.</span>
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="mob_2">Mobile 2</label>
                                <input type="text" onkeyup="searchData()" onchange="searchData()" class="form-control bg-color-field p-2" maxlength="10" onkeyup="validatePhone(this, 'mob_2')" id="mob_2" name="mob_2" placeholder="Phone" value="">
                                <span class="text-danger mob_2 d-none">Please enter valid mobile number.</span>
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="city">City</label>
                                <!-- <input type="text" class="form-control bg-color-field p-2" id="leadCity" name="leadCity" placeholder="city" value="">z -->
                                <select class="form-control bg-color-field p-2" id="leadCity" name="leadCity" placeholder="city">
                                    <option value="">Select City</option>
                                <?php foreach($cities as $city):
                                    ?>
                                    <option value="<?= $city['id'];?>"><?= $city['name'];?></option>
                                <?php endforeach ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="location">Location</label>
                                <!-- <input type="text" class="form-control bg-color-field p-2" id="leadLocation" name="leadLocation" placeholder="Location" value=""> -->
                                <select class="form-control bg-color-field p-2" id="leadLocation" name="leadLocation" placeholder="Location" >
                                    <option value="">Select city</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="enqDate">Enquiry Date</label>
<!--                                 <input type="date" class="form-control bg-color-field p-2" id="leadEnqDate" name="leadEnqDate" placeholder="Location" value="">
 -->                                <input class="form-control date-bg-ht bg-color-field myform-control bg-color-field input-group" id="leadEnqDate" name="leadEnqDate"onchange="fetchData(this,'leadEnqDate')" onkeyup="fetchDatasss(this,'leadEnqDate')" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="FollowUpDate">Follow up date</label>
                                <!-- <input type="date" class="form-control bg-color-field p-2" id="FollowUpDate" name="FollowUpDate" placeholder="Location" value=""> -->
                                <input class="form-control date-bg-ht bg-color-field myform-control bg-color-field input-group" id="FollowUpDate" name="FollowUpDate"onchange="fetchData(this,'FollowUpDate')" onkeyup="fetchDatasss(this,'FollowUpDate')" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="leadOwner">Lead Owner</label>
                                <select class="form-control bg-color-field p-2" id="leadOwner" name="leadOwner">
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

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="source">Source</label>
                                <select class="form-control bg-color-field p-2" id="source" name="source">
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

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="enqCourse">Enquiry Course</label>
                                <select class="form-control bg-color-field p-2" id="enqCourse" name="enqCourse">
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

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="courseValue">Course value</label>
                                <input type="number" class="form-control bg-color-field p-2" id="courseValue" name="courseValue" placeholder="Course Value">
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <input type="hidden" name="statusValue" value="" id="statusValue" />
                                <label for="status">Status</label>
                                <select class="form-control bg-color-field p-2" id="status" name="status">
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
                        
                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="keyComment">Comment</label>
                                <textarea class="form-control bg-color-field p-2" onkeyup="searchData()" onchange="searchData()" id="keyComment" name="keyComment" placeholder="Comment" value="" ></textarea>
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="followUpComment">Follow up comment</label>
                                <textarea class="form-control bg-color-field p-2" onkeyup="searchData()" onchange="searchData()" id="followUpComment" name="followUpComment" placeholder="Comment" value="" ></textarea>
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="FollowUpDays">Follow up days</label>
                                <!-- <input type="date" class="form-control bg-color-field p-2" id="FollowUpDays" name="FollowUpDays" placeholder="FollowUpDays" value="">
                                 -->
                                <input class="form-control date-bg-ht bg-color-field myform-control bg-color-field input-group" id="FollowUpDays" name="FollowUpDays"onchange="fetchData(this,'FollowUpDays')" onkeyup="fetchDatasss(this,'FollowUpDays')" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <div class="form-group mb-0">
                                <label for="FollouUpCounts">Follow up counts</label>
                                <input type="number" class="form-control bg-color-field p-2" id="FollouUpCounts" name="FollouUpCounts" placeholder="Follow up counts">
                            </div>
                        </div>

                        <div class="col-md-2 p-2">      
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

                        <div class="col-md-3 p-2 mt-2">
                            <div class="form-group mb-0">
                                <label for="Photo">Photo</label>
                                <input type="file" class="form-control bg-color-field p-2 form-control bg-color-field p-2-sm" id="photo" name="photo" onchange="onFileUpload(this);" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-2 p-2">
                            <img class="mb-3 img img-fluid" id="ajaxImgUpload" alt="Preview Image" src="https://via.placeholder.com/100" />
                        </div>

                        <div class="col-12">
                            <div class="table-responsive p-0 m-0 border">
                                <table id="leadsTable" class="p-0 m-0" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="border-right">Sr.No.</th>
                                            <th class="border-right">Lead _Id</th>
                                            <th class="border-right">Owner</th>
                                            <th class="border-right">Name</th>
                                            <th class="border-right">Email</th>
                                            <th class="border-right">Mob_1</th>
                                            <th class="border-right">Mob_2</th>
                                            <th class="border-right">Source</th>
                                            <th class="border-right">Days</th>
                                            <th class="border-right">Last Call</th>
                                            <th class="border-right">Next Call</th>
                                            <!-- <th>Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
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
                            <input name="file_csv" class="form-control bg-color-field p-2" type="file" id="file_csv" accept=".csv" />
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="importCourseVaue">Course</label>
                                <select class="form-control bg-color-field p-2" id="importCourseVaue" name="importCourseVaue">
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
                                <select class="form-control bg-color-field p-2" id="subcategory1" name="subcategory1">
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