<?php

/**
 * WooCommerce Admin
 *
 * @class    WC_Admin
 * @package  WooCommerce\Admin
 * @version  2.6.0
 */

namespace wstyepaf\Includes\Classes;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * WC_Admin class.
 */
class Ep_Ajax_Filter_Admin {

    public $registry;

    /**
     * Constructor.
     */
    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;
        add_action('init', array($this, 'includes'));
        add_action('admin_head', array($this, 'header_scripts'));
    }

    /**
     * Output buffering allows admin screens to make redirects later on.
     */
    public function buffer() {
        ob_start();
    }

    /**
     * Include any classes we need within admin.
     */
    public function includes() {


        //$this->registry->AdminMenu->runMenu();
    }

    function header_scripts() {




        wp_enqueue_script('jquery-ui-datepicker');

        wp_enqueue_script('jquery-ui-accordion');

        wp_enqueue_media();

        wp_enqueue_style('ep-ajax-filter-admin-bootstrap', EP_PLUGIN_URL . 'assets/css/bootstrap-5.2.3-dist/css/bootstrap.min.css');

        wp_enqueue_style('ep-ajax-filter-admin-style', EP_PLUGIN_URL . 'assets/css/admin_style.css');

        wp_enqueue_script('ep-ajax-filter-bootstrap-js', EP_PLUGIN_URL . 'assets/css/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js', array('jquery'));
        wp_enqueue_script('ep-ajax-filter-bootstrap-bundle-js', EP_PLUGIN_URL . 'assets/css/bootstrap-5.2.3-dist/js/bootstrap.min.js', array('jquery'));
        wp_enqueue_script('ep-ajax-filter-script', EP_PLUGIN_URL . 'assets/js/ep-ajax-filter-common.js', array('jquery'));
    }

}

//return new WbsAllInOne_Admin();
