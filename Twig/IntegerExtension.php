<?php

namespace SonataExtensionsBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

class IntegerExtension extends Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('count', 'count')
        );
    }
    
    public function getName()
    {
        return 'integer';
    }

}