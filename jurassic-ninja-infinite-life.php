<?php
/**
 * Plugin Name: Jurassic Ninja Infinite Life
 * Plugin URI:
 * Description: This plugin extends the life of Jurassic Ninja sites to indefinitely.
 * Author: Jeremy Pry
 * Author URI: https://jeremypry.com
 * Version: 1.0.0
 * Text Domain: jurassic-ninja-infinite-life
 * Domain Path: /languages
 * License: MIT
 *
 */

use Automattic\WooCommerce\Utilities\FeaturesUtil;
use JPry\JurassicNinjaInfiniteLife\Autoloader;

// If this file is called directly, abort.
defined( 'ABSPATH' ) || die;

// Load autoloader.
require_once __DIR__ . '/src/Autoloader.php';
if ( ! Autoloader::init() ) {
	return;
}

// Declare compatibility with HPOS.
add_action(
	'before_woocommerce_init',
	function() {
		if ( class_exists( FeaturesUtil::class ) ) {
			FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__ );
		}
	}
);

// Load plugin on woocommerce_loaded hook.
add_action(
	'woocommerce_loaded',
	function() {

	}
);
