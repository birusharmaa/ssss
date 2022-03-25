
    <div class="body-header border-0 rounded-0 px-xl-4 px-md-2">
        <div class="container-fluid">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center py-2">
                        <ol class="breadcrumb rounded-0 mb-0 ps-0 bg-transparent flex-grow-1">
                            <li class="breadcrumb-item"><a href="<?=base_url();?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Trainers Attandance</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="body mb-2 px-xl-4 px-md-2">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">

                        <div class="card overflow-scroll p-4">
                            <table id="attandance" class="table display dataTable table-hover"
                                style="width:100%">
                                <div class="co1-2 offset-10 mb-2 text-right float-right">
                                    <input class="form-control" data-date-format="mm/yyyy" id="datepicker">
                                </div>
                                <thead>
                                    <tr class="py-3 table-info">
                                        <th>#ID</th>
                                        <th>Name</th>
                                        <th>1 Mon</th>
                                        <th>2 Tues</th>
                                        <th>3 wed</th>
                                        <th>4 thurs</th>
                                        <th>5 fri</th>
                                        <th>6 sat</th>
                                        <th>7 sun</th>
                                        <th>8 Mon</th>
                                        <th>9 Tues</th>
                                        <th>10 wed</th>
                                        <th>11 thurs</th>
                                        <th>12 fri</th>
                                        <th>13 sat</th>
                                        <th>14 sun</th>
                                        <th>15 Mon</th>
                                        <th>16 Tues</th>
                                        <th>17 wed</th>
                                        <th>18 thurs</th>
                                        <th>19 fri</th>
                                        <th>20 sat</th>
                                        <th>21 sun</th>
                                        <th>22 Mon</th>
                                        <th>23 Tues</th>
                                        <th>24 wed</th>
                                        <th>25 thurs</th>
                                        <th>26 fri</th>
                                        <th>27 sat</th>
                                        <th>28 sun</th>
                                        <th>29 Mon</th>
                                        <th>30 tues</th>
                                        <th>31 wed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="table-info sorting_1 id-red fw-bold">01</td>
                                        <td class="table-info">Name 1</td>
                                        <td class="table-success">P</td>
                                        <td class="table-success">P</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-success">P</td>
                                        <td class="table-success">P</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-info">H</td>
                                        <td class="table-success">P</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-success">P</td>
                                        <td class="table-success">P</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-success">P</td>
                                        <td class="table-info">H</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-success">P</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-success">P</td>
                                        <td class="table-success">P</td>
                                        <td class="table-info">H</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-success">P</td>
                                        <td class="table-success">P</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-success">P</td>
                                        <td class="table-success">P</td>
                                        <td class="table-info">H</td>
                                        <td class="table-danger">A</td>
                                        <td class="table-success">P</td>
                                        <td class="table-danger">A</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div> <!-- .card end -->
                    </div>
                </div>
            </div>
        </div>
    </div>  

<?php echo view('admin/layout/footer-section');?>
<script src="<?php echo base_url('assets/js/pages/trainers.js'); ?>"></script>

