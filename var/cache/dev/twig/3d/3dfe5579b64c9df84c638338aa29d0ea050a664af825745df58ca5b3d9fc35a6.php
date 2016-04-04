<?php

/* @Twig/Exception/exception_full.html.twig */
class __TwigTemplate_5586661035a7724313a68a66fd10bf2dc4f899ea88c5efd2e3a7525a311cc7e7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@Twig/layout.html.twig", "@Twig/Exception/exception_full.html.twig", 1);
        $this->blocks = array(
            'head' => array($this, 'block_head'),
            'title' => array($this, 'block_title'),
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@Twig/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_7956acd95372923330edf03cc2c5dbec25ad56c581cc30a60529d7d6ce9282fc = $this->env->getExtension("native_profiler");
        $__internal_7956acd95372923330edf03cc2c5dbec25ad56c581cc30a60529d7d6ce9282fc->enter($__internal_7956acd95372923330edf03cc2c5dbec25ad56c581cc30a60529d7d6ce9282fc_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@Twig/Exception/exception_full.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_7956acd95372923330edf03cc2c5dbec25ad56c581cc30a60529d7d6ce9282fc->leave($__internal_7956acd95372923330edf03cc2c5dbec25ad56c581cc30a60529d7d6ce9282fc_prof);

    }

    // line 3
    public function block_head($context, array $blocks = array())
    {
        $__internal_5ec3122e3ce88bf3a8bf63c358f7bbb8e879a05d61f54e93f8ae257a203f8d42 = $this->env->getExtension("native_profiler");
        $__internal_5ec3122e3ce88bf3a8bf63c358f7bbb8e879a05d61f54e93f8ae257a203f8d42->enter($__internal_5ec3122e3ce88bf3a8bf63c358f7bbb8e879a05d61f54e93f8ae257a203f8d42_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "head"));

        // line 4
        echo "    <link href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('request')->generateAbsoluteUrl($this->env->getExtension('asset')->getAssetUrl("bundles/framework/css/exception.css")), "html", null, true);
        echo "\" rel=\"stylesheet\" type=\"text/css\" media=\"all\" />
";
        
        $__internal_5ec3122e3ce88bf3a8bf63c358f7bbb8e879a05d61f54e93f8ae257a203f8d42->leave($__internal_5ec3122e3ce88bf3a8bf63c358f7bbb8e879a05d61f54e93f8ae257a203f8d42_prof);

    }

    // line 7
    public function block_title($context, array $blocks = array())
    {
        $__internal_dd5ce94f6fbf5f94c7571a951e5ac5c33f48993b69dea3081706a2c480585daa = $this->env->getExtension("native_profiler");
        $__internal_dd5ce94f6fbf5f94c7571a951e5ac5c33f48993b69dea3081706a2c480585daa->enter($__internal_dd5ce94f6fbf5f94c7571a951e5ac5c33f48993b69dea3081706a2c480585daa_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "title"));

        // line 8
        echo "    ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["exception"]) ? $context["exception"] : $this->getContext($context, "exception")), "message", array()), "html", null, true);
        echo " (";
        echo twig_escape_filter($this->env, (isset($context["status_code"]) ? $context["status_code"] : $this->getContext($context, "status_code")), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, (isset($context["status_text"]) ? $context["status_text"] : $this->getContext($context, "status_text")), "html", null, true);
        echo ")
";
        
        $__internal_dd5ce94f6fbf5f94c7571a951e5ac5c33f48993b69dea3081706a2c480585daa->leave($__internal_dd5ce94f6fbf5f94c7571a951e5ac5c33f48993b69dea3081706a2c480585daa_prof);

    }

    // line 11
    public function block_body($context, array $blocks = array())
    {
        $__internal_45a83ea9b386dc99a850e4ebcb2c8d44e150a98990d632f3e6301c2db1371d44 = $this->env->getExtension("native_profiler");
        $__internal_45a83ea9b386dc99a850e4ebcb2c8d44e150a98990d632f3e6301c2db1371d44->enter($__internal_45a83ea9b386dc99a850e4ebcb2c8d44e150a98990d632f3e6301c2db1371d44_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "body"));

        // line 12
        echo "    ";
        $this->loadTemplate("@Twig/Exception/exception.html.twig", "@Twig/Exception/exception_full.html.twig", 12)->display($context);
        
        $__internal_45a83ea9b386dc99a850e4ebcb2c8d44e150a98990d632f3e6301c2db1371d44->leave($__internal_45a83ea9b386dc99a850e4ebcb2c8d44e150a98990d632f3e6301c2db1371d44_prof);

    }

    public function getTemplateName()
    {
        return "@Twig/Exception/exception_full.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  72 => 11,  58 => 8,  52 => 7,  42 => 4,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@Twig/layout.html.twig' %}*/
/* */
/* {% block head %}*/
/*     <link href="{{ absolute_url(asset('bundles/framework/css/exception.css')) }}" rel="stylesheet" type="text/css" media="all" />*/
/* {% endblock %}*/
/* */
/* {% block title %}*/
/*     {{ exception.message }} ({{ status_code }} {{ status_text }})*/
/* {% endblock %}*/
/* */
/* {% block body %}*/
/*     {% include '@Twig/Exception/exception.html.twig' %}*/
/* {% endblock %}*/
/* */
