<?php

namespace JPry\JurassicNinjaInfiniteLife;

defined( 'ABSPATH' ) || exit;

/**
 * Class PluginFactory
 *
 * @since 1.0.0
 */
class PluginFactory {

	/**
	 * Get the Plugin instance.
	 *
	 * @return Plugin
	 */
	public static function get_plugin(): Plugin {
		static $plugin = null;
		if ( null === $plugin ) {
			$plugin = new Plugin();
		}

		return $plugin;
	}
}
