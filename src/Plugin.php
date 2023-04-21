<?php

namespace JPry\JurassicNinjaInfiniteLife;

/**
 * Class Plugin
 *
 * @since %VERSION%
 */
class Plugin {

	public function register() {
		add_filter(
			'woocommerce_settings_features',
			function( $features ) {
				return $this->add_settings_features( $features );
			}
		);
	}

	private function add_settings_features( array $features ) {
		$features['jurassic-ninja-infinite-life'] = [
			'description' => __( 'This plugin extends the life of Jurassic Ninja sites to indefinitely.', 'jurassic-ninja-infinite-life' ),
			'enabled_by_default' => true,
			'name' => __( 'Jurassic Ninja Infinite Life', 'jurassic-ninja-infinite-life' ),
			'is_experimental' => false,
		];

		return $features;
	}
}
