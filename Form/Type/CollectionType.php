<?php

namespace SonataExtensionsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CollectionType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'by_reference' => false,
            'button_label_add' => 'form.label.add_item',
            'button_label_remove' => 'form.label.remove_item',
        ));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options) {
        parent::buildView($view, $form, $options);
        $view->vars['button_label_add'] = $options['button_label_add'];
        $view->vars['button_label_remove'] = $options['button_label_remove'];
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'collection';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'se_type_collection';
    }

}
