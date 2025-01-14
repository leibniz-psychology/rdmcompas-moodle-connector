<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       https://example.com
 * @since      1.0.0
 * @package    RDM Compas Moodle Connector
 */

namespace app\wisdmlabs\edwiserBridge;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Eb Admin.
 */
class Eb_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 *
	 * @var string The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 *
	 * @var string The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function admin_enqueue_styles() {
		/*
		 * An instance of this class should be passed to the run() function
		 * defined in EB_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The EB_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$eb_plugin_url = \app\wisdmlabs\edwiserBridge\wdm_edwiser_bridge_plugin_url();

		wp_enqueue_style( 'dashicons' );

		wp_enqueue_style(
			$this->plugin_name . '_font_awesome',
			$eb_plugin_url . 'public/assets/css/font-awesome-4.4.0/css/font-awesome.min.css',
			array(),
			$this->version,
			'all'
		);

		wp_enqueue_style(
			$this->plugin_name,
			$eb_plugin_url . 'admin/assets/css/eb-admin.css',
			array(),
			$this->version,
			'all'
		);
		wp_enqueue_style(
			'jquery-tiptip-css',
			$eb_plugin_url . 'admin/assets/css/tipTip.css',
			array(),
			$this->version,
			'all'
		);
		wp_enqueue_style(
			'eb-select2-css',
			$eb_plugin_url . 'admin/assets/css/select2.css',
			array(),
			$this->version,
			'all'
		);

		wp_enqueue_style(
			'eb-jquery-ui-css',
			$eb_plugin_url . 'admin/assets/css/jquery-ui.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function admin_enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Eb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		$eb_plugin_url = \app\wisdmlabs\edwiserBridge\wdm_edwiser_bridge_plugin_url();
		$sync_nonce    = wp_create_nonce( 'check_sync_action' );
		$admin_nonce   = wp_create_nonce( 'eb_admin_nonce' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-dialog' );

		wp_enqueue_script( 'iris' );

		wp_enqueue_script(
			$this->plugin_name,
			$eb_plugin_url . 'admin/assets/js/eb-admin.js',
			array( 'jquery', 'jquery-ui-dialog', 'jquery-ui-accordion', 'iris' ),
			$this->version,
			false
		);

		wp_enqueue_script(
			'eb-select2-js',
			$eb_plugin_url . 'admin/assets/js/select2.full.js',
			array( 'jquery' ),
			$this->version,
			false
		);

		/*
		 * translators: Link to open the unlink users list.
		 */
		$msg_unlink_user = sprintf( esc_html__( '%s to see list of unlinked users.', 'rdmcompas-moodle-connector' ), '<a href="#">' . esc_html__( '  Click', 'rdmcompas-moodle-connector' ) . '</a>' );
		wp_localize_script(
			$this->plugin_name,
			'eb_admin_js_object',
			array(
				'unsaved_warning'                 => esc_html__( 'Please save the changes.', 'rdmcompas-moodle-connector' ),
				'plugin_url'                      => $eb_plugin_url,
				'ajaxurl'                         => admin_url( 'admin-ajax.php' ),
				'nonce'                           => $sync_nonce,
				'admin_nonce'                     => $admin_nonce,
				'msg_con_success'                 => esc_html__( 'Connection successful, Please save your connection details.', 'rdmcompas-moodle-connector' ),
				'msg_courses_sync_success'        => esc_html__( 'Courses synchronized successfully.', 'rdmcompas-moodle-connector' ),
				'msg_con_prob'                    => esc_html__( 'There is a problem while connecting to moodle server.', 'rdmcompas-moodle-connector' ),
				'msg_err_users'                   => esc_html__( 'Error occured for following users: ', 'rdmcompas-moodle-connector' ),
				'msg_user_sync_success'           => esc_html__( 'User\'s course enrollment status synced successfully.', 'rdmcompas-moodle-connector' ),
				'msg_unlink_users_list'           => $msg_unlink_user,
				'msg_user_link_to_moodle_success' => esc_html__( 'User\'s linked to moodle successfully.', 'rdmcompas-moodle-connector' ),
				'msg_mail_delivery_fail'          => esc_html__( 'Mail delivery failed.', 'rdmcompas-moodle-connector' ),
				'msg_test_mail_sent_to'           => esc_html__( 'Test mail sent to ', 'rdmcompas-moodle-connector' ),
				'msg_err_parsing_res'             => esc_html__( 'An error occurred during parsing the response', 'rdmcompas-moodle-connector' ),
				'msg_cat_sync_success'            => esc_html__( 'Categories synchronized successfully.', 'rdmcompas-moodle-connector' ),
				'msg_tpl_not_found'               => esc_html__( 'Template not found', 'rdmcompas-moodle-connector' ),
				'msg_link_user'                   => esc_html__( 'Linked ', 'rdmcompas-moodle-connector' ),
				'msg_unlink_user'                 => esc_html__( 'Unlinked ', 'rdmcompas-moodle-connector' ),
				'msg_error_unlink_user'           => '<div>' . esc_html__( 'Sorry, unable to link user', 'rdmcompas-moodle-connector' ) . '<ol><li>' . esc_html__( 'Check if first name and last name of the user is empty.', 'rdmcompas-moodle-connector' ) . '</li><li>' . esc_html__( 'Please test Moodle connection.', 'rdmcompas-moodle-connector' ) . '</li></ol>' . esc_html__( 'To know more about this error please', 'rdmcompas-moodle-connector' ) . "<a target='_blank' href='https://edwiser.helpscoutdocs.com/collection/85-rdmcompas-moodle-connector-plugin'>" . esc_html__( ' click here', 'rdmcompas-moodle-connector' ) . '</a></div>',
				'msg_error_link_user'             => '<div>' . esc_html__( 'Sorry, unable to link user', 'rdmcompas-moodle-connector' ) . '<ol><li>' . esc_html__( 'Check if first name and last name of the user is empty.', 'rdmcompas-moodle-connector' ) . ' </li><li>' . esc_html__( 'Please test Moodle connection.', 'rdmcompas-moodle-connector' ) . '</li></ol>' . esc_html__( 'To know more about this error please ', 'rdmcompas-moodle-connector' ) . "<a target='_blank' href='https://edwiser.helpscoutdocs.com/collection/85-rdmcompas-moodle-connector-plugin'>" . esc_html__( ' click here', 'rdmcompas-moodle-connector' ) . '</a></div>',
				'msg_error_moodle_link'           => esc_html__( 'Sorry, unable to link to the moodle', 'rdmcompas-moodle-connector' ),
				'msg_confirm_refund'              => esc_html__( 'Do you want to refund for the order id: #', 'rdmcompas-moodle-connector' ),
				'eb_order_refund_nonce'           => wp_create_nonce( 'eb_order_refund_nons_field' ),
				'msg_refund_failed'               => esc_html__( 'Failed to refund the order', 'rdmcompas-moodle-connector' ),
				'edwiser_terms_title'             => esc_html__( 'Edwiser Terms and Conditions', 'rdmcompas-moodle-connector' ),
				'edwiser_terms_content'           => esc_html__( 'Edwiser extensions licensing system used to provide the latest stable code of the product as well as to check the renewals for this license at our end. For this purpose, we acquire the details like <b> " Site Name, IP Address " </b>and once the license gets deactivated or expires we won\'t get this information from your site. We need this information for giving you a seamless experience of selling Moodle courses through WordPress. Do hit the <b> "Agree" </b> button if you are ready to share these details with us. ', 'rdmcompas-moodle-connector' ),
			)
		);

		wp_enqueue_script(
			'jquery-tiptip-js',
			$eb_plugin_url . 'admin/assets/js/jquery.tipTip.minified.js',
			array( 'jquery' ),
			$this->version,
			false
		);
	}
}
