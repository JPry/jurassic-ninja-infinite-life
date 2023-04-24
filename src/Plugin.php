<?php

namespace JPry\JurassicNinjaInfiniteLife;

/**
 * Class Plugin
 *
 * @since x.x.x
 */
class Plugin {

	private string $option_id = 'jurassic-ninja-infinite-life';

	/**
	 * Determine if infinite life is enabled.
	 *
	 * @return bool
	 */
	public function infinite_life_enabled(): bool {
		return 'yes' === get_option( $this->option_id, 'no' );
	}

	public function register() {
		add_filter(
			'woocommerce_settings_features',
			function( $features ) {
				return $this->add_settings_features( $features );
			}
		);
	}

	private function add_settings_features( array $features ) {
		$features[] = [
			'title' => __( 'Jurasic Ninja Infinite Life', 'jurassic-ninja-infinite-life' ),
			'desc'  => __( 'This plugin extends the life of Jurassic Ninja sites indefinitely.', 'jurassic-ninja-infinite-life' ),
			'id'    => $this->option_id,
			'type'  => 'checkbox',
			'class' => '',
		];

		return $features;
	}
}
