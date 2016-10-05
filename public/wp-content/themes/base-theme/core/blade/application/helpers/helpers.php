<?php

/**
 * @param $haystack
 * @param $needles
 *
 * @return bool
 */
function starts_with( $haystack, $needles ) {
	foreach ( (array) $needles as $needle ) {
		if ( strpos( $haystack, $needle ) === 0 ) {
			return true;
		}
	}

	return false;
}

/**
 * @param $view
 * @param array $data
 *
 * @return \Laravel\View
 */
function view( $view, $data = array() ) {
	return Laravel\View::make( $view, $data );
}

/**
 * Determine if a given string contains a given sub-string.
 *
 * @param  string $haystack
 * @param  string|array $needle
 *
 * @return bool
 */
function str_contains( $haystack, $needle ) {
	foreach ( (array) $needle as $n ) {
		if ( strpos( $haystack, $n ) !== false ) {
			return true;
		}
	}

	return false;
}

/**
 * @param array $args
 *
 * @return array
 */
function queryToArray( $args = array() ) {
	$query = new WP_Query( $args );

	return $query->get_posts();
}

/**
 * @param $path
 */
function blade_set_storage_path( $path ) {
	$GLOBALS['blade_storage_path'] = $path;
}