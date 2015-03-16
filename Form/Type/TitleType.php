<?php
namespace SonataExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TitleType extends AbstractType
{
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'choices' => array(
                'choice.title.mr' => 'Mr.', 
                'choice.title.ms' => 'Ms.', 
                'choice.title.mrs' => 'Mrs.'
            )
        ));
    }
    
    public function getParent()
    {
        return 'choice';
    }
    
    public function getName()
    {
        return 'se_type_title';
    }

}