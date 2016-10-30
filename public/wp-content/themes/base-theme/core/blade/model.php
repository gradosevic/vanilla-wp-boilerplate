<?php

use Illuminate\View\Factory;
use \Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\View;
use Illuminate\View\Engines\PhpEngine;

/**
 * Class WP_Blade_Main_Model
 */
class WP_Blade_Model {

	/** @var  \Illuminate\View\Factory */
	protected $factory;

	/** @var \Illuminate\View\Engines\Engine */
	protected $engine;

	/** @var  string */
	protected $compiled_path;

	/**
	 * WP_Blade_Main_Model constructor.
	 */
	public function __construct(Factory $factory) {
		$this->factory = $factory;
	}

	/**
	 * Handle the compilation of the templates
	 *
	 * @param string template path
	 * @return string compiled template path compiled template path
	 */
	public function template_include_blade( $path ) {

		if ($path === $this->compiled_path) {
			return $path;
		}

		$view = $path ? pathinfo($path, PATHINFO_FILENAME) : 'index';

		if ( $post_type = get_post_type_object(get_post_type()) ) {
			if ($single_post_view = $post_type->single_post_view) {
				$view = $single_post_view;
			}
		}

		$factory = $this->factory;
		$path = $factory->getFinder()->find($view);
		$engine = $factory->getEngineFromPath( $path );

		if (get_class($engine) == PhpEngine::class) {
			return $path;
		}

		$this->compiled_path = BLADE_COMPILED_PATH . DS . sha1($path) . '.php';
		if (true || !file_exists($this->compiled_path) || filemtime($path) > filemtime($this->compiled_path)) {
			$view = new View($factory, $engine, $view, $path, array() );
			$contents = $view->render();
			file_put_contents(
				$this->compiled_path,
				'<?php $__env = WP_BLADE_FACTORY::make(); ?>' . "\n" . $contents
			);
		}

		return $this->compiled_path;
//		require_once( WP_BLADE_CONFIG_PATH . 'paths.php' );

		// Lookup a blade template
//		$pathinfo = pathinfo( $template );
//		$bladeTemplate = $pathinfo['dirname'] . DS . $pathinfo['filename'] . '.blade.php';
//
//		if ( file_exists( $bladeTemplate ) ) {
//			$template = $bladeTemplate;
//		}
//
//		Laravel\Blade::sharpen();
//		$view = Laravel\View::make( 'path: ' . $template, array() );
//
//		$pathToCompiled = Laravel\Blade::compiled( $view->path );
//
//		if ( ! file_exists( $pathToCompiled ) or Laravel\Blade::expired( $view->view, $view->path ) ) {
//			file_put_contents( $pathToCompiled, "<?php // $template >\n" . Laravel\Blade::compile( $view ) );
//		}
//
//		$view->path = $pathToCompiled;
//
//		if ( $error = error_get_last() ) {
//			//var_dump($error);
//			//exit;
//		}
//
//		return $this->bladedTemplate = $view->path;
	}
}