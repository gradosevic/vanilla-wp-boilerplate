<?php

use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use \Illuminate\Filesystem\Filesystem;
use \Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\FileViewFinder;
use Illuminate\Events\Dispatcher;
use \Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Factory;

class WP_Blade_Factory {

	/** @var Factory */
	protected static $factory;

	protected function __construct() {}

	public static function make() {

		if (!static::$factory) {
			$resolver = new EngineResolver();
			$resolver->register('php', function() {
				return new PhpEngine;
			});
			$resolver->register('blade', function() {
				$filesystem = new Filesystem();
				$compiler = new BladeCompiler($filesystem, __DIR__ . DIRECTORY_SEPARATOR . 'compiled');

				return new CompilerEngine($compiler);
			});

			$files = new Filesystem();
			$paths = [
				BLADE_VIEWS_PATH,
				BLADE_VIEWS_PATH . DS . 'views'
			];
			$finder = new FileViewFinder($files, $paths);

			$events = (new Dispatcher());

			static::$factory = new Factory($resolver, $finder, $events);
		}

		return static::$factory;
	}
}