<?php

/**
 * @author      WALLReTuRn - Plamen Petrov
 *
 * @copyright   WebSiteToYou websitetoyou.cz
 */

namespace wstyepaf\Includes\Controller\Common;

class Header {

    public $registry;

    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;
    }

    public function index() {
        $data['asssss'] = '123';
       
        return $this->registry->template->render('common/header', $data);
      
    }

}
