<?php

/**
 * @author      WALLReTuRn - Plamen Petrov
 *
 * @copyright   WebSiteToYou websitetoyou.cz
 */

namespace wstyepaf\Includes\Controller\Common;

class Dashboard {

    public $registry;

    public function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;
    }

    public function index() {
        $data['asssss'] = '123';

        $data['header'] = $this->registry->loading->Ep_Ajax_Filter_loadingController('controller/common/Header');
        $data['footer'] = $this->registry->loading->Ep_Ajax_Filter_loadingController('controller/common/Footer');

        echo $this->registry->template->render('common/dashboard', $data);
    }

}
