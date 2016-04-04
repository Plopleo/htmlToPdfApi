<?php

/* @WebProfiler/Collector/router.html.twig */
class __TwigTemplate_f74e0196659170d87f03f21af21aff903b367581b82e82a14b8898220bcd6505 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/router.html.twig", 1);
        $this->blocks = array(
            'toolbar' => array($this, 'block_toolbar'),
            'menu' => array($this, 'block_menu'),
            'panel' => array($this, 'block_panel'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $__internal_7596b3233d725df3893f3aa6650685fa1d6db7cd90c374c8f72d02444be2b0ec = $this->env->getExtension("native_profiler");
        $__internal_7596b3233d725df3893f3aa6650685fa1d6db7cd90c374c8f72d02444be2b0ec->enter($__internal_7596b3233d725df3893f3aa6650685fa1d6db7cd90c374c8f72d02444be2b0ec_prof = new Twig_Profiler_Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/router.html.twig"));

        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_7596b3233d725df3893f3aa6650685fa1d6db7cd90c374c8f72d02444be2b0ec->leave($__internal_7596b3233d725df3893f3aa6650685fa1d6db7cd90c374c8f72d02444be2b0ec_prof);

    }

    // line 3
    public function block_toolbar($context, array $blocks = array())
    {
        $__internal_8d319ae704e76e6032000ff7d9fc51d5d88da3a45a62470ad697831a6e002a3a = $this->env->getExtension("native_profiler");
        $__internal_8d319ae704e76e6032000ff7d9fc51d5d88da3a45a62470ad697831a6e002a3a->enter($__internal_8d319ae704e76e6032000ff7d9fc51d5d88da3a45a62470ad697831a6e002a3a_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "toolbar"));

        
        $__internal_8d319ae704e76e6032000ff7d9fc51d5d88da3a45a62470ad697831a6e002a3a->leave($__internal_8d319ae704e76e6032000ff7d9fc51d5d88da3a45a62470ad697831a6e002a3a_prof);

    }

    // line 5
    public function block_menu($context, array $blocks = array())
    {
        $__internal_773f959030cd9168b912ce1cfeb2ab50a0e9981eefa38a0e65779b0fd75cfe83 = $this->env->getExtension("native_profiler");
        $__internal_773f959030cd9168b912ce1cfeb2ab50a0e9981eefa38a0e65779b0fd75cfe83->enter($__internal_773f959030cd9168b912ce1cfeb2ab50a0e9981eefa38a0e65779b0fd75cfe83_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "menu"));

        // line 6
        echo "<span class=\"label\">
    <span class=\"icon\">";
        // line 7
        echo twig_include($this->env, $context, "@WebProfiler/Icon/router.svg");
        echo "</span>
    <strong>Routing</strong>
</span>
";
        
        $__internal_773f959030cd9168b912ce1cfeb2ab50a0e9981eefa38a0e65779b0fd75cfe83->leave($__internal_773f959030cd9168b912ce1cfeb2ab50a0e9981eefa38a0e65779b0fd75cfe83_prof);

    }

    // line 12
    public function block_panel($context, array $blocks = array())
    {
        $__internal_89a07d7b622a3a0563c18566dca7a22ee99ddb62c380d78710b4eb21f3f562ed = $this->env->getExtension("native_profiler");
        $__internal_89a07d7b622a3a0563c18566dca7a22ee99ddb62c380d78710b4eb21f3f562ed->enter($__internal_89a07d7b622a3a0563c18566dca7a22ee99ddb62c380d78710b4eb21f3f562ed_prof = new Twig_Profiler_Profile($this->getTemplateName(), "block", "panel"));

        // line 13
        echo "    ";
        echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('routing')->getPath("_profiler_router", array("token" => (isset($context["token"]) ? $context["token"] : $this->getContext($context, "token")))));
        echo "
";
        
        $__internal_89a07d7b622a3a0563c18566dca7a22ee99ddb62c380d78710b4eb21f3f562ed->leave($__internal_89a07d7b622a3a0563c18566dca7a22ee99ddb62c380d78710b4eb21f3f562ed_prof);

    }

    public function getTemplateName()
    {
        return "@WebProfiler/Collector/router.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  73 => 13,  67 => 12,  56 => 7,  53 => 6,  47 => 5,  36 => 3,  11 => 1,);
    }
}
/* {% extends '@WebProfiler/Profiler/layout.html.twig' %}*/
/* */
/* {% block toolbar %}{% endblock %}*/
/* */
/* {% block menu %}*/
/* <span class="label">*/
/*     <span class="icon">{{ include('@WebProfiler/Icon/router.svg') }}</span>*/
/*     <strong>Routing</strong>*/
/* </span>*/
/* {% endblock %}*/
/* */
/* {% block panel %}*/
/*     {{ render(path('_profiler_router', { token: token })) }}*/
/* {% endblock %}*/
/* */
