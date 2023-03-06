<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Sidebar -->
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="employee.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'employee.php') ? 'active' : ''; ?>">
            <i class="nav-icon fa fa-user"></i>
            <p>
              Information
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="attendance.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'attendance.php') ? 'active' : ''; ?>">
            <i class="nav-icon fa fa-clock"></i>
            <p>
              Attendance
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="change_password.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'change_password.php') ? 'active' : ''; ?>">
            <i class="nav-icon fa fa-key"></i>
            <p>
              Change Password
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
