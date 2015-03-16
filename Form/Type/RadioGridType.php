<?php

namespace SonataExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RadioGridType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'title' => null,
            'columns' => array(),
            'rows' => array(),
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        foreach ($options['rows'] as $id => $name) {
            $builder->add($id, 'choice', array(
                'expanded' => true,
                'choices' => $options['columns']
            ));
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['columns'] = $options['columns'];
        $view->vars['rows'] = $options['rows'];
        $view->vars['title'] = $options['title'];
    }

    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'se_type_radio_grid';
    }

}
