<?php

/**
 * Includes the composer Autoloader used for packages and classes in the src/ directory.
 */

namespace wstyepaf\Includes\Classes;

defined('ABSPATH') || exit;

/**
 * Autoloader class.
 *
 * @since 3.7.0
 */
class Ep_Ajax_Filter_Autoloader {

    /**
     * Static-only class.
     */
    public function __construct() {
        spl_autoload_extensions('.php');
        spl_autoload_register([$this, 'loadingEpAjaxFilter']);
        
      
    }

    public function loadingEpAjaxFilter($class) {



        $file = EP_PLUGIN_DIR . strstr(strtolower(str_replace("\\", "/", $class)), '/') . '.php';

        if (isset($file) && is_file($file)):
            include_once($file);

            return true;
        else:
            return false;
        endif;
    }

}
