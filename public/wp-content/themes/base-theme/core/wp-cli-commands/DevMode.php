<?php

/**
 * Implements example command.
 */
class DevMode_Command extends WP_CLI_Command {

	/**
	 * @param $args
	 * @param $assoc_args
	 */
	public function enable( $args, $assoc_args ) {
		exec( "sed -i \"s/define('WP_DEBUG', false)/define('WP_DEBUG', true)/g\" wp-config.php" );

		WP_CLI::success( "Enabled" );
	}

	/**
	 * @param $args
	 * @param $assoc_args
	 */
	public function disable( $args, $assoc_args ) {
		exec( "sed -i \"s/define('WP_DEBUG', true)/define('WP_DEBUG', false)/g\" wp-config.php" );

		WP_CLI::success( "Enabled" );
	}
}