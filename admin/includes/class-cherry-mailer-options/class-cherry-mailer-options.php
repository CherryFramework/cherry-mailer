<?php
/**
 * Cherry MailChimp Data class.
 * main public class. Grab team data form database and output it
 *
 * @package   Cherry_Mailer
 * @author    Cherry Team
 * @license   GPL-2.0+
 * @link      http://www.cherryframework.com/
 * @copyright 2015 Cherry Team
 */

/**
 * Class for MailChimp options.
 *
 * @since 1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// If class 'MailChimp_Options' not exists.
if ( ! class_exists('Mailer_Options') ) {
	/**
	 * Define Options class for Cherry FrameWork
	 */
	class Mailer_Options {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Prefix name
		 *
		 * @since 1.0.0
		 * @var string
		 */
		public static $name = 'mailer';

		/**
		 * Mailchimp_Options constructor.
		 */
		private function __construct() {
			// Cherry option filter.
			add_filter( 'cherry_defaults_settings', array( $this, 'cherry_mailer_settings' ) );
		}

		/**
		 * Add menu item in Cherry FrameWork
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public function cherry_mailer_settings($result_array ) {
			$mailer_options = array();

			$mailer_options[ self::$name . '_apikey' ] = array(
				'type'			=> 'text',
				'title'			=> __( 'Api Key', 'cherry-mailer' ),
				'description'	=> __( 'Set your Api Key', 'cherry-mailer' ),
				'value'			=> __( '', 'cherry-mailer' ),
			);

			$mailer_options[ self::$name . '_list' ] = array(
				'type'			=> 'text',
				'title'			=> __( 'List', 'cherry-mailer' ),
				'description'	=> __( 'Subscribe list id', 'cherry-mailer' ),
				'value'			=> __( '', 'cherry-mailer' ),
			);

			$mailer_options[ self::$name . '_confirm' ] = array(
				'type'			=> 'switcher',
				'title'			=> __( 'Confirmation', 'cherry-mailer' ),
				'description'	=> __( 'Email confirmation', 'cherry-mailer' ),
				'value'			=> __( 'true', 'cherry-mailer' ),
			);

			$mailer_options[ self::$name . '_placeholder' ] = array(
				'type'			=> 'text',
				'title'			=> __( 'Placeholder', 'cherry-mailer' ),
				'description'	=> __( 'Default placeholder for email input', 'cherry-mailer' ),
				'value'			=> __( 'Enter your email', 'cherry-mailer' ),
			);

			$mailer_options[ self::$name . '_button_text' ] = array(
				'type'			=> 'text',
				'title'			=> __( 'Button', 'cherry-mailer' ),
				'description'	=> __( 'Default submit button text', 'cherry-mailer' ),
				'value'			=> __( 'Subscribe', 'cherry-mailer' ),
			);

			$mailer_options[ self::$name . '_success_message' ] = array(
				'type'			=> 'text',
				'title'			=> __( 'Success message', 'cherry-mailer' ),
				'description'	=> __( 'Default success message', 'cherry-mailer' ),
				'value'			=> __( 'Subscribed successfully', 'cherry-mailer' ),
			);

			$mailer_options[ self::$name . '_fail_message' ] = array(
				'type'			=> 'text',
				'title'			=> __( 'Fail message', 'cherry-mailer' ),
				'description'	=> __( 'Default fail message', 'cherry-mailer' ),
				'value'			=> __( 'Subscribed failed', 'cherry-mailer' ),
			);

			$mailer_options[ self::$name . '_warning_message' ] = array(
				'type'			=> 'text',
				'title'			=> __( 'Warning message', 'cherry-mailer' ),
				'description'	=> __( 'Default warning message', 'cherry-mailer' ),
				'value'			=> __( 'Email is incorect', 'cherry-mailer' ),
			);

			$mailer_options = apply_filters( 'cherry_mailchimp_default_settings', $mailer_options );
			$result_array['mailer-options-section'] = array(
				'name'			=> __( 'Cherry MailChimp', 'cherry-mailer' ),
				'icon' 			=> 'dashicons dashicons-format-gallery',
				'priority'		=> 120,
				'options-list'	=> $mailer_options,
			);
			return $result_array;
		}


		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {
			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}

			return self::$instance;
		}
	}//end class

	Mailer_Options::get_instance();
}
