<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="description" content="<?php echo isset( $page_title ) ? $page_title : ''; ?>">
	<title><?php echo isset( $page_title ) ? $page_title : ''; ?></title>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css">
	<?php echo '<link rel="stylesheet" type="text/css" href="' . base_url( 'assets/css/login.css' ) . '">'; ?>
	<script type="text/javascript">
	var base_url = '<?php echo base_url(); ?>';
	var api_url = '<?php echo base_url( 'api' ); ?>';
	</script>
</head>
<body class="login-page">
<header>
  <a href="#login_form_builder" class="sr-only sr-only-focusable">Skip to main content</a>
</header>
<!-- body-fixed-top start -->
<div id="body-fixed-top">
