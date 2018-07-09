<?php
/**
 * Menus
 *
 */

function register_menus() {
	register_nav_menus(
		array(
			'main-nav' => 'Main Navigation',
			'secondary-nav' => 'Secondary Navigation'
		)
	);
}
add_action( 'init', 'register_menus' );


/* Menu walker */

class Primary_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if ( array_search( 'menu-item-has-children', $item->classes ) ) {
            $output .= sprintf( "\n<li class='has-submenu %s'><a href='%s'>%s <i class='fas fa-caret-down'></i></a>\n", ( array_search( 'current-menu-item', $item->classes ) || array_search( 'current-page-parent', $item->classes ) ) ? 'active' : '', $item->url, $item->title );
        } else {
            $output .= sprintf( "\n<li %s><a href='%s'>%s</a>\n", ( array_search( 'current-menu-item', $item->classes) ) ? ' class="active"' : '', $item->url, $item->title );
        }
    }

    function start_lvl( &$output, $depth ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n$indent<ul class=\"submenu\" role=\"menu\">\n";
    }
}
