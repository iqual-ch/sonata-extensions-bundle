<?php

namespace SonataExtensionsBundle\Form\Type;

use Sonata\AdminBundle\Form\DataTransformer\ModelToIdTransformer;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use SonataExtensionsBundle\Form\DataTransformer\IdToArrayTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class ModelAutocompleteType extends AutocompleteType
{

    /**
     * @var ModelManagerInterface
     */
    protected $modelManager;
    
    public function __construct(Session $session, ModelManagerInterface $modelManager)
    {
        parent::__construct($session);
        $this->modelManager = $modelManager;
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'compound' => true,
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->addViewTransformer(new ModelToIdTransformer($this->modelManager, $options['class']));
        $builder->addViewTransformer(new IdToArrayTransformer());
        $builder->add('text', 'text', array(
            'required' => $options['required'],
            'mapped' => false,
            'label' => false,
            'attr' => array(
                'required' => $options['required']
            )
        ));
        
        $builder->add('id', 'hidden', array(
            'required' => $options['required']
        ));
        
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($options) {
            $object = $event->getData();
            $textElement = $event->getForm()->get('text');
            if ($object) {
                if (method_exists($object, $options['label_getter'])) {
                    $textElement->setData(call_user_func_array(array($object, $options['label_getter']), array()));
                } else if (property_exists($object, $options['label_getter'])) {
                    $accessor = new PropertyAccessor;
                    $textElement->setData($accessor->getValue($object, $options['label_getter']));
                }
            }
        });
    }
    
    public function getParent()
    {
        return 'form';
    }

    public function getName()
    {
        return 'se_type_model_autocomplete';
    }

}
