<?php

/**
 * Setup menus in WP admin.
 *
 * @package WooCommerce\Admin
 * @version 2.5.0
 */

namespace wstyepaf\Includes\Classes;

defined('ABSPATH') || exit;

if (class_exists('Ep_Ajax_Filter_Admin_Menus', false)) {
    return new Ep_Ajax_Filter_Admin_Menus();
}

/**
 * WC_Admin_Menus Class.
 */
class Ep_Ajax_Filter_Admin_Menus {

    public $registry;

    /**
     * Hook in tabs.
     */
    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;

        // Add menus.
        //add_action( 'admin_menu', array( $this, 'menu_highlight' ) );
        //add_action( 'admin_menu', array( $this, 'menu_order_count' ) );
        //add_action( 'admin_menu', array( $this, 'maybe_add_new_product_management_experience' ) );
        //add_action( 'admin_menu', array( $this, 'orders_menu' ), 9 );
        //add_action( 'admin_menu', array( $this, 'reports_menu' ), 20 );
        //add_action( 'admin_menu', array( $this, 'settings_menu' ), 50 );
        //add_action( 'admin_menu', array( $this, 'status_menu' ), 60 );
        //if ( apply_filters( 'woocommerce_show_addons_page', true ) ) {
        //	add_action( 'admin_menu', array( $this, 'addons_menu' ), 70 );
        //}
        //add_filter( 'menu_order', array( $this, 'menu_order' ) );
        //add_filter( 'custom_menu_order', array( $this, 'custom_menu_order' ) );
        //add_filter( 'set-screen-option', array( $this, 'set_screen_option' ), 10, 3 );
        // Add endpoints custom URLs in Appearance > Menus > Pages.
        //add_action( 'admin_head-nav-menus.php', array( $this, 'add_nav_menu_meta_boxes' ) );
        // Admin bar menus.
        //if ( apply_filters( 'woocommerce_show_admin_bar_visit_store', true ) ) {
        //	add_action( 'admin_bar_menu', array( $this, 'admin_bar_menus' ), 31 );
        //}
        // Handle saving settings earlier than load-{page} hook to avoid race conditions in conditional menus.
        //add_action( 'wp_loaded', array( $this, 'save_settings' ) );

        $this->ep_ajax_filter_runMenu();
    }

    public function ep_ajax_filter_runMenu() {
        add_action('admin_menu', array($this, 'ep_ajax_filter_admin_menu'), 9);
    }

    /**
     * Add menu items.
     */
    public function ep_ajax_filter_admin_menu() {
        global $wp_version;
        $dashboard = new Ep_Ajax_Filter_Execute_Page($this->registry);

        //$dashboard->index();
        // if ($wp_version <= 6):
        add_menu_page(__('Ep Ajax_Filter'), '<span style="font-weight: 800;background: -webkit-linear-gradient(45deg, #09009f, #687c74 80%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;margin: 0;">Ep Ajax_Filter</span>', 'manage_options', 'ep_ajax_filter_dashboard', array($dashboard, 'ep_ajax_filter_dashboard'), 'dashicons-pdf', '23');
        // else:
        //   add_menu_page(
        //           page_title: __('WBS ALL IN ONE'),
        //          menu_title: '<span style="color: orange;">WBS ALL IN ONE</span>',
        //          capability: 'manage_options',
        //         menu_slug: 'dashboard',
        //         callback: array($dashboard, 'dashboard'),
        //        icon_url: 'dashicons-pdf',
        //        position: '23'
        // );
        // endif;



        add_submenu_page('ep_ajax_filter_dashboard', 'Dashboard', 'Dashboard', 'manage_options', 'ep_ajax_filter_dashboard', array($dashboard, 'ep_ajax_filter_dashboard'));
        add_submenu_page('ep_ajax_filter_dashboard', 'Ajax-Filter', 'Ajax-Filter', 'manage_options', 'ep_ajax_filter_ajax-filter', array($dashboard, 'ep_ajax_filter_ajax_filter'));
        //add_submenu_page('dashboard', 'ShortCodes', 'ShortCodes', 'manage_options', 'shortcodes', array($dashboard, 'shortcodes'));
        //add_submenu_page('dashboard', 'Blocks', 'Blocks', 'manage_options', 'blocks', array($dashboard, 'blocks'));
        // add_submenu_page('dashboard', 'Feature', 'Feature', 'manage_options', 'feature', array($dashboard, 'feature'));
    }

}
