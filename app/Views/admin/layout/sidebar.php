<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="profile-image">
          <?php if (!empty($sessData['picture_attachment'])) : ?>
            <img src="<?= $sessData['picture_attachment'] ?>" alt="profile" class="img-lg rounded-circle mb-3" />
          <?php else : ?>
            <img src="<?= base_url(); ?>/assets/images/faces/face12.jpg" alt="profile" class="img-lg rounded-circle mb-3" />
          <?php endif; ?>
        </div>
        <div class="profile-name">
          <p class="name">
            <?= $sessData['full_name'] ?>
          </p>
          <p class="designation">
            <?= $sessData['email'] ?>
          </p>
          <p class="designation">
            <?= $sessData['designation'] ?>
          </p>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('admin/dashboard'); ?>" title="Dashboard">
        <i class="fa fa-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#daily-activity" aria-expanded="false" aria-controls="daily-activity">
        <i class="fas fa-briefcase menu-icon"></i>
        <span class="menu-title">Daily Activity</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="daily-activity">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="<?= base_url(); ?>/admin/new-leads">New Leads</a>
          </li>
          
           <li class="nav-item">
            <a class="nav-link" href="<?= base_url()?>/admin/final-leads">Final Leads</a>
          </li>
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="<?= base_url()?>/admin/follow-up">Follow Ups</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url()?>/admin/admission">Admission</a>
          </li>
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="<?= base_url()?>/admin/fee-collection">Fee Collection</a>
          </li>
        </ul>
      </div>
    </li> -->
    <li class="nav-item">
      <a class="nav-link" href="<?= base_url('admin/enquiry'); ?>" title="Enquiry">
        <i class="fas fa-info menu-icon"></i>
        <span class="menu-title">Enquiry</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="<?= base_url('admin/attendance'); ?>" aria-expanded="false" aria-controls="attendance"  title="Attendance">
        <i class="fas fa-calendar-day menu-icon"></i>
        <span class="menu-title">Attendance</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="attendance">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="<?= base_url('admin/attendance'); ?>">Trainer's Attendance</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/attendance/users'); ?>">Student's Attendance</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#announcements" aria-expanded="false" aria-controls="announcements" title="Announcements & Advt.">
        <i class="fas fa-bullhorn menu-icon"></i>
        <span class="menu-title">Announcements & Advt.</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="announcements">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="#">Bulk WhatsApp</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Bulk Email</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Bulk SMS</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#learning-management" aria-expanded="false" aria-controls="learning-management"  title="Learning Management">
        <i class="fas fa-tasks menu-icon"></i>
        <span class="menu-title">Learning Management</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="learning-management">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="#">Contents Upload</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pre-read</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" title="Finance">
        <i class="fas fa-coins menu-icon"></i>
        <span class="menu-title">Finance</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#" title="Transactions">
        <i class="fas fa-money-check-alt menu-icon"></i>
        <span class="menu-title">Transactions</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#web-setting" aria-expanded="false" aria-controls="web-setting" title="Settings">
        <i class="fas fa-cog menu-icon"></i>
        <span class="menu-title">Settings</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="web-setting">
        <ul class="nav flex-column sub-menu">
        <li class="nav-item">
            <a class="nav-link" href="<?= base_url('settings/accounts'); ?>">Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/status'); ?>">Call Status </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/category'); ?>">Category </a>
          </li>
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="<?= base_url('settings/enqstatus'); ?>">Enquire status</a>
          </li>
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="<?= base_url('admin/websettings'); ?>">General Setting </a>
          </li>
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="<?= base_url('settings/location'); ?>">Location</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('settings/subject'); ?>">Subject</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('settings/sysdetails'); ?>">System Details</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('settings/team'); ?>">Team</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= base_url('settings/sources'); ?>">Sources</a>
          </li>
          <!-- <li class="nav-item">
            <a class="nav-link" href="<?= base_url('admin/roles'); ?>">Role & Permission </a>
          </li> -->
         

        </ul>
      </div>
    </li>
  </ul>
</nav>