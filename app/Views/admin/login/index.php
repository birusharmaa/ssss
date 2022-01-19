<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>XLAcademy Admin</title>
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
              <h4 class="font-weight-bold text-center">Sign In to The Future</h4>
              <form class="pt-3" id="loginForm">
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="email" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="password" placeholder="Password" name="password">
                </div>
                <div class="mt-3">
                  <!-- <button class="btn btn-block btn-brand btn-lg font-weight-medium auth-form-btn" type="submit" >Sign In</button> -->
                  <a class="btn btn-block btn-brand btn-lg font-weight-medium auth-form-btn" href="<?=base_url();?>/dashboard">Sign In</a>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
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
    $("#loginForm").validate({
      errorClass: "is-invalid",
      rules: {
        password: {
          required: true,
          minlength: 5
        },
        email: {
          required: true,
          email: true
        },
      },
      messages: {
        password: {
          required: "Please provide a password",
          minlength: "Your password must be at least 5 characters long"
        },
        email: "Please enter a valid email address",
      },      
    });
  </script>
</body>
</html>
