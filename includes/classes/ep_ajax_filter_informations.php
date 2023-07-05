<?php

/*
 * WebSiteToYou License
 * Each line should be prefixed with  * 
 */

namespace wstyepaf\Includes\Classes;

defined('ABSPATH') || exit;

class Ep_Ajax_Filter_Informations {

    public $registry;
    public $plugin_slug;
    public $version;
    public $cache_key;
    public $cache_allowed;
    public $mypluginslug;

    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;

        // $this->plugin_slug = plugin_basename(__DIR__);
        $this->plugin_slug = EP_SHORT_NAME;
        $this->version = EP_PLUGIN_VERSION;
        $this->cache_key = EP_SHORT_NAME;
        $this->cache_allowed = false;
        if (is_admin()) {

          // add_filter('plugin_action_links', array($this, 'ep_ajax_filter_plugin_links'), 10, 3);
          //  add_filter('plugin_row_meta', array($this, 'ep_ajax_filter_plugin_links'), 10, 4);
            //add_filter('plugins_api', array($this, 'ep_ajax_filter_info'), 20, 3);
        }
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
            return false;
        }




        // do nothing if it is not our plugin
        if ($this->plugin_slug !== $args->slug) {
            return false;
        }

        // get updates
        $remote = $this->ep_ajax_filter_request();

        if (!$remote) {
            return false;
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

    public function ep_ajax_filter_plugin_links($links, $plugin_file, $plugin_data) {





        if (isset($plugin_data['PluginURI'])) {

           

            $slug = $this->plugin_slug;
            
            print_r($slug);

            $links[] = sprintf('<a href="%s" class="thickbox" title="%s">%s</a>',
                    self_admin_url('plugin-install.php?tab=plugin-information&plugin=' . $slug . '&TB_iframe=true&width=772&height=505'),
                    esc_attr(sprintf(__('More information about %s'), $plugin_data['Name'])),
                    __('View Details')
            );
        }

        return $links;
    }

}
