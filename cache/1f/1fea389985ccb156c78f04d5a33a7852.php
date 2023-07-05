<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* common/header.twig */
class __TwigTemplate_3b1992bbc76d2520a608e0ff36d5787c extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "
<div class=\"container-fluid\">
    <script src=\"https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js\"></script> 
    <section class=\"section home-5-bg\" id=\"home\">
        <div id=\"particles-js\"></div>
        <div class=\"bg-overlay\"></div>
        <div class=\"home-center\">
            <div class=\"home-desc-center\">
                <div class=\"container\">
                    <div class=\"justify-content-center row\">
                        <div class=\"col-lg-7\">
                            <div class=\"mt-40 text-center home-5-content\">
                                <div class=\"home-icon mb-4\"><i class=\"mdi mdi-pinwheel mdi-spin text-white h1\"></i></div>
                                <h3 class=\"text-white font-weight-normal home-5-title mb-0\">EP Woocommerce ajax Filter</h3>
                                <p class=\"text-white-70 mt-4 f-15 mb-0\"><a href=\"https://websitetoyou.cz\" target=\"_blank\">Plugin Home</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


";
    }

    public function getTemplateName()
    {
        return "common/header.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/header.twig", "/www/doc/www.websitetoyou.cz/www/WordPress/wp-content/plugins/ep-ajax-filter/includes/view/common/header.twig");
    }
}
