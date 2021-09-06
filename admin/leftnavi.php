<aside class="main-sidebar sidebar-<?php echo $utheme?>-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-link">
      <img src="dist/img/logo.png" alt="eLc Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">WorkTracker</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="emp_images/<?php echo $uprofilepic;?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $uadmin_fulln; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
		<!--<li class="nav-header">MY WORK</li>-->
					
			<?php
				if($ses_level=='admin' || $ses_level=='Coordinator'){
			?>
				<li class="nav-item">
					<a href="home.php" class="nav-link">
					  <i class="fas fa-house-user nav-icon"></i>
					  <p>
						Home
					  </p>
					</a>
				</li>
			<?php
			}
			?>
			<?php
			if($ses_level=='Coordinator'){
			?>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-briefcase"></i>
					<p>
						View Work
					<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				
			    <ul class="nav nav-treeview">
				  <li class="nav-item">
					<a href="view-projects" class="nav-link">
					  <i class="nav-icon fas fa-folder-open"></i>
					  <p>Projects</p>
					</a>
				  </li>
				  <li class="nav-item">
					<a href="view-tasks" class="nav-link">
					  <i class="nav-icon fas fa-list"></i>
					  <p>Tasks</p>
					</a>
				  </li>

				  <li class="nav-item">
					<a href="view-sub-tasks" class="nav-link">
					  <i class="nav-icon fas fa-list"></i>
					  <p>Sub Tasks</p>
					</a>
				  </li>
				  <li class="nav-item">
					<a href="leave-management" class="nav-link">
					  <i class="nav-icon fas fa-file-medical"></i>
					  <p>Manage Leave</p>
					</a>
				  </li>
				  <li class="nav-item">
					<a href="manage_attendance.php" class="nav-link">
					  <i class="fas fa-file-signature nav-icon"></i>
					  <p>Manage Attendance</p>
					</a>
				  </li>
				  <li class="nav-item">
					<a href="reports.php" class="nav-link">
					  <i class="nav-icon fas fa-chart-line"></i>
					  <p>
						Reports
					  </p>
					</a>
				  </li>
				</ul>
			</li>
			<?php
			}
			?>
			
			<?php
			if($ses_level=='Coordinator'){
			?>
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Create Operations
						<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="new-subtask-menu.php" class="nav-link">
							  <i class="nav-icon fas fa-list"></i>
							  <p>Create Sub Tasks</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="new-task.php" class="nav-link">
							  <i class="nav-icon fas fa-list"></i>
							  <p>Create Tasks</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="new-project.php" class="nav-link">
							  <i class="nav-icon fas fa-folder-open"></i>
							  <p>Create Projects</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="new-acc.php" class="nav-link">
							  <i class="fas fa-user-plus nav-icon"></i>
							  <p>Create Staff Member</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="viewusers.php" class="nav-link">
							  <i class="fas fa-user-cog nav-icon"></i>
							  <p>
								Manage User Accounts
							  </p>
							</a>
						</li>
					</ul>
				</li>
			<?php
			}
			?>
			<?php	
			if($ses_level=='admin'){
			?>	  
					  
					  
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-tachometer-alt"></i>
						<p>
							Operations
						<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					
					<ul class="nav nav-treeview">
						
						
						<li class="nav-item">
							<a href="new-Coordinator.php" class="nav-link">
							  <i class="nav-icon fas fa-user-tie"></i>
							  <p>Create Coordinator</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="new-acc.php" class="nav-link">
							  <i class="fas fa-user-plus nav-icon"></i>
							  <p>Create Staff Member</p>
							</a>
						</li>
						
						<li class="nav-item">
							<a href="viewusers.php" class="nav-link">
							  <i class="fas fa-user-cog nav-icon"></i>
							  <p>
								Manage User Accounts
							  </p>
							</a>
						</li>
						
					</ul>
				</li>
			<?php
			}
			?>

			<li class="nav-header">MY PROFILE</li>
			
			
			<?php
			if($ses_level=='admin' || $ses_level=='Coordinator'){
			?>  
				
				<li class="nav-item">
					<a href="profile.php" class="nav-link">
					  <i class="nav-icon far fa-user-circle"></i>
					  <p>
						My Profile
					  </p>
					</a>
				</li>
				<li class="nav-item">
					<a href="chat.php" class="nav-link">
						<i class="fas fa-user-cog nav-icon"></i>
						<p>
							Chat
						</p>
					</a>
				</li>
			<?php
			}
			?>

		</ul>
       </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>