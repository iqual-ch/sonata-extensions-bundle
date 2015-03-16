<?php

namespace SonataExtensionsBundle\Twig;

use Twig_Extension;
use Twig_SimpleTest;

class RegexExtension extends Twig_Extension
{

    public function getTests()
    {
        return array(
            
        );
    }

    public function getName()
    {
        return 'regex';
    }

}