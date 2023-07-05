<?php

/**
 * @author      WALLReTuRn - Plamen Petrov
 *
 * @copyright   WebSiteToYou websitetoyou.cz
 */

namespace wstyepaf\Includes\Classes;

class Ep_Ajax_Filter_Install {

    public $registry;

    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;

        register_activation_hook(EP_FILE_URL, array($this, 'Ajax_Custom_Filter_Settings'));
        register_activation_hook(EP_FILE_URL, array($this, 'Ajax_Filter_General_Settings'));
        register_activation_hook(EP_FILE_URL, array($this, 'Ajax_Default_Filter_Settings'));
    }

    public function Ajax_Custom_Filter_Settings() {
        global $wpdb;
        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'ep_ajax_custom_filter_settings';
        $charset_collate = $wpdb->get_charset_collate();
        $check_table_exists = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

        if (!$wpdb->get_var($check_table_exists) == $table_name) {
            $sql = "CREATE TABLE $table_name (
                id int(255) NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL,
                slug varchar(255) NOT NULL,
                value varchar(255) NOT NULL,
                default_name varchar(255) NOT NULL,
                type varchar(255) NOT NULL,
                PRIMARY KEY (`id`))ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }
    }

    public function Ajax_Filter_General_Settings() {
        global $wpdb;
        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'ep_ajax_filter_general_settings';
        $charset_collate = $wpdb->get_charset_collate();
        $check_table_exists = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

        if (!$wpdb->get_var($check_table_exists) == $table_name) {
            $sql = "CREATE TABLE $table_name (
                settings_name varchar(255) NOT NULL,
                positions varchar(255) NOT NULL,
                filtertype tinyint(2) NOT NULL,
                visible varchar(255) NOT NULL,
                status tinyint(2) NOT NULL,
                UNIQUE KEY `settings_name` (`settings_name`))ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }

        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'ep_ajax_filter_general_settings';

        $data = array('settings_name' => 'general_settings', 'positions' => 'custom_position_of_ajax_filters', 'filtertype' => '0', 'visible' => '1', 'status' => '0');
        $format = array('%s', '%s', '%s', '%s', '%s');

        //$result = $wpdb->query($wpdb->prepare("UPDATE " . $table_name . " SET widget_name = '".$feature['feature_info']['Name']."', widget_install = '1', widget_path = '".$feature['feature_info']['PluginUrlAction']."', widget_status = '0' WHERE widget_path = '" . $feature['feature_info']['PluginUrlAction'] . "'"));
        //If nothing found to update, it will try and create the record.
        $Select = $wpdb->query($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE settings_name = 'general_settings'"));

        if ($Select !== 1) {
            $wpdb->insert($table_name, $data, $format);
        }
    }

    public function Ajax_Default_Filter_Settings() {

        global $wpdb;
        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'ep_ajax_default_filter_settings';
        $charset_collate = $wpdb->get_charset_collate();
        $check_table_exists = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

        if (!$wpdb->get_var($check_table_exists) == $table_name) {
            $sql = "CREATE TABLE $table_name (
              id int(255) NOT NULL AUTO_INCREMENT,
              attribute_name varchar(255) DEFAULT NULL,
              attribute_id int(2) NOT NULL,
              attribute_slug varchar(255) DEFAULT NULL,
              attribute_status int(2) DEFAULT NULL,
              PRIMARY KEY (`id`))ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }


        $query_args = array(
            'status' => 'publish',
            'post_type' => 'product',
            'order' => 'ASC',
            'orderby' => 'title'
        );
        $attributes = [];
        foreach (wc_get_products($query_args) as $product) {
            foreach ($product->get_attributes() as $taxonomy => $attribute) {
                $attribute_name = wc_attribute_label($taxonomy); // Attribute name
                // Or: 
                // $attribute_name = get_taxonomy( $taxonomy )->labels->singular_name;
                foreach ($attribute->get_terms() as $term) {
                    $attributes[$taxonomy][$term->term_id] = $term->name;
                    // Or with the product attribute label name instead:
                    // $data[$attribute_name][$term->term_id] = $term->name;
                }
            }
        }

        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'ep_ajax_default_filter_settings';

        foreach ($attributes as $key => $value):
            $data = array('attribute_name' => $key, 'attribute_slug' => $key, 'attribute_status' => '0');
            $format = array('%s', '%s', '%s');

            //$result = $wpdb->query($wpdb->prepare("UPDATE " . $table_name . " SET widget_name = '".$feature['feature_info']['Name']."', widget_install = '1', widget_path = '".$feature['feature_info']['PluginUrlAction']."', widget_status = '0' WHERE widget_path = '" . $feature['feature_info']['PluginUrlAction'] . "'"));
            //If nothing found to update, it will try and create the record.
            $Select = $wpdb->query($wpdb->prepare("SELECT * FROM " . $table_name . " WHERE attribute_name = '" . $key . "'"));

            if ($Select !== 1) {
                $wpdb->insert($table_name, $data, $format);
            }
        endforeach;
    }

}
