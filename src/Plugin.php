<?php

namespace JPry\JurassicNinjaInfiniteLife;

defined( 'ABSPATH' ) || exit;

/**
 * Class Plugin
 *
 * @since 1.0.0
 */
class Plugin {

	private string $option_id = 'jurassic-ninja-infinite-life';

	private string $action_hook = 'jurassic_ninja_infinite_life';

	/**
	 * Determine if infinite life is enabled.
	 *
	 * @return bool
	 */
	public function infinite_life_enabled(): bool {
		return 'yes' === get_option( $this->option_id, 'no' );
	}

	/**
	 * Register our hooks with WordPress.
	 *
	 * @return void
	 */
	public function register() {
		add_filter(
			'woocommerce_settings_features',
			function( $features ) {
				return $this->add_settings_features( $features );
			}
		);

		add_action(
			'init',
			function() {
				$this->maybe_schedule_action();
			}
		);

		add_action(
			$this->action_hook,
			function() {
				$this->extend_jurassic_ninja_life();
			}
		);
	}

	/**
	 * Clean up our actions and options when the plugin is deactivated.
	 *
	 * @return void
	 */
	public function deactivate() {
		as_unschedule_all_actions( $this->action_hook );
		delete_option( $this->option_id );
	}

	/**
	 * Add the infinite life feature to the WooCommerce settings.
	 *
	 * @param array $features
	 *
	 * @return array
	 */
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

	/**
	 * Maybe schedule the action, depending on whether the setting is enabled and the action is not already scheduled.
	 *
	 * @return void
	 */
	private function maybe_schedule_action() {
		// Don't schedule the action if the feature is not enabled.
		if ( ! $this->infinite_life_enabled() ) {
			return;
		}

		// If the action has already been scheduled, don't do it again.
		if ( as_next_scheduled_action( $this->action_hook ) ) {
			return;
		}

		/**
		 * Filter the frequency of the action.
		 *
		 * @param int $action_frequency The frequency of the action in seconds.
		 */
		$action_frequency = apply_filters( 'jurassic_ninja_infinite_life_action_frequency', 2 * DAY_IN_SECONDS );

		// Schedule the action.
		as_schedule_recurring_action(
			time(),
			$action_frequency,
			$this->action_hook
		);
	}

	/**
	 * Extend the life of the Jurassic Ninja site.
	 *
	 * @return void
	 */
	private function extend_jurassic_ninja_life() {
		$companion_api_base_url = get_option( 'companion_api_base_url', '' );

		// Return early if this is not set.
		if ( empty( $companion_api_base_url ) ) {
			return;
		}

		// Check that the domain is part of the API domain, e.g. that it ends with jurassic.ninja.
		$domain     = wp_parse_url( network_site_url(), PHP_URL_HOST );
		$api_domain = wp_parse_url( $companion_api_base_url, PHP_URL_HOST );
		if ( ! str_ends_with( $domain, $api_domain ) ) {
			return;
		}

		wp_remote_post(
			"{$companion_api_base_url}/extend",
			[
				'headers' => [
					'content-type' => 'application/json',
				],
				'body'    => wp_json_encode( [ 'domain' => $domain ] ),
			]
		);
	}
}
