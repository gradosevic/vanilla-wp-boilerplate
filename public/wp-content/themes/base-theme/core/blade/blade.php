<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DS . 'model.php';
require_once __DIR__ . DS . 'factory.php';

// Instantiate main model
$factory = WP_Blade_Factory::make();
$model = new WP_Blade_Model($factory);

// Bind to template include action
add_action( 'template_include', array( $model, 'template_include_blade' ) );

// Listen for index template filter
add_filter( 'index_template', array( $model, 'template_include_blade' ) );

// Listen for page template filter
add_filter( 'page_template', array( $model, 'template_include_blade' ) );

// Listen for Buddypress include action
add_filter( 'bp_template_include', array( $model, 'template_include_blade' ) );