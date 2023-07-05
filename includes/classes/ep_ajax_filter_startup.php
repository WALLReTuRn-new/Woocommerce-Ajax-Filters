<?php

/*
 * WebSiteToYou License
 * Each line should be prefixed with  * 
 */

namespace wstyepaf\Includes\Classes;

if (class_exists('epstartup', false)) {
    return new Startup();
}

class EpStartup {

    public function __construct() {
        
    }

    public function start() {


        add_filter('action_scheduler_pastdue_actions_check_pre', '__return_false');

        //Including Custom Loader
        require EP_PLUGIN_DIR . 'includes/classes/ep_ajax_filter_autoloader.php';
        $autoloader = new Ep_Ajax_Filter_Autoloader();

        //Including Register
        require EP_PLUGIN_DIR . 'includes/classes/ep_ajax_filter_registry.php';

        //Including Vendor loader for Composser Packs
        require EP_PLUGIN_DIR . 'includes/classes/vendor_loader.php';

        //Create Registry and Make Loading System
        $registry = new \wstyepaf\Includes\Classes\EpRegistry();
        $registry->set('autoloader', $autoloader);

        //Loading Controller
        $loadingController = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Loadingcontroller($registry);
        $registry->set('loading', $loadingController);

        //Check for Update - Проверява за нова версия на плъгина
        
         $checkupdate = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Checkforupdate($registry);
        //Информация за плъгина
        //Check for Update
        // $pluginInformation = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Informations($registry);
        
        //Всичко необходимо за да се инсталира
        //Including Install
        $install = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Install($registry);
        
        
        //Hook Ajax Function
        require EP_PLUGIN_DIR . 'includes/classes/ep_ajax_filter_ajax_hook.php';

        //Работа с Twig Template за по бърза и съкратена работа.
        //Twig Template
        // Registry
        $template = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Template($registry);
        $registry->set('template', $template);

        //Създава Аминистративното меню в WordPress
        //Create Admin Menu
        $AdminMenu = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Admin_Menus($registry);
        $registry->set('AdminMenu', $AdminMenu);

        //create Admin
        $Admin = new \wstyepaf\Includes\Classes\Ep_Ajax_Filter_Admin($registry);
        $registry->set('Admin', $Admin);

        include EP_PLUGIN_DIR . 'includes/classes/ep_ajax_filter_widgets.php';
    }

}
