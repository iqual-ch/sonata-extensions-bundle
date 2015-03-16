<?php

namespace SonataExtensionsBundle\Form\DataTransformer;

use Exception;
use SonataExtensionsBundle\Entity\ArrayTransformableInterface;
use Symfony\Component\Form\DataTransformerInterface;

class ObjectToArrayTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    protected $modelClass;
    
    /**
     * @var ArrayTransformableInterface
     */
    protected $model;
    
    /**
     * @param string $modelClass
     * @param ArrayTransformableInterface $model
     */
    public function __construct($modelClass, ArrayTransformableInterface $model = null) {
        $this->modelClass = $modelClass;
        $this->model = $model;
    }
    
    /**
     * @param ArrayTransformableInterface $model
     */
    public function setModel(ArrayTransformableInterface $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $value
     * @return ArrayTransformableInterface
     * @throws Exception
     */
    public function reverseTransform($value)
    {
        if ($value) {
            if (!$this->model) {
                $this->model = new $this->modelClass;
            }
            if (!$this->model instanceof ArrayTransformableInterface) {
                throw new Exception($this->modelClass . ' must implement SonataExtensionsBundle\Entity\ArrayTransformableInterface.');
            }
            $this->model->fromArray($value);
            return $this->model;
        }
    }

    /**
     * @param ArrayTransformableInterface $value
     * @return array
     */
    public function transform($value)
    {
        if ($value) {
            if (!$value instanceof ArrayTransformableInterface) {
                throw new Exception($this->modelClass . ' must implement SonataExtensionsBundle\Entity\ArrayTransformableInterface.');
            }
            return $value->toArray();
        }
    }
}
