<?php
namespace SonataExtensionsBundle\Form\Type;

use Exception;
use SonataExtensionsBundle\Form\DataTransformer\JoinedToSeparatedTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JoinedType extends AbstractType
{
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'fields' => array(),
            'wrapper' => array(
                'class' => ''
            )
        ));
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setMapped(false);
        $builder->setRequired(false);
        foreach ($options['fields'] as $field) {
            $builder->add($field['name'], $field['type'], $field['options']);
        }
        
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($options) {
            $object = $event->getForm()->getParent()->getData();
            if (!$object) {
                return;
            }
            $data = array();
            foreach ($options['fields'] as $field) {
                $method = 'get' . $field['name'];
                if (isset($options['getter'])) {
                    $method = $options['getter'];
                }
                if (!method_exists($object, $method)) {
                    throw new Exception('Method "' . $method . '" does not exists in object "' . get_class($object) . '"');
                }
                $data[$field['name']] = call_user_func_array(array($object, $method), array());
            }
            $event->setData($data);
        });
        
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($options) {
            $object = $event->getForm()->getParent()->getData();
            $data = $event->getData();
            foreach ($data as $key => $value) {
                $method = 'set' . $key;
                if (isset($options['fields'][$key]['setter'])) {
                    $method = $options['fields'][$key]['setter'];
                }
                if (!method_exists($object, $method)) {
                    throw new Exception('Method "' . $method . '" does not exists in object "' . get_class($object) . '"');
                }
                call_user_func_array(array($object, $method), array($value));
            }
        });
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $wrapperConfig = array();
        foreach ($options['fields'] as $field) {
            $wrapperConfig[$field['name']] = $field['wrapper'];
        }
        $view->vars['element_wrapper_config'] = $wrapperConfig;
        $view->vars['wrapper'] = $options['wrapper'];
    }

    public function getParent()
    {
        return 'form';
    }
    
    public function getName()
    {
        return 'se_type_joined';
    }

}