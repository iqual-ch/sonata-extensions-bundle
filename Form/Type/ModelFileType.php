<?php

namespace SonataExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModelFileType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'allow_change' => true,
            'sonata_field_description' => null
        ));
        $resolver->setRequired(['sonata_field_description']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('file', 'se_type_file', array(
            'required' => false,
            'label' => false,
            'allow_change' => $options['allow_change'],
            'sonata_field_description' => $options['sonata_field_description']
        ));
        
        $builder->add('id', 'hidden', array());
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['allow_change'] = $options['allow_change'];
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'se_type_model_file';
    }

}
