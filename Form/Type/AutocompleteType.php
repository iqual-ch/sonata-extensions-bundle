<?php
namespace SonataExtensionsBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use SonataExtensionsBundle\Form\DataTransformer\EntityToPropertyTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AutocompleteType extends AbstractType
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array(
            'class' => null,
            'label_getter' => null,
            'limit' => null,
            'min_length' => 3,
            'sort' => array(),
            'properties' => array(),
            'match_against' => null
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->session->set($this->getSessionKey($builder->getForm(), $options), array(
            'class' => $options['class'],
            'limit' => $options['limit'],
            'sort' => $options['sort'],
            'label_getter' => $options['label_getter'],
            'match_against' => $options['match_against'],
            'properties' => $options['properties'],
        ));
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['min_length'] = $options['min_length'];
        $view->vars['key'] = $this->getSessionKey($form, $options);
    }
    
    public function getParent()
    {
        return 'text';
    }
    
    public function getName()
    {
        return 'se_type_autocomplete';
    }
    
    protected function getSessionKey(FormInterface $form, array $options)
    {
        return md5($options['class'] . $form->getName());
    }

}