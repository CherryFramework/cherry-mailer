<?php
/**
 * Define callback functions for templater
 *
 * @package   Cherry_Mailer
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2015 Cherry Team
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Callbcks for MailChimp shortcode templater
 *
 * @since  1.0.0
 */
class Cherry_Mailer_Template_Callbacks {
	/**
	 * Shortcode attributes
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $atts = array();

	/**
	 * Prefix name
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public static $name = 'mailer';

	/**
	 * Constructor for the class
	 *
	 * @since 1.0.0
	 * @param array $atts input attributes array.
	 */
	function __construct( $atts ) {
		$this->atts = $atts;
	}

	/**
	 * Get placeholder
	 *
	 * @since 1.0.0
	 */
	public function get_placeholder() {
		$return = $this->atts['placeholder'];
		if ( empty( $return ) ) {
			return $this->get_option( 'placeholder' );
		}
		return $return;
	}

	/**
	 * Get button text
	 *
	 * @since 1.0.0
	 */
	public function get_button_text() {
		$return = $this->atts['button_text'];
		if ( empty( $return ) ) {
			return $this->get_option( 'button_text' );
		}
		return $return;
	}

	/**
	 * Get success message
	 *
	 * @since 1.0.0
	 */
	public function get_success_message() {
		$return = $this->atts['success_message'];
		if ( empty( $return ) ) {
			return $this->get_option( 'success_message' );
		}
		return $return;
	}

	/**
	 * Get faul message
	 *
	 * @since 1.0.0
	 */
	public function get_fail_message() {
		$return = $this->atts['fail_message'];
		if ( empty( $return ) ) {
			return $this->get_option( 'fail_message' );
		}
		return $return;
	}

	/**
	 * Get warning message
	 *
	 * @since 1.0.0
	 */
	public function get_warning_message() {
		$return = $this->atts['warning_message'];
		if ( empty( $return ) ) {
			return $this->get_option( 'warning_message' );
		}
		return $return;
	}

	/**
	 * Get type form
	 *
	 * @since 1.0.0
	 */
	public function get_popup_is() {
		$return = $this->atts['popup_is'];
		if ( empty( $return ) ) {
			return $this->get_option( 'popup_is' );
		}
		return $return;
	}

	/**
	 * Get plugin options
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function get_option( $key ) {
		if ( $this->is_cherry_framework() ) {
			return cherry_get_option( self::$name . '_' . $key );
		} else {
			$options = get_option( self::$name . '_options' );
			return $options[ $key ];
		}
	}

	/**
	 * Return true if CherryFramework active.
	 *
	 * @return boolean
	 */
	public function is_cherry_framework() {

		if ( class_exists( 'Cherry_Framework' ) ) {
			return true;
		}

		return false;
	}

}
