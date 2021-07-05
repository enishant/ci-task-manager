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
	<?php echo '<link rel="stylesheet" type="text/css" href="' . base_url( 'assets/css/custom.css' ) . '">'; ?>
  <script type="text/javascript">
  var base_url = '<?php echo base_url(); ?>';
  var api_url = '<?php echo base_url( 'api' ); ?>';
  <?php
	$current_url_explode = explode( '/index.php', current_url() );
	if ( isset( $current_url_explode ) && ! empty( $current_url_explode ) && count( $current_url_explode ) == 2 ) {
		$current_url = $current_url_explode[0] . $current_url_explode[1];
		echo 'var current_url = "' . $current_url . '";';
	}
	?>
  </script>
</head>
<body>
<header>
  <nav class="navbar fixed-top navbar-expand-lg <?php echo ( $appearance == 'dark' ) ? 'navbar-light lighten-2' : 'navbar-dark darken-2'; ?> bg-primary scrolling-navbar">
	<div class="container">
	  <a class="navbar-brand" href="<?php echo base_url(); ?>"><strong><?php echo isset( $app_title ) ? $app_title : ''; ?></strong></a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarTop">
		<ul class="navbar-nav ml-auto">
		  <?php
			if ( ! empty( $nav_menu ) ) {
				$nav_link_offset = ( $this->uri->segment( 3 ) ) ? $this->uri->segment( 3 ) : 0;
				if ( $nav_link_offset > 0 ) {
					$new_url = explode( '/' . $nav_link_offset, current_url() );
				}
				foreach ( $nav_menu as $mk => $menu ) {
					if ( $nav_link_offset > 0 && isset( $new_url ) && ! empty( $new_url ) && count( $new_url ) == 2 ) {
						$nav_menu[ $mk ]['is_current_page'] = ( $new_url[0] == $menu['baselink'] );
					} else {
						$nav_menu[ $mk ]['is_current_page'] = ( current_url() == $menu['baselink'] );
					}
					if ( in_array( $user_role, $menu['role'] ) ) {
						?>
				<li class="nav-item <?php echo ( $nav_menu[ $mk ]['is_current_page'] ) ? 'active' : ''; ?>">
				  <a class="nav-link" href="<?php echo $menu['link']; ?>"><?php echo $menu['title']; ?></a>
				</li>
						<?php
					}
				}
			}
			?>
		</ul>
	  </div>
	</div>
  </nav>
</header>
<!-- body-fixed-top start -->
<div id="body-fixed-top">
<div class="container">
  <h1><?php echo isset( $page_title ) ? $page_title : ''; ?></h1>
</div>
