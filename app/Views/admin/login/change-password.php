<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>XLAcademy Change Password</title>
    <?php include __DIR__ . '/../layout/cssLinks.php'; ?>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row w-100">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo">
                                <img src="<?=base_url();?>/assets/images/logo.png" alt="logo">
                            </div>
                            <h6>"There is no failure. Only Feedback"</h6>
                            <h6 class="text-right">- Robert Alen</h6>
                            <h4 class="font-weight-bold text-center">Change Password</h4>

                            <form class="pt-3" id="forgotForm" >
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="password" placeholder="Password" name="password">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-lg" id="confPassword" placeholder="Retype Password" name="confPassword">
                                </div>
                                
                                <div class="mt-3">
                                    <button class="btn btn-block btn-brand btn-lg font-weight-medium auth-form-btn mb-2" type="submit" >Change Password</button>
                                    <a href="<?=base_url();?>" title="Back For Login">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../layout/jsLinks.php'; ?>
    <script>
        $("#forgotForm").validate({
            errorClass: "is-invalid",
            rules: {
                password: {
                    required: true,
                    minlength: 5,
                },
                confPassword: {
                    required: true,
                    minlength: 5,
                    equalTo : "#password"
                },
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                }
            },

            submitHandler: function (form) { // for demo
                $('button[type="submit"]').text('Processing..');
                $.ajax({
                    url: "change-password",
                    type : 'POST',
                    data : $('#forgotForm').serialize(),
                    beforeSend: function (response) {
                    }, 
                    success: function (data) {
                        $('button[type="submit"]').text('Change Password');
                        if(data.status=="success"){
                            $("#confPassword").addClass('valid');
                            $("#confPassword").parent().append('<label id="password-error" class="text-success" for="password">'+data.message+'</label>');
                            $('button[type="submit"]').attr('disabled','disabled');
                        }else{
                            $("#confPassword").addClass('is-invalid');
                            $("#confPassword").parent().append('<label id="password-error" class="is-invalid" for="password">'+data.message+'</label>');
                        }
                    }
                });
            }    
        });
    </script>
</body>
</html>
