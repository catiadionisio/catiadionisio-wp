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
	function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
		$title = $item->title;
		$permalink = $item->url;
		$classes = $item->classes;
		$target = $item->target;
		$attr_title = $item->attr_title;
		$slug = sanitize_title($title);

		$classes = preg_replace( '/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', 'active', $classes );
		$classes = preg_replace( '/^((menu|page)[-_\w+]+)+/', '', $classes );

		$classes[] = 'menu-' . $slug;

		$classes = array_unique( $classes );

    	$output .= '<li class="' . implode(' ', $classes) . '">';

    	//Add SPAN if no Permalink
		if( $permalink && $permalink != '#' ) {
			$target_str = $attr_title_str = '';

			if ($target) {
				$target_str = ' target="' . $target . '"';
			}
			if ($attr_title) {
				$attr_title_str = ' title="' . $attr_title . '"';
			}

			$output .= '<a href="' . $permalink . '"'. $target_str . $attr_title_str .'>';
		} else {
			$output .= '<span>';
		}

		$output .= $title;

		if( $permalink && $permalink != '#' ) {
			$output .= '</a>';
		} else {
			$output .= '</span>';
		}
	}

	function start_lvl( &$output, $depth = 0, $args = array()) {
			$indent = str_repeat( "\t", $depth );
			$output .= "\n$indent<ul class=\"submenu\" role=\"menu\">\n";
	}

	function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {

		$id_field = $this->db_fields['id'];

		if ( !empty( $children_elements[$element->$id_field] ) && ( $depth >= 0 ) ) {
			$element->title .= ' <span class="arrow-down"></span>';
		}

		Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);

	}

	function end_el(&$output, $item, $depth=0, $args=array(), $id = 0) {
    	$output .= '</li>';
	}
}
