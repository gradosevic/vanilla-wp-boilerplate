<?php

/**
 * Class WP_Blade_Main_Model
 */
class WP_Blade_Main_Model {

	/**
	 * Blade template
	 */
	var $bladedTemplate;

	/**
	 * Return a new class instance
	 * @return WP_Blade_Main_Model
	 */
	public static function make() {
		return new self();
	}

	/**
	 * Return a call of templateinclude blade passing template path.
	 *
	 * @param string $template
	 * @return string path of the compiled view path of the compiled view
	 */
	function get_query_template( $template ) {
		return $this->template_include_blade( $template );
	}

	/**
	 * Handle the compilation of the templates
	 *
	 * @param string template path
	 * @return string compiled template path compiled template path
	 */
	public function template_include_blade( $template ) {
		if ( $this->bladedTemplate ) {
			return $this->bladedTemplate;
		}

		if ( ! $template ) {
			return $template;
		}

		require_once( WP_BLADE_CONFIG_PATH . 'paths.php' );

		Laravel\Blade::sharpen();
		$view = Laravel\View::make( 'path: ' . $template, array() );

		$pathToCompiled = Laravel\Blade::compiled( $view->path );

		if ( ! file_exists( $pathToCompiled ) or Laravel\Blade::expired( $view->view, $view->path ) ) {
			file_put_contents( $pathToCompiled, "<?php // $template ?>\n" . Laravel\Blade::compile( $view ) );
		}

		$view->path = $pathToCompiled;

		if ( $error = error_get_last() ) {
			//var_dump($error);
			//exit;
		}

		return $this->bladedTemplate = $view->path;
	}
}
