<?php
/**
 * Theme header
 */
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="lt-ie9 lt-ie8 lt-ie7" <?php language_attributes() ?>><![endif]-->
<!--[if IE 7]><html class="lt-ie9 lt-ie8" <?php language_attributes() ?>><![endif]-->
<!--[if IE 8]><html class="lt-ie9" <?php language_attributes() ?>><![endif]-->
<!--[if gt IE 8]><!--><html class="" <?php language_attributes() ?>><!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo( 'charset' ) ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php wp_title( '|', true, 'right' ) ?></title>

    		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png" />

		<?php wp_head() ?>
    </head>
    <body <?php body_class() ?>>
		<header id="page-header" class="header">
      <div class="container">
        <div class="desktop-menu">
    			<div class="site-logo">
            <a href="<?php bloginfo('url') ?>">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/main-logo.png" alt="<?php bloginfo('name') ?> - <?php bloginfo('description') ?>">
            </a>
    			</div>
          <div class="menu-container clr">
            <?php wp_nav_menu(array(
              'theme_location' => 'main-nav',
              'container'      => 'nav',
              'container_id'   => 'primary-nav',
              'walker'         => new Primary_Walker_Nav_Menu()
            )) ?>
          </div>
        </div>
        <div class="mobile-menu">
          <div class="site-logo">
            <a href="<?php bloginfo('url') ?>">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/main-logo.png" alt="<?php bloginfo('name') ?> - <?php bloginfo('description') ?>">
            </a>
    			</div>

          <div class="toggle-menu">
            <div id="nav-icon">
              <span></span>
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>
      </div>

      <div class="mobile-menu-container">
        <div class="mobile-menu-inner">
          <div class="menu-container">
            <?php wp_nav_menu(array(
              'theme_location' => 'main-nav',
              'container'      => 'nav',
              'container_id'   => 'primary-nav',
              'walker'         => new Primary_Walker_Nav_Menu()
            )) ?>
          </div>
        </div>
      </div>
		</header>

    <?php if (!is_front_page()) { ?>
  	<div id="tablesite-content">
  		<div id="main-content">
  			<div class="dtc">
  	<?php } ?>
