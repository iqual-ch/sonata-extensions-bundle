<?php

namespace SonataExtensionsBundle\Form\DataTransformer;

use Sonata\AdminBundle\Model\ModelManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class CollectionToArrayTransformer implements DataTransformerInterface
{
    /**
     * @var ModelManagerInterface
     */
    protected $modelManager;
    
    protected $modelClass;
    
    public function __construct(ModelManagerInterface $modelManager, $modelClass)
    {
        $this->modelManager = $modelManager;
        $this->modelClass = $modelClass;
    }
    public function reverseTransform($value)
    {
        if (isset($value['id'])) {
            return [$this->modelManager->find($this->modelClass, $value['id'])];
        }
    }

    /**
     * 
     * @param DateTime $value
     * @return string
     */
    public function transform($value)
    {
        if (!$value) {
            return null;
        }
        return array(
            'id' => $value[0]->getId()
        );
    }
}
