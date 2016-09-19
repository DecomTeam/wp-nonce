<?php # -*- coding: utf-8 -*-

namespace Decom\WPNonce\Tests;

use Brain\Monkey;
use Brain\Monkey\Functions;
use PHPUnit\Framework\TestCase;

use Decom\WPNonce\Nonce;

class NonceTest extends TestCase {

	protected $nonce_action;
	protected $nonce_name;
	protected $nonce_value;
	protected $nonce_url;
	protected $nonce_field;

	protected function setUp()
	{
		parent::setUp();
		Monkey::setUp();

		$this->base_url = 'http://decom.ba';
		$this->nonce_action = 'action';
		$this->nonce_name = 'name';
		$this->nonce_value = 'value';
		$this->nonce_url = $this->base_url . '?' . $this->nonce_name . '=' . $this->nonce_value;
		$this->nonce_field = '<input type="hidden" id="' . $this->nonce_name . '" name="' . $this->nonce_name . '" value="' . $this->nonce_value . '" />';
	}

	public function tearDown()
	{
		Monkey::tearDown();
		parent::tearDown();
	}

	public function testUrl()
	{
		// mock wp_nonce_url
		Functions::expect('wp_nonce_url')
			->once()
			->with($this->base_url, $this->nonce_action, $this->nonce_name)
			->andReturn($this->nonce_url);

		$nonce = new Nonce($this->nonce_action, $this->nonce_name);
		$this->assertEquals($this->nonce_url, $nonce->url($this->base_url));
	}

	public function testField()
	{
		// mock wp_nonce_field
		Functions::expect('wp_nonce_field')
			->once()
			->with($this->nonce_action, $this->nonce_name, false, false)
			->andReturn($this->nonce_field);

		$nonce = new Nonce($this->nonce_action, $this->nonce_name);
		$this->assertEquals($this->nonce_field, $nonce->field());
	}

	public function testCreate()
	{
		// mock wp_create_nonce
		Functions::expect('wp_create_nonce')
			->once()
			->with($this->nonce_action)
			->andReturn($this->nonce_value);

		$nonce = new Nonce($this->nonce_action, $this->nonce_name);
		$this->assertEquals($this->nonce_value, $nonce->value());
	}

	public function testVerifyAdminValid()
	{
		// mock check_admin_referer success
		Functions::expect('check_admin_referer')
			->once()
			->with($this->nonce_action, $this->nonce_name)
			->andReturn(true);

		$nonce = new Nonce($this->nonce_action, $this->nonce_name);
		$this->assertTrue($nonce->verify_admin());
	}

	public function testVerifyAdminInvalid()
	{
		// mock check_admin_referer fail
		Functions::expect('check_admin_referer')
			->once()
			->with($this->nonce_action, $this->nonce_name)
			->andReturn(false);

		$nonce = new Nonce($this->nonce_action, $this->nonce_name);
		$this->assertFalse($nonce->verify_admin());
	}

	public function testVerifyAjaxValid()
	{
		// mock check_admin_referer success
		Functions::expect('check_ajax_referer')
			->once()
			->with($this->nonce_action, $this->nonce_name)
			->andReturn(true);

		$nonce = new Nonce($this->nonce_action, $this->nonce_name);
		$this->assertTrue($nonce->verify_ajax());
	}

	public function testVerifyAjaxInvalid()
	{
		// mock check_ajax_referer fail
		Functions::expect('check_ajax_referer')
			->once()
			->with($this->nonce_action, $this->nonce_name)
			->andReturn(false);

		$nonce = new Nonce($this->nonce_action, $this->nonce_name);
		$this->assertFalse($nonce->verify_ajax());
	}

	public function testVerifyValid()
	{
		// mock wp_verify_nonce success
		Functions::expect('wp_verify_nonce')
			->once()
			->with($this->nonce_value ,$this->nonce_action)
			->andReturn(true);

		$nonce = new Nonce($this->nonce_action, $this->nonce_name);
		$this->assertTrue($nonce->verify($this->nonce_value));
	}

	public function testVerifyInvalid()
	{
		// mock wp_verify_nonce fail
		Functions::expect('wp_verify_nonce')
			->once()
			->with($this->nonce_value ,$this->nonce_action)
			->andReturn(false);

		$nonce = new Nonce($this->nonce_action, $this->nonce_name);
		$this->assertFalse($nonce->verify($this->nonce_value));
	}

}
