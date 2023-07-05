<?php

/**
 * @author      WALLReTuRn - Plamen Petrov
 *
 * @copyright   WebSiteToYou websitetoyou.cz
 */

namespace wstyepaf\Includes\Classes;

class Ep_Ajax_Filter_Template {

    public $registry;

    function __construct(\wstyepaf\Includes\Classes\EpRegistry $registry) {
        $this->registry = $registry;
    }

    function render(string $route, array $data = [], string $code = '') {
        $twig = new \Twig\Loader\FilesystemLoader(EP_PLUGIN_DIR . 'includes/view');

        $twig = new \Twig\Environment($twig, [
            'charset' => 'utf-8',
            'autoescape' => false,
            'debug' => false,
            'auto_reload' => true,
            'cache' => EP_PLUGIN_DIR . 'cache'
        ]);

        return $twig->render($route . '.twig', $data);
    }

}
