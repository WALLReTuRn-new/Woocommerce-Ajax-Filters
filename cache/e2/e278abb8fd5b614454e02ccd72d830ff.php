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

/* Ajaxfilters.twig */
class __TwigTemplate_ac92e07768de3464c20b50d35a242e1d extends \Twig\Template
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
<div class=\"container\">

    <div class=\"invalid-feedback\"></div>
    <div class=\"valid-feedback\"></div>
    <form  id=\"UA\" class=\"form-horizontal\">

        <div class=\"row\">

            ";
        // line 11
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["attributes"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["attribute"]) {
            // line 12
            echo "



                <div class=\"form-group col-md-6\">
                    <label for=\"inputCity\">";
            // line 17
            echo twig_get_attribute($this->env, $this->source, $context["attribute"], "attributes_key", [], "any", false, false, false, 17);
            echo "</label>
                    <input type=\"text\"  class=\"form-control\" id=\"inputCity\" value=\"";
            // line 18
            echo twig_get_attribute($this->env, $this->source, $context["attribute"], "attributes_key", [], "any", false, false, false, 18);
            echo "\" disabled>
                </div>
                <div class=\"form-group col-md-4\">
                    <label for=\"inputState\">State</label>
                    <select name=\"status[";
            // line 22
            echo twig_get_attribute($this->env, $this->source, $context["attribute"], "attributes_key", [], "any", false, false, false, 22);
            echo "]\" id=\"inputState\" class=\"form-control\" data-status-color=\"";
            echo twig_get_attribute($this->env, $this->source, $context["attribute"], "attributes_status", [], "any", false, false, false, 22);
            echo "\">
                        ";
            // line 23
            if ((twig_get_attribute($this->env, $this->source, $context["attribute"], "attributes_status", [], "any", false, false, false, 23) == 1)) {
                // line 24
                echo "                            <option value=\"1\" selected>Yes</option>
                            <option value=\"0\" >No</option>
                        ";
            } else {
                // line 27
                echo "                            <option value=\"1\" >Yes</option>
                            <option value=\"0\" selected>No</option>
                        ";
            }
            // line 30
            echo "

                    </select>
                </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attribute'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 35
        echo "        </div>  
    </form>
    <input id=\"update-attributes\" class=\"form-control button-primary\" form=\"UA\" type=\"button\" name=\"Update Attributes\" value=\"Save\">
</div>
";
        // line 39
        echo ($context["footer"] ?? null);
    }

    public function getTemplateName()
    {
        return "Ajaxfilters.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 39,  99 => 35,  89 => 30,  84 => 27,  79 => 24,  77 => 23,  71 => 22,  64 => 18,  60 => 17,  53 => 12,  49 => 11,  37 => 2,);
    }

    public function getSourceContext()
    {
        return new Source("", "Ajaxfilters.twig", "/www/doc/www.websitetoyou.cz/www/WordPress/wp-content/plugins/ep-ajax-filter/includes/view/Ajaxfilters.twig");
    }
}
