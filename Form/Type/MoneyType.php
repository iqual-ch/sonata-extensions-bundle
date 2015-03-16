<?php
namespace SonataExtensionsBundle\Form\Type;

use Locale;
use NumberFormatter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MoneyType extends AbstractType
{
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults($this->getDefaults());
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['currency'] = $options['currency'];
        $view->vars['attr'] = array_replace_recursive($this->getDefaults()['attr'], $view->vars['attr']);
    }
    
    public function getParent()
    {
        return 'money';
    }
    
    public function getName()
    {
        return 'se_type_money';
    }
    
    public function getDefaults()
    {
        $formatter = new NumberFormatter(Locale::getDefault(), NumberFormatter::DECIMAL);
        
        $defaults = array(
            'precision' => 2,
            'grouping' => NumberFormatter::GROUPING_SEPARATOR_SYMBOL,
            'currency' => $formatter->getSymbol(NumberFormatter::CURRENCY_SYMBOL),
            'thousands_separator' => $formatter->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL),
            'money_pattern' => '{{ widget }}',
        );
        
        $defaults = array_replace_recursive($defaults, array(
            'attr' => array(
                'data-type' => 'money',
                'data-precision' => $defaults['precision'],
                'data-decimal' => $formatter->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL),
                'data-thousands' => $formatter->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL),
            )
        ));
        return $defaults;
    }

}