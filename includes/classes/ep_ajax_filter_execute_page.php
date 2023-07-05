<?php

/**
 * @author      WALLReTuRn - Plamen Petrov
 *
 * @copyright   WebSiteToYou websitetoyou.cz
 */

namespace wstyepaf\Includes\Classes;

class Ep_Ajax_Filter_Execute_Page {

    public $registry;
    public $route;
    public $class;

    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {

        $this->registry = $registry;
    }

    public function ep_ajax_filter_dashboard() {
        $this->registry->loading->Ep_Ajax_Filter_loadingController('controller/common/Dashboard');
    }
   
    
    public function ep_ajax_filter_ajax_filter(){
        $this->registry->loading->Ep_Ajax_Filter_loadingController('controller/ajax-filters'); 
    }
   

}
