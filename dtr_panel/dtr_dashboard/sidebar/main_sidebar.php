<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
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
            <a href="manage_department.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_department.php') ? 'active' : ''; ?>">
              <i class="nav-icon fa fa-building"></i>
              <p>
                Manage Department
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="manage_employee.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_employee.php') ? 'active' : ''; ?>">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Manage Employees
              </p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href="manage_schedule.php" class="nav-link php echo (basename($_SERVER['PHP_SELF']) == 'manage_schedule.php') ? 'active' : ''; ?>">
              <i class="nav-icon fa fa-user-clock"></i>
              <p>
                Manage Schedules
              </p>
            </a>
          </li>  -->
           <li class="nav-item">
            <a href="manage_attendance.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_attendance.php') ? 'active' : ''; ?>">
              <i class="nav-icon fa fa-clock"></i>
              <p>
                Manage Attendance
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="manage_report.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_report.php') ? 'active' : ''; ?>">
              <i class="nav-icon fa fa-print"></i>
              <p>
                Manage Report
              </p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</aside>
