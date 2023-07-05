<?php

/**
 * Plugins Name: Portfolie Gallery
 * Description: Portfolie Gallery
 * Author: WALLReTuRn
 * PluginUrlAction: shortcodes_portfoliegallery
 * Dashicons: dashicons-text-page
 * Author URI: https://websitetoyou.cz
 * Version: 1.0
 * License: GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */
/**
 * @author      WALLReTuRn - Plamen Petrov
 *
 * @copyright   WebSiteToYou websitetoyou.cz
 */

namespace wstyepaf\Includes\Controller\Common;

class Menu {

    public $registry;
    public $menu;

    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->menu = [
            'menu 1' => ['name' => 'Head Cat', 'href' => $this->changemenuurlparameter('shortcodes_portfoliegallery_headcat')],
            'menu 2' => ['name' => 'SUB Cat', 'href' => $this->changemenuurlparameter('shortcodes_portfoliegallery_subcat')]
        ];
        $this->registry = $registry;
        // new PortfolieGalleryBackendHook($this->registry);
    }

    public function changemenuurlparameter($value) {
        $params = $_GET;
        unset($params['action']);
        $params['action'] = $value;
        $new_query_string = http_build_query($params);
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) . '?' . $new_query_string;
    }

    public function index() {

        $data = [];
        $data['Menus'] = $this->menu;

        return $this->registry->template->render('shortcodes/portfoliegallery/back/menu', $data);
    }

}
