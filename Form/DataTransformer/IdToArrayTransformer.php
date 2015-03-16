<?php

namespace SonataExtensionsBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class IdToArrayTransformer implements DataTransformerInterface
{
    public function reverseTransform($value)
    {
        if (isset($value['id'])) {
            return $value['id'];
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
            'id' => $value
        );
    }
}
