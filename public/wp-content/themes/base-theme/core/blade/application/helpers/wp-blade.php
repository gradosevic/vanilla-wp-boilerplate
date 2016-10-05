<?php

/**
 * Class WP_Blade
 */
class WP_Blade {

	protected static $compilers = array(
		'wpquery',
		'wpposts',
		'wpempty',
		'wpend',
		'debug',
		'acfrepeater',
		'acfend',
		'define'
	);

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	public static function compile_acfrepeater( $value ) {
		$pattern     = '/(\s*)@acfrepeater\(((\s*)(.+))\)/';
		$replacement = '$1<?php if ( get_field( $2 ) ) : ';
		$replacement .= 'while ( has_sub_field( $2 ) ) : ?>';

		return preg_replace( $pattern, $replacement, $value );
	}

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	public static function compile_acfend( $value ) {
		return str_replace( '@acfend', '<?php endwhile; endif; ?>', $value );
	}

	/**
	 * @param $value
	 * @param null $view
	 *
	 * @return mixed
	 */
	public static function compile_string( $value, $view = null ) {
		foreach ( static::$compilers as $compiler ) {
			$method = "compile_{$compiler}";

			$value = static::$method( $value, $view );
		}

		return $value;
	}

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	protected static function compile_wpposts( $value ) {
		return str_replace( '@wpposts', '<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>', $value );
	}

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	protected static function compile_wpquery( $value ) {
		$pattern     = '/(\s*)@wpquery(\s*\(.*\))/';
		$replacement = '$1<?php $bladequery = new WP_Query$2; ';
		$replacement .= 'if ( $bladequery->have_posts() ) : ';
		$replacement .= 'while ( $bladequery->have_posts() ) : ';
		$replacement .= '$bladequery->the_post(); ?> ';

		return preg_replace( $pattern, $replacement, $value );
	}

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	protected static function compile_wpempty( $value ) {
		return str_replace( '@wpempty', '<?php endwhile; ?><?php else: ?>', $value );
	}

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	protected static function compile_wpend( $value ) {
		return str_replace( '@wpend', '<?php endif; wp_reset_postdata(); ?>', $value );
	}

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	protected static function compile_debug( $value ) {
		// Done last
		if ( strpos( $value, '@debug' ) ) {
			die( $value );
		}

		return $value;
	}

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	protected static function compile_define( $value ) {
		return preg_replace( '/\@define(.+)/', '<?php ${1}; ?>', $value );
	}

}
