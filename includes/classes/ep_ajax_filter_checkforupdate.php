<?php

/*
 * WebSiteToYou License
 * Each line should be prefixed with  * 
 */

namespace wstyepaf\Includes\Classes;

class Ep_Ajax_Filter_Checkforupdate {

    public $registry;
    public $plugin_slug;
    public $version;
    public $cache_key;
    public $cache_allowed;

    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;

        // $this->plugin_slug = plugin_basename(__DIR__);
        $this->plugin_slug = EP_SHORT_NAME;
        $this->version = EP_PLUGIN_VERSION;
        $this->cache_key = EP_SHORT_NAME;
        $this->cache_allowed = false;

        // $this->checkDB();

        add_filter('plugins_api', array($this, 'ep_ajax_filter_info'), 21, 3);
        add_filter('site_transient_update_plugins', array($this, 'ep_ajax_filter_update'));
        add_action('upgrader_process_complete', array($this, 'ep_ajax_filter_purge'), 10, 2);
        
       
    }

    public function ep_ajax_filter_request() {



        $remote = get_transient($this->cache_key);

        if (false === $remote || !$this->cache_allowed) {

           
            $remote = wp_remote_get(
                    'https://www.websitetoyou.cz/index.php?route=wordpress/plugins&plugin_action=plugin_info&slug=' . $this->plugin_slug,
                    array(
                        'timeout' => 10,
                        'headers' => array(
                            'Accept' => 'application/json'
                        )
                    )
            );
            
            

            if (
                    is_wp_error($remote) || 200 !== wp_remote_retrieve_response_code($remote) || empty(wp_remote_retrieve_body($remote))
            ) {
                return false;
            }

            set_transient($this->cache_key, $remote, DAY_IN_SECONDS);
        }

        $remote = json_decode(wp_remote_retrieve_body($remote));

        return $remote;
    }

    function ep_ajax_filter_info($res, $action, $args) {
        
        



        // do nothing if you're not getting plugin information right now
        if ('plugin_information' !== $action) {
         //     return false;
        }


        // do nothing if it is not our plugin
        if ($this->plugin_slug !== $args->slug) {
          //    return false;
        }

        // get updates
        $remote = $this->ep_ajax_filter_request();

        if (!$remote) {
          //    return false;
        }

        $res = new \stdClass();

        $res->name = $remote->name;
        $res->slug = $remote->slug;
        $res->version = $remote->version;
        $res->tested = $remote->tested;
        $res->requires = $remote->requires;
        $res->author = $remote->author;
        $res->author_profile = $remote->author_profile;
        $res->download_link = $remote->download_url;
        $res->trunk = $remote->download_url;
        $res->requires_php = $remote->requires_php;
        $res->last_updated = $remote->last_updated;

        $res->sections = array(
            'description' => $remote->sections->description,
            'installation' => $remote->sections->installation,
            'changelog' => $remote->sections->changelog
        );

        if (!empty($remote->banners)) {
            $res->banners = array(
                'low' => $remote->banners->low,
                'high' => $remote->banners->high
            );
        }


        return $res;
    }

    public function ep_ajax_filter_update($transient) {


        if (empty($transient->checked)) {
            return $transient;
        }

        $remote = $this->ep_ajax_filter_request();

        if (
                $remote && version_compare($this->version, $remote->version, '<') && version_compare($remote->requires, get_bloginfo('version'), '<') && version_compare($remote->requires_php, PHP_VERSION, '<')
        ) {
            $res = new \stdClass();
            $res->slug = $this->plugin_slug;
            $res->plugin = EP_SHORT_NAME . '/' . EP_SHORT_NAME . '.php'; // version/wbsallinone.php
            $res->new_version = $remote->version;
            $res->tested = $remote->tested;
            $res->package = $remote->download_url;

            $transient->response[$res->plugin] = $res;
        }

        return $transient;
        
        
    }

    public function ep_ajax_filter_purge() {

        if (
                $this->cache_allowed && 'update' === $options['action'] && 'plugin' === $options['type']
        ) {
            // just clean the cache when new plugin version is installed
            delete_transient($this->cache_key);
        }
    }

    public function ep_ajax_filter_checkDB() {
        global $wpdb;
        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'wbsallinone_widget';
        $charset_collate = $wpdb->get_charset_collate();
        $check_table_exists = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

        if (!$wpdb->get_var($check_table_exists) == $table_name) {
            $sql = "CREATE TABLE $table_name (
              widget_id int(100) NOT NULL AUTO_INCREMENT,
              widget_name varchar(255) DEFAULT NULL,
              widget_install int(2) NOT NULL,
              widget_path varchar(255) DEFAULT NULL,
              widget_status int(2) DEFAULT NULL,
              PRIMARY KEY (`widget_id`),
              UNIQUE KEY `widget_name` (`widget_name`))ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }

        global $wpdb;
        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'wbsallinone_shortcodes';
        $charset_collate = $wpdb->get_charset_collate();
        $check_table_exists = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

        if (!$wpdb->get_var($check_table_exists) == $table_name) {
            $sql = "CREATE TABLE $table_name (
                shortcode_id int(100) NOT NULL AUTO_INCREMENT,
                shortcode_name varchar(255) DEFAULT NULL,
                shortcode_install int(2) NOT NULL,
                shortcode_path varchar(255) DEFAULT NULL,
                shortcode_status int(2) DEFAULT NULL,
                PRIMARY KEY (`shortcode_id`),
                UNIQUE KEY `shortcode_name` (`shortcode_name`))ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }
        global $wpdb;
        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'wbsallinone_blocks';
        $charset_collate = $wpdb->get_charset_collate();
        $check_table_exists = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

        if (!$wpdb->get_var($check_table_exists) == $table_name) {
            $sql = "CREATE TABLE $table_name (
                block_id  int(100) NOT NULL AUTO_INCREMENT,
                block_name VARCHAR(255) UNIQUE,
		block_path VARCHAR(255) DEFAULT NULL,
		block_status int(2)DEFAULT NULL,
		PRIMARY KEY  (block_id))";
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }
        global $wpdb;
        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'wbsallinone_notes';
        $charset_collate = $wpdb->get_charset_collate();
        $check_table_exists = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

        if (!$wpdb->get_var($check_table_exists) == $table_name) {
            $sql = "CREATE TABLE $table_name (
                notes_id  int(10) NOT NULL AUTO_INCREMENT,
                notes_name VARCHAR(255) UNIQUE,
		notes_designation VARCHAR(100) DEFAULT NULL,
		notes_type VARCHAR(100)DEFAULT NULL,
                notes_description varchar(255) DEFAULT NULL,
		PRIMARY KEY  (notes_id) )";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }
        global $wpdb;
        $wpdb->show_errors(true);
        $table_name = $wpdb->prefix . 'wbsallinone_preload';
        $charset_collate = $wpdb->get_charset_collate();
        $check_table_exists = $wpdb->prepare('SHOW TABLES LIKE %s', $wpdb->esc_like($table_name));

        if (!$wpdb->get_var($check_table_exists) == $table_name) {
            $sql = "CREATE TABLE $table_name (
                preload_id  int(10) NOT NULL AUTO_INCREMENT,
                preload_url VARCHAR(255) UNIQUE,
		type VARCHAR(255),
		font_type VARCHAR(255),
                preload_status int(2),
                preload_speed VARCHAR(255),
		PRIMARY KEY  (preload_id) )";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta($sql);
        }
    }

}
