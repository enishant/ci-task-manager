<div class="container">
	<p>Welcome <?php echo $user->full_name; ?></p>
</div>

<div class="container">
  <div class="row">

	<div class="col-lg-6 col-xs-6 mb-4">
	  <div class="animated zoomIn dashboard-box border border-dark <?php echo isset( $css_scheme ) ? $css_scheme : ''; ?> lighten-5 rounded">
		<div class="inner p-4">
		  <h3 class="<?php echo isset( $css_scheme ) ? $css_scheme : ''; ?>-text">Tasks</h3>
		  <?php if ( $user_role == 'manager' ) { ?>
			<p>Assign task to employee</p>
		  <?php } elseif ( $user_role == 'employee' ) { ?>
			<p>Tasks assigned to you</p>
		  <?php } ?>
		  <a href="<?php echo base_url( 'dashboard/tasks' ); ?>" class="black-text">View Tasks <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	  </div>
	</div>

	<?php if ( $user_role == 'admin' || $user_role == 'manager' ) { ?>
	<div class="col-lg-6 col-xs-6 mb-4">
	  <div class="animated zoomIn dashboard-box border border-dark <?php echo isset( $css_scheme ) ? $css_scheme : ''; ?> lighten-5 rounded">
		<div class="inner p-4">
		  <h3 class="<?php echo isset( $css_scheme ) ? $css_scheme : ''; ?>-text">Users</h3>
		  <?php if ( $user_role == 'manager' ) { ?>
			<p>Add / Edit / Delete user with role employees</p>
		  <?php } ?>
		  <a href="<?php echo base_url( 'dashboard/users' ); ?>" class="black-text">View Users <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	  </div>
	</div>
	<?php } ?>

  </div>
</div>
