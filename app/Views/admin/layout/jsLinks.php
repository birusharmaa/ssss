<?php
$sess = session();
$userInfo = $sess->has('updated_password') ? $sess->get('updated_password') : '';
?>
<script>
    const BaseUrl = '<?= base_url() ?>';
    const email = '<?= $userInfo['email'] ?? '' ?>';
    const passw = '<?= $userInfo['password'] ?? '' ?>';
</script>
<script src="<?= base_url(); ?>/public/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="<?= base_url(); ?>/public/assets/vendors/js/vendor.bundle.addons.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/off-canvas.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/hoverable-collapse.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/misc.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/settings.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/todolist.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/dashboard.js"></script>
<script src="<?= base_url(); ?>/public/assets/js/custom.js"></script>