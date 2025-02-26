<?php

namespace WP_Rocket\Tests\Unit\inc\ThirdParty\Themes\Themify;

use Mockery;
use WP_Rocket\Admin\Options_Data;
use WP_Rocket\Tests\Unit\TestCase;
use WP_Rocket\ThirdParty\Themes\Themify;

/**
 * Test class covering \WP_Rocket\ThirdParty\Themes\Themify::maybe_enable_dev_mode
 *
 * @group ThirdyParty
 */
class TestMaybeEnableDevMode extends TestCase {
	protected $options;
	protected $themify;

	public function set_up() {
		parent::set_up();

		$this->options = Mockery::mock(Options_Data::class);
		$this->themify = new Themify( $this->options );
	}

	/**
	 * @dataProvider configTestData
	 */
	public function testShouldReturnAsExpected( $config, $expected ) {
		$this->options
			->shouldReceive( 'get' )
			->with( 'remove_unused_css', false )
			->andReturn( $config['rucss_enabled'] );

		$this->assertSame(
			$expected,
			$this->themify->maybe_enable_dev_mode( $config['is_enabled'] )
		);
	}
}
