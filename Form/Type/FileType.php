<?php
namespace SonataExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FileType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'allow_change' => true
        ));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['allow_change'] = $options['allow_change'];
    }
    
    public function getParent()
    {
        return 'file';
    }
    
    public function getName()
    {
        return 'se_type_file';
    }

}