<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>XLAcademy Forgot Password</title>
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
                            <h4 class="font-weight-bold text-center">Forgot Password</h4>

                            <form class="pt-3" id="forgotForm" >
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-lg" id="email" placeholder="Email" name="email" required>
                                </div>
                                
                                <div class="mt-3">
                                    <button class="btn btn-block btn-brand btn-lg font-weight-medium auth-form-btn mb-2" type="submit" >Forgot Password</button>
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
                email: {
                    required: true,
                    email: true
                },
            },
            messages: {
                email: "Please enter a valid email address",
            },

            submitHandler: function (form) { // for demo
                $('button[type="submit"]').text('Processing..');
                $('button[type="submit"]').attr('disabled',true);
                $.ajax({
                    url: "reset-password",
                    type : 'POST',
                    data : $('#forgotForm').serialize(),
                    beforeSend: function (response) {
                    }, 
                    success: function (data) {
                        $('button[type="submit"]').text('Forgot Password');
                        if(data.status=="success"){
                            $("#email").addClass('valid');
                            $("#email").parent().append('<label id="password-error" class="text-success" for="password">'+data.message+'</label>');
                            $('button[type="submit"]').attr('disabled','disabled');
                        }
                    },
                    error:function(response, data){
                        $('button[type="submit"]').attr('disabled',false);
                        $('button[type="submit"]').text('Forgot Password');
                        if(response.responseJSON.messages.status=="failed"){
                            $("#email").addClass('is-invalid');
                            $("#email").parent().append('<label id="password-error" class="is-invalid" for="password">'+response.responseJSON.messages.message+'</label>');
                        }
                    }
                });
            }    
        });
    </script>
</body>
</html>
