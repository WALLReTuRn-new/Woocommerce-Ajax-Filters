<?php
/**
 * @package epajaxfilter
 */
/**
 * Plugin Name: WebSiteToYou Expert Project ajax-filter
 * Plugin URI:  https://websitetoyou.cz/
 * Description: Woocommerce Ajax Filter.
 * Author: WALLReTuRn
 * Author URI: https://websitetoyou.cz
 * Text Domain: epajaxfilter
 * Requires PHP: 7.4
 * Version: 2.2
 * License: GNU General Public License v3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

define('EP_SHORT_NAME', 'epajaxfilter');
define('EP_PLUGIN_VERSION', '2.2');
define('EP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('EP_FILE_URL', __FILE__);
define('EP_PLUGIN_URL', plugin_dir_url(__FILE__));
//define('EP_FEATURE_DIR', plugin_dir_path(__FILE__) . 'includes/controller/feature');
//define('EP_SHORTCODES_DIR', plugin_dir_path(__FILE__) . 'includes/controller/shortcodes');

require_once EP_PLUGIN_DIR . 'includes/classes/ep_ajax_filter_startup.php';

$start = new wstyepaf\Includes\Classes\EpStartup();
$start->start();


