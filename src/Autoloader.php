<?php
/**
 * Includes the composer Autoloader used for packages and classes in the src/ directory.
 */

namespace JPry\JurassicNinjaInfiniteLife;

defined( 'ABSPATH' ) || exit;

/**
 * Autoloader class.
 *
 * @since 1.0.0
 */
class Autoloader {

	private static $did_init = false;

	/**
	 * Static-only class.
	 */
	private function __construct() {}

	/**
	 * Require the autoloader and return the result.
	 *
	 * If the autoloader is not present, let's log the failure and display a nice admin notice.
	 *
	 * @return boolean
	 */
	public static function init() {
		if ( self::$did_init ) {
			return true;
		}

		$autoloader = dirname( __DIR__ ) . '/vendor/autoload_packages.php';

		if ( ! is_readable( $autoloader ) ) {
			self::missing_autoloader();
			return false;
		}

		$autoloader_result = require $autoloader;
		if ( ! $autoloader_result ) {
			return false;
		}

		self::$did_init = true;

		return $autoloader_result;
	}

	/**
	 * If the autoloader is missing, add an admin notice.
	 */
	protected static function missing_autoloader() {
		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			error_log(
				esc_html__( 'Your installation of this plugin is incomplete. If you installed from GitHub, please run "composer install".', 'jurassic-ninja-infinite-life' )
			);
		}
		add_action(
			'admin_notices',
			function() {
				?>
				<div class="notice notice-error">
					<p>
						<?php
						printf(
							/* translators: 1: opening code tag. 2: closing code tag */
							esc_html__( 'Your installation of this plugin is incomplete. If you installed from GitHub, run %1$scomposer install%2$s.', 'jurassic-ninja-infinite-life' ),
							'<code>',
							'</code>'
						);
						?>
					</p>
				</div>
				<?php
			}
		);
	}
}
