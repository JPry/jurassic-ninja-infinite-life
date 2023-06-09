<?php
/**
 * Plugin Name: Jurassic Ninja Infinite Life
 * Plugin URI:  https://github.com/JPry/jurassic-ninja-infinite-life
 * Description: This plugin extends the life of Jurassic Ninja sites indefinitely.
 * Author:      Jeremy Pry
 * Author URI:  https://jeremypry.com
 * Version:     1.0.0
 * Text Domain: jurassic-ninja-infinite-life
 * Domain Path: /languages
 * License:     MIT
 *
 * Requires at least: 5.9
 * Tested up to: 6.2
 * Requires PHP: 7.4
 *
 * WC tested up to: 7.6
 * WC requires at least: 7.0
 *
 * GitHub Plugin URI: JPry/jurassic-ninja-infinite-life
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;
use JPry\JurassicNinjaInfiniteLife\Autoloader;
use JPry\JurassicNinjaInfiniteLife\PluginFactory;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || exit;

// Define constants.
define( 'JPRY_JNIL', '1.0.0' ); // WRCS: DEFINED_VERSION.

// Declare compatibility with HPOS.
add_action(
	'before_woocommerce_init',
	function() {
		if ( class_exists( FeaturesUtil::class ) ) {
			FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__ );
		}
	}
);

// Load autoloader.
require_once __DIR__ . '/src/Autoloader.php';
if ( ! Autoloader::init() ) {
	return;
}

// Load plugin on woocommerce_loaded hook.
add_action(
	'woocommerce_loaded',
	function() {
		PluginFactory::get_plugin()->register();
	}
);

// Register deactivation hook.
register_deactivation_hook(
	__FILE__,
	function() {
		PluginFactory::get_plugin()->deactivate();
	}
);
