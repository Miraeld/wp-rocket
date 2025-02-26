<?php

namespace WP_Rocket\Tests\Unit\inc\Engine\CriticalPath\CriticalCSSSubscriber;

use Brain\Monkey\Functions;
use Mockery;
use WP_Rocket\Admin\Options_Data;
use WP_Rocket\Admin\Options;
use WP_Rocket\Engine\CriticalPath\CriticalCSSSubscriber;
use WP_Rocket\Engine\CriticalPath\CriticalCSS;
use WP_Rocket\Engine\CriticalPath\ProcessorService;
use WP_Rocket\Engine\License\API\User;
use WP_Rocket\Tests\Unit\TestCase;

/**
 * Test class covering \WP_Rocket\Engine\CriticalPath\CriticalCSSSubscriber::switch_to_rucss
 */
class TestSwitchToRucss extends TestCase {
	protected $critical_css;
	protected $cpcss_service;
	protected $options;
	protected $options_api;
	protected $user;
	protected $filesystem;

	/**
	 * @var CriticalCSSSubscriber
	 */
	protected $criticalcsssubscriber;

	public function set_up() {
		parent::set_up();
		$this->critical_css = Mockery::mock(CriticalCSS::class);
		$this->cpcss_service = Mockery::mock(ProcessorService::class);
		$this->options = Mockery::mock(Options_Data::class);
		$this->options_api = Mockery::mock(Options::class);
		$this->user = Mockery::mock(User::class);
		$this->filesystem = null;

		$this->criticalcsssubscriber = new CriticalCSSSubscriber($this->critical_css, $this->cpcss_service, $this->options, $this->options_api, $this->user, $this->filesystem);
	}

	/**
	 * @dataProvider configTestData
	 */
	public function testShouldDoAsExpected( $config, $expected ) {
		Functions\when('rocket_get_constant')->justReturn(true);
		Functions\expect('check_admin_referer')->with($expected['action']);
		Functions\expect('current_user_can')->with('rocket_manage_options')->andReturn($config['user_can']);
		Functions\expect('wp_get_referer')->andReturn($config['referer']);
		Functions\expect('wp_safe_redirect')->with($expected['referer']);
		Functions\expect('wp_die');
		$this->configure_switch_rucss($config, $expected);
		$this->configure_dismiss($config, $expected);
		$this->criticalcsssubscriber->switch_to_rucss();
	}

	protected function configure_switch_rucss( $config, $expected ) {
		if( ! $config['user_can'] ) {
			return;
		}

		$this->options->shouldReceive('set')->with('async_css', false);
		$this->options->shouldReceive('set')->with('remove_unused_css', true);
		$this->options->shouldReceive('get_options')->andReturn($config['options']);
		$this->options_api->shouldReceive('set')->with('settings', $expected['options']);

	}

	protected function configure_dismiss( $config, $expected ) {
		if (! $config['user_can']) {
			return;
		}
		Functions\expect('rocket_dismiss_box')->with('switch_to_rucss_notice');
	}
}
