<?php

/* base.html.twig */
class __TwigTemplate_00f8a28e32431f1c89f842eb155c6ce972db24f308d87c8f2fff8f488c87eb1d extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_d73da57a029d0750def0081c7aceaf0139883c34811c224d7e9cc74d73db3aa4 = $this->env->getExtension("native_profiler");
        $__internal_d73da57a029d0750def0081c7aceaf0139883c34811c224d7e9cc74d73db3aa4->enter($__internal_d73da57a029d0750def0081c7aceaf0139883c34811c224d7e9cc74d73db3aa4_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "base.html.twig"));

        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('asset')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 10
        $this->displayBlock('body', $context, $blocks);
        // line 11
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 12
        echo "    </body>
</html>
";
        
        $__internal_d73da57a029d0750def0081c7aceaf0139883c34811c224d7e9cc74d73db3aa4->leave($__internal_d73da57a029d0750def0081c7aceaf0139883c34811c224d7e9cc74d73db3aa4_prof);

    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        $__internal_4f4d54d5c91176344aa807c27cdc9a3eeb5ab286a7ebf1ca097beb7541622a3f = $this->env->getExtension("native_profiler");
        $__internal_4f4d54d5c91176344aa807c27cdc9a3eeb5ab286a7ebf1ca097beb7541622a3f->enter($__internal_4f4d54d5c91176344aa807c27cdc9a3eeb5ab286a7ebf1ca097beb7541622a3f_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        echo "Welcome!";
        
        $__internal_4f4d54d5c91176344aa807c27cdc9a3eeb5ab286a7ebf1ca097beb7541622a3f->leave($__internal_4f4d54d5c91176344aa807c27cdc9a3eeb5ab286a7ebf1ca097beb7541622a3f_prof);

    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
        $__internal_ad1b3ba5391cdd3db74900474815a534f98cb64becf51d50bd254cde10d63880 = $this->env->getExtension("native_profiler");
        $__internal_ad1b3ba5391cdd3db74900474815a534f98cb64becf51d50bd254cde10d63880->enter($__internal_ad1b3ba5391cdd3db74900474815a534f98cb64becf51d50bd254cde10d63880_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "stylesheets"));

        
        $__internal_ad1b3ba5391cdd3db74900474815a534f98cb64becf51d50bd254cde10d63880->leave($__internal_ad1b3ba5391cdd3db74900474815a534f98cb64becf51d50bd254cde10d63880_prof);

    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
        $__internal_088760670b785f48b6be4cbf4c34a1482c016e5ce6aea93d7e9dab381a85c2c2 = $this->env->getExtension("native_profiler");
        $__internal_088760670b785f48b6be4cbf4c34a1482c016e5ce6aea93d7e9dab381a85c2c2->enter($__internal_088760670b785f48b6be4cbf4c34a1482c016e5ce6aea93d7e9dab381a85c2c2_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        
        $__internal_088760670b785f48b6be4cbf4c34a1482c016e5ce6aea93d7e9dab381a85c2c2->leave($__internal_088760670b785f48b6be4cbf4c34a1482c016e5ce6aea93d7e9dab381a85c2c2_prof);

    }

    // line 11
    public function block_javascripts($context, array $blocks = array())
    {
        $__internal_8f7726a5f47699e478e7b43f0f5fb20f79808221d6c04a93ccd69d6625190491 = $this->env->getExtension("native_profiler");
        $__internal_8f7726a5f47699e478e7b43f0f5fb20f79808221d6c04a93ccd69d6625190491->enter($__internal_8f7726a5f47699e478e7b43f0f5fb20f79808221d6c04a93ccd69d6625190491_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "javascripts"));

        
        $__internal_8f7726a5f47699e478e7b43f0f5fb20f79808221d6c04a93ccd69d6625190491->leave($__internal_8f7726a5f47699e478e7b43f0f5fb20f79808221d6c04a93ccd69d6625190491_prof);

    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 11,  82 => 10,  71 => 6,  59 => 5,  50 => 12,  47 => 11,  45 => 10,  38 => 7,  36 => 6,  32 => 5,  26 => 1,);
    }
}
/* <!DOCTYPE html>*/
/* <html>*/
/*     <head>*/
/*         <meta charset="UTF-8" />*/
/*         <title>{% block title %}Welcome!{% endblock %}</title>*/
/*         {% block stylesheets %}{% endblock %}*/
/*         <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />*/
/*     </head>*/
/*     <body>*/
/*         {% block body %}{% endblock %}*/
/*         {% block javascripts %}{% endblock %}*/
/*     </body>*/
/* </html>*/
/* */
