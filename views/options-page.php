<?php
/**
 * Admin options page
 *
 * @package Cherry_Mailer
 *
 * @since 1.0.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Options fields
$fields = array(
	'apikey'            => array(
									'title'         => __( 'Api Key', 'cherry-mailer' ),
									'description'   => __( 'Set your Api Key', 'cherry-mailer' ),
									'value'         => __( '', 'cherry-mailer' ),
								),
	'list'              => array(
									'title'        => __( 'List', 'cherry-mailer' ),
									'description'  => __( 'Subscribe list id', 'cherry-mailer' ),
									'value'        => __( '', 'cherry-mailer' ),
								),
	'confirm'           => array(
									'title'        => __( 'Confirmation', 'cherry-mailer' ),
									'description'  => __( 'Email confirmation', 'cherry-mailer' ),
									'value'        => __( '', 'cherry-mailer' ),
								),
	'placeholder'       => array(
									'title'        => __( 'Placeholder', 'cherry-mailer' ),
									'description'  => __( 'Default placeholder for email input', 'cherry-mailer' ),
									'value'        => __( 'Enter your email', 'cherry-mailer' ),
								),
	'button_text'       => array(
									'title'        => __( 'Button', 'cherry-mailer' ),
									'description'  => __( 'Default submit button text', 'cherry-mailer' ),
									'value'        => __( 'Subscribe', 'cherry-mailer' ),
								),
	'success_message'   => array(
									'title'        => __( 'Success message', 'cherry-mailer' ),
									'description'  => __( 'Default success message', 'cherry-mailer' ),
									'value'        => __( 'Subscribed successfully', 'cherry-mailer' ),
								),
	'fail_message'      => array(
									'title'        => __( 'Fail message', 'cherry-mailer' ),
									'description'  => __( 'Default fail message', 'cherry-mailer' ),
									'value'        => __( 'Subscribed failed', 'cherry-mailer' ),
								),
	'warning_message'   => array(
									'title'        => __( 'Warning message', 'cherry-mailer' ),
									'description'  => __( 'Default warning message', 'cherry-mailer' ),
									'value'        => __( 'Email is incorect', 'cherry-mailer' ),
								),
);

// Check connect
if ( $this->check_apikey() ) {
	$connect_class = 'success';
	$connect_message = __( 'CONNECT', 'cherry-mailer' );
} else {
	$connect_class = 'danger';
	$connect_message = __( 'DISCONNECT', 'cherry-mailer' );
}

?>

<!-- Page Title -->
<div class="cherry-page-wrapper">
	<div class="cherry-page-title">
		<span>
			<?php echo __( 'Plugin options', 'cherry-mailer' ) ?>
		</span>
	</div>
</div>
<!-- END Page Title -->
<!-- Documentation link -->
<!--div class="cherry-info-box">
	<div class="documentation-link">Feel free to view detailed
		<a href="http://cherryframework.com/documentation/cf4/index.php?project=wordpress&lang=en_US" title="Documentation" target="_blank">
			Cherry Framework 4 documentation
		</a>
	</div>
</div-->
<!-- End Documentation link -->
<!-- Options -->
<div class="wrap cherry-option">
	<form id="cherry-mailer-option" method="POST">
			<?php foreach ( $fields as $field => $strings ) : ?>
			<?php
				// Render ui-element
				if ( 'confirm' == $field ) {
					$confirm = empty( $options['confirm'] ) ? 'true' : $options['confirm'];
					$ui_{$field} = new UI_Switcher2(
							array(
									'id'				=> 'confirm',
									'name'				=> 'confirm',
									'value'				=> $confirm,
									'toggle'			=> array(
											'true_toggle'	=> 'On',
											'false_toggle'	=> 'Off',
									),

									'style'		=> 'normal',
							)
					);
				} else {
					$value = empty( $options[ $field ] ) ? $strings['value'] : $options[ $field ];
					$ui_{$field} = new UI_Text(
							array(
									'id'            => $field,
									'type'          => 'text',
									'name'          => $field,
									'placeholder'   => $strings['title'],
									'value'         => $value,
									'label'         => '',
							)
					);
				}

				$html = $ui_{$field}->render();
			?>
			<div class="row">
				<div class="col-md-12">
					<h4>
						<?php echo $strings['title'] ?>
						<?php if ( 'apikey' === $field ) : ?>
							<small id="cherry-mailer-connect" class="text-<?php echo $connect_class ?>">
								(<?php echo $connect_message ?>)
							</small>
						<?php endif; ?>
					</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="description">
						<?php echo $strings['description'] ?>
					</div>
					<?php
					if ( 'apikey' == $field || 'list' == $field ) :
						$tooltips_content = array(
							'apikey'    => array(
								'content'   => __( 'API stands for application programming interface. It can be helpful to think of the API as a way for different apps to talk to one another.', 'cherry-mailer' )
									. ' ' . __( 'Press this box for read more information on the mailer knowledge base.', 'cherry-mailer' ),
								'url'       => 'http://kb.mailer.com/accounts/management/about-api-keys',
							),
							'list'      => array(
								'content'   => __( 'Each MailChimp list has a unique List ID that integrations, plugins, and widgets may require to connect and transfer subscriber data.', 'cherry-mailer' )
									. ' ' . __( 'Press this box for read more information on the mailer knowledge base.', 'cherry-mailer' ),
								'url'       => 'http://kb.mailer.com/lists/managing-subscribers/find-your-list-id',
							),
						);
						$ui_tooltip = new UI_Tooltip2(
							array(
								'id'			=> 'cherry-mailer-options-tooltip-' . $field,
								'hint'			=> array(
									'type'		=> 'text',
									'content'	=> $tooltips_content[ $field ]['content'],
								),
								'class'			=> '',
							)
						);
						?>
						<a class="cherry-mailer-tooltip-url" href="<?php echo $tooltips_content[ $field ]['url'] ?>">
							<?php echo $ui_tooltip->render(); ?>
						</a>
					<?php endif; ?>
				</div>
				<div class="col-md-9">
					<?php echo $html ?>
				</div>
			</div>
			<?php endforeach; ?>
		<input type="hidden" name="action" value="cherry_mailer_save_options">
	</form>
	<div class="row cherry-mailer-submit-wrapper">
		<div class="col-md-6"></div>
		<div class="col-md-6 cherry-mailer-action">
			<div class="cherry-mailer-action-button">
				<a id="cherry-mailer-options-save" class="button button-secondary_ ">
					<?php echo __( 'Save options', 'cherry-mailer' ) ?>
					<div class="cherry-spinner-wordpress spinner-wordpress-type-2"><span class="cherry-inner-circle"></span></div>
				</a>
			</div>
			<div id="cherry-mailer-generate-view" class="cherry-mailer-action-button">
				<!-- Shortcode -->
				<?php
				do_action( 'cherry_shortcode_generator_buttons' );
				?>
				<!-- END Shortcode -->
			</div>
		</div>
	</div>
</div>
<!-- END Options -->
<div class="cherry-clear"></div>
