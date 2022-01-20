<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <div class="nav-link">
        <div class="profile-image">
          <img src="<?=base_url();?>/assets/images/faces/face5.jpg" alt="image"/>
        </div>
        <div class="profile-name">
          <p class="name">
            SarTia Global
          </p>
          <p class="designation">
            Super Admin
          </p>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?=base_url();?>/dashboard">
        <i class="fa fa-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#daily-activity" aria-expanded="false" aria-controls="daily-activity">
        <i class="fas fa-briefcase menu-icon"></i>
        <span class="menu-title">Daily Activity</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="daily-activity">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="#">New Leads</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Final Leads</a>
          </li>
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="#">Follow Ups</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Admission</a>
          </li>
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="#">Fee Collection</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#attendance" aria-expanded="false" aria-controls="attendance">
        <i class="fas fa-calendar-day menu-icon"></i>
        <span class="menu-title">Attendance</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="attendance">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item d-none d-lg-block">
            <a class="nav-link" href="#">Trainer's Attendance</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Student's Attendance</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#announcements" aria-expanded="false" aria-controls="announcements">
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
      <a class="nav-link" data-toggle="collapse" href="#learning-management" aria-expanded="false" aria-controls="learning-management">
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
      <a class="nav-link" href="#">
        <i class="fas fa-coins menu-icon"></i>
        <span class="menu-title">Finance</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-money-check-alt menu-icon"></i>
        <span class="menu-title">Transactions</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="fas fa-cog menu-icon"></i>
        <span class="menu-title">Settings</span>
      </a>
    </li>
  </ul>
</nav>