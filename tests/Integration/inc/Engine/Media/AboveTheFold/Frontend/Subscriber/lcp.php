<?php

namespace WP_Rocket\Tests\Integration\inc\Engine\Media\AboveTheFold\Frontend\Subscriber;

use Brain\Monkey\Functions;
use WP_Rocket\Tests\Integration\DBTrait;
use WP_Rocket\Tests\Integration\FilesystemTestCase;

/**
 * Test class covering \WP_Rocket\Engine\Media\AboveTheFold\Frontend\Subscriber::lcp
 *
 * @group AboveTheFold
 */
class Test_lcp extends FilesystemTestCase {

	use DBTrait;

	protected $path_to_test_data = '/inc/Engine/Media/AboveTheFold/Frontend/Subscriber/lcp.php';

	protected $config;

	public static function set_up_before_class() {
		parent::set_up_before_class();
		self::installFresh();
	}

	public static function tear_down_after_class() {
		self::uninstallAll();
		parent::tear_down_after_class();
	}

	public function set_up() {
		parent::set_up();
		$this->unregisterAllCallbacksExcept( 'rocket_buffer', 'lcp', 17 );
	}

	public function tear_down() {
		$this->restoreWpHook( 'rocket_buffer' );
		parent::tear_down();
	}

	/**
	 * @dataProvider providerTestData
	 */
	public function testShouldReturnAsExpected( $config, $expected ) {
		$this->config = $config;
		if ( ! empty( $config['row'] ) ) {
			self::addLcp( $config['row'] );
		}

		Functions\when( 'wp_create_nonce' )->justReturn( '96ac96b69e' );

		$this->assertSame(
			$expected,
			apply_filters( 'rocket_buffer', $config['html'] )
		);
	}
}
