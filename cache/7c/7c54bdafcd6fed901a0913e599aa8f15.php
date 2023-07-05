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

/* common/footer.twig */
class __TwigTemplate_593fe180c629542a5238e6194260629a extends \Twig\Template
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
        echo "<footer >
       <div class=\"row justify-content-center mb-0 pt-5 pb-0 row-2 px-3\">
           <div class=\"col-12\">
                <div class=\"row row-2\">
                   <!-- <div class=\"col-sm-3 text-md-center\"><h5><span> <i class=\"fa fa-firefox text-light\" aria-hidden=\"true\"></i></span><b>  Stride</b></h5></div>
                    <div class=\"col-sm-3  my-sm-0 mt-5\"><ul class=\"list-unstyled\"><li class=\"mt-0\">Platform</li><li>Help Center</li><li>Security</li></ul></div>
                    <div class=\"col-sm-3  my-sm-0 mt-5\"><ul class=\"list-unstyled\"><li class=\"mt-0\">Customers</li><li>Use Cases</li><li>Customers Services</li></ul></div>
                    <div class=\"col-sm-3  my-sm-0 mt-5\"><ul class=\"list-unstyled\"><li class=\"mt-0\">Company</li><li>About</li><li>Careers- <span class=\"Careers\">We're-hiring</span></li></ul></div>-->
                </div>  
           </div>
       </div>
       <div class=\"row justify-content-center mt-0 pt-0 row-1 mb-0  px-sm-3 px-2\">
            <div class=\"col-12\">
                <div class=\"row my-4 row-1 no-gutters\">
                    <div class=\"col-sm-3 col-auto text-center\"><small>&#9400; Expert Project</small></div><div class=\"col-md-3 col-auto \"></div><div class=\"col-md-3 col-auto\"></div>
                    <div class=\"col-sm-3 col-auto text-center\"><small>Version v0.2.0</small></div><div class=\"col-md-3 col-auto \"></div><div class=\"col-md-3 col-auto\"></div>
                    <div class=\"col  my-auto text-md-left  text-right \"> <small> dev@websitetoyou.cz <span><img src=\"https://i.imgur.com/TtB6MDc.png\" class=\"img-fluid \"  width=\"25\"></span> <span><img src=\"https://i.imgur.com/N90KDYM.png\" class=\"img-fluid \"  width=\"25\"></span></small>  </div> 
                </div>
            </div>
        </div>
    </footer>
</div>
<!-- Modal -->
<div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" aria-labelledby=\"exampleModalLabel\" aria-hidden=\"true\">
  <div class=\"modal-dialog\">
    <div class=\"modal-content\">
      <div class=\"modal-header\">
        <h1 class=\"modal-title fs-5\" id=\"exampleModalLabel\">Help Center</h1>
        <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
      </div>
      <div class=\"modal-body\">
        By button Add File, select the file you want to add to the email as an attachment from the library.
        After only you need Click on Save Button.Check where as show attach file.
      </div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-danger\" data-bs-dismiss=\"modal\">Enjoy!!!!!!!!!</button>
      </div>
    </div>
  </div>
</div>


";
    }

    public function getTemplateName()
    {
        return "common/footer.twig";
    }

    public function getDebugInfo()
    {
        return array (  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "common/footer.twig", "/www/doc/www.websitetoyou.cz/www/WordPress/wp-content/plugins/ep-ajax-filter/includes/view/common/footer.twig");
    }
}
