<?php
namespace SonataExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

class ImageFileType extends AbstractType
{
    public function getParent()
    {
        return 'file';
    }
    
    public function getName()
    {
        return 'se_type_image_file';
    }

}