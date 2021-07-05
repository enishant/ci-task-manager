<div class="mb-2" id="login_response"></div>
<form class="animated zoomIn border rounded border-light p-2 pt-4 login_form">
  <div class="text-center <?php echo $css_scheme; ?>-text font-weight-bold"><?php echo $app_title; ?></div>
	<div class="mt-2 login_forms" id="login_form_builder">
		<div class="form-outline mb-4">
		  <input type="text" id="username" class="form-control form-control-lg" />
		  <label class="form-label" for="username">Username</label>
		</div>
		<div class="form-outline mb-4">
		  <input type="password" id="password" class="form-control form-control-lg" />
		  <label class="form-label" for="password">Password</label>
		</div>
	  <div class="text-center mb-4">
			<button class="btn btn-outline-<?php echo $css_scheme; ?> waves-effect waves-light" id="login_button" type="button">Login<i class="fa fa-paper-plane ml-2"></i></button>
	  </div>
	</div>
</form>
