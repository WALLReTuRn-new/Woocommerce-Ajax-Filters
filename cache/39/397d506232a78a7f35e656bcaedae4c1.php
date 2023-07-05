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

/* common/dashboard.twig */
class __TwigTemplate_f7c0c97a1e839f6e0ce300e97cada5a2 extends \Twig\Template
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
        // line 2
        echo ($context["header"] ?? null);
        echo "
<button id=\"test_ajax\" type=\"submit\" class=\"btn btn-success mb-3\">TEST</button>
";
        // line 4
        echo ($context["footer"] ?? null);
    }

    public function getTemplateName()
    {
        return "common/dashboard.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  42 => 4,  37 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/dashboard.twig", "/www/doc/www.websitetoyou.cz/www/WordPress/wp-content/plugins/ep-ajax-filter/includes/view/common/dashboard.twig");
    }
}
