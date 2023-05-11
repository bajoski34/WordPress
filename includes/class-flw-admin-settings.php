<?php
/**
 * Adming Settings Page Class
 *
 * @package Flutterwave_Payments
 */

defined( 'ABSPATH' ) || exit;


/**
* Admin Settings class
*/
class FLW_Admin_Settings {

  /**
   * Class instance
   * @var $instance
   */
  public static $instance = null;

  /**
   * Admin options array
   *
   * @var array
   */
  protected $options;

  /**
   * Class constructor
   */
  private function __construct() {
    add_action( 'admin_menu', array( $this, 'flw_rave_add_admin_menu' ) );
    add_action( 'admin_init', array( $this, 'flw_rave_register_settings' ) );
    $this->init_settings();

  }

  /**
   * Registers admin setting
   *
   * @return void
   */
  public function flw_rave_register_settings() {

    register_setting( 'flw-rave-settings-group', 'flw_rave_options' );

  }

  private function init_settings() {

    if ( false == get_option( 'flw_rave_options' ) ) {
      update_option( 'flw_rave_options', array() );
    }

  }

  /**
   * Fetches admin option settings from the db.
   *
   * @param $attr
   *
   * @return mixed           The value of the option fetched.
   */
  public function get_option_value( $attr ) {

    $options = get_option( 'flw_rave_options' );

    if ( array_key_exists($attr, $options) ) {

      return $options[$attr];

    }

    return '';

  }

  /**
   * Checks if public key has been set
   *
   * @return boolean
   */
  public function is_public_key_present() {

    $options = get_option( 'flw_rave_options' );

    if ( false == $options ) return false;

    return array_key_exists( 'public_key', $options ) && ! empty( $options['public_key'] );

  }

  /**
   * Get the instance of the class
   *
   * @return object   An instance of this class
   */
  public static function get_instance() {

    if ( null == self::$instance ) {

      self::$instance = new self;

    }

    return self::$instance;

  }

  /**
   * Add admin menu
   * @return void
   */
  public function flw_rave_add_admin_menu() {

    add_menu_page(
      __( 'Settings Page', 'flutterwave-payments' ),
      'Flutterwave',
      'manage_options',
      'flutterwave-payments',
      array( __CLASS__, 'flw_rave_admin_setting_page' ),
      FLW_DIR_URL . 'assets/images/old-logo.svg',
      58
    );

    add_submenu_page(
      'flutterwave-payments',
      __( 'Flutterwave Payments Settings', 'flutterwave-payments' ),
      __( 'Settings', 'flutterwave' ),
      'manage_options',
      'flutterwave-payments-settings',
      array( __CLASS__, 'flw_rave_admin_setting_page' )
    );

  }

  /**
   * Admin page content
   * @return void
   */
  public static function flw_rave_admin_setting_page() {

    include_once dirname(FLW_PAY_PLUGIN_FILE ). '/views/admin-settings-page.php';

  }
}
