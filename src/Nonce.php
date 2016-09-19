<?php # -*- coding: utf-8 -*-

namespace Decom\WPNonce;

/**
 *
 * WP Nonce implementation
 *
 * @package Decom\WPNonce
 * @since 1.0.0
 *
 */

class Nonce {

	/**
	 * Nonce action
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $action;

	/**
	 *
	 * Nonce name
	 *
	 * @since 1.0.0
	 * @var string
	 *
	 */
	private $name;

	/**
	 *
	 * Constructor. Sets up nonce action and name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $action Optional. Sets nonce action. Defaults to '-1'.
	 * @param string $name Optional. Sets nonce name. Defaults to '_wpnonce'.
	 *
	 */
	public function __construct( $action = '-1', $name = '_wpnonce' )
	{
		$this->action = $action;
		$this->name = $name;
	}

	public function url($base_url = '')
	{
		return wp_nonce_url($base_url, $this->action, $this->name);
	}

	public function field($ref = false, $echo = false)
	{
		return wp_nonce_field($this->action, $this->name, $ref, $echo);
	}

	public function value()
	{
		return wp_create_nonce($this->action);
	}

	public function verify_admin()
	{
		return check_admin_referer($this->action, $this->name);
	}

	public function verify_ajax()
	{
		return check_ajax_referer($this->action, $this->name);
	}

	public function verify($value)
	{
		return wp_verify_nonce($value, $this->action);
	}

	public function ays()
	{
		wp_nonce_ays($this->action);
	}

}
