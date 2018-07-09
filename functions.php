<?php
/**
 * Main functions file
 *
 */

 define( 'THEME_VERSION', '1.0' );

// Load all components
foreach (glob(get_template_directory().'/components/*.php') as $file)
    require_once $file;
