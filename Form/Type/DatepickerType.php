<?php
namespace SonataExtensionsBundle\Form\Type;

use SonataExtensionsBundle\Form\DataTransformer\DateToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @link http://bootstrap-datepicker.readthedocs.org/en/release/options.html
 */
class DatepickerType extends AbstractType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        /**
         * refer for details
         * @link http://bootstrap-datepicker.readthedocs.org/en/release/options.html
         */
        $resolver->setDefaults(array(
            'options' => array()
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $format = isset($options['options']['format']) ? $options['options']['format'] : null;
        $builder->addViewTransformer(new DateToStringTransformer($format));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['options'] = $options['options'];
    }
    
    public function getParent()
    {
        return 'text';
    }
    
    public function getName()
    {
        return 'se_type_datepicker';
    }
}