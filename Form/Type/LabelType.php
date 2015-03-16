<?php
namespace SonataExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class LabelType extends AbstractType
{
    public function getParent()
    {
        return 'text';
    }
    
    public function getName()
    {
        return 'se_type_label';
    }

}