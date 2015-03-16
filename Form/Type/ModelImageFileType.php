<?php
namespace SonataExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ModelImageFileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'se_type_image_file', array(
            'required' => false
        ));
        $builder->add('id', 'hidden', array(
            
        ));
    }
    
    public function getParent()
    {
        return 'form';
    }
    
    public function getName()
    {
        return 'se_type_model_image_file';
    }

}