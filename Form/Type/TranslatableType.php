<?php

namespace SonataExtensionsBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\PersistentCollection;
use Exception;
use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;
use SonataExtensionsBundle\Form\Type\EventListener\TranslatableTypeListener;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Translations wrapper for the any standard (and more?) element.
 * If you bind that element to type "textarea" and you have 4 locales,
 * then, this element will replace itself with 4 virtual elements of the same type 
 * for every locale respectfully.
 */
class TranslatableType extends AbstractType
{
    /**
     * @var array
     */
    protected $locales = array();
    
    /**
     * @var ObjectManager
     */
    protected $objectManager;
    
    public function __construct(array $locales, ObjectManager $objectManager)
    {
        $this->locales = $locales;
        $this->objectManager = $objectManager;
    }

    /**
     * Supported locales.
     * 
     * @param array $locales
     * @return TranslatableType
     */
    public function setLocales($locales)
    {
        $this->locales = $locales;
        return $this;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'type' => null,
            'class' => null,
            'property' => null,
            'options' => array(),
        ));
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* @var $fd FieldDescription */
        $fd = $options['sonata_field_description'];
        $object = $fd->getAdmin()->getSubject();
        $request = $fd->getAdmin()->getRequest();
        $property = $builder->getName();
        $class = $options['class'];
        
        /* @var $builder FormBuilder */
        foreach ($this->locales as $locale) {
            $builder->add($locale, $options['type'], $options['options']);
        }
        
        // this will explode string value of text element into array of locales to texts
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($property, $object, $request) {
            $content = array();
            // get content for default locale
            $method = 'get' . $property;
            if (!method_exists($object, $method)) {
                throw new Exception('Class ' . get_class($object) . ' must implement method ' . $method);
            }
            $content[$request->getLocale()] = call_user_func_array(array($object, $method), array());

            foreach ($object->getTranslations() as $translation) {
                if ($translation->getField() == $property) {
                    $content[$translation->getLocale()] = $translation->getContent();
                }
            }
            $event->setData($content);
        });
        
        // this will populate translations and set a string value (trans. for current locale) into object
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($request, $object, $property, $class) {
            
            /* @var $translations PersistentCollection */
            $translations = $event->getData();
            if ($event->getForm()->isRequired()) {
                if (empty($translations[$request->getLocale()])) {
                    $event->getForm()->addError(new FormError(
                        'validator.translatable.value_required_for_locale', 
                        'validator.translatable.value_required_for_locale', 
                        [$request->getLocale()]
                    ));
                    $event->setData(null);
                    return;
                }
            }
            
            foreach ($translations as $locale => $translation) {
                // pick up a translation for current value and set it to the element
                $event->setData($translations[$request->getLocale()]);

                // here we have to update all dependant translations
                if (!$instance = $object->findTranslation($locale, $property)) {
                    $instance = new $class;
                    $object->addTranslation($instance);
                }
                $instance->setLocale($locale);
                $instance->setField($property);
                $instance->setContent($translation);
                $instance->setObject($object);
            }
        });
    }
    
    /**
     * 
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['locales'] = $this->locales;
    }
    
    /**
     * @return string
     */
    public function getParent()
    {
        return 'form';
    }

    /**
     * 
     * @return string
     */
    public function getName()
    {
        return 'se_type_translatable';
    }

}
