<?php

namespace SonataExtensionsBundle\Form\DataTransformer;

use DateTime;
use Symfony\Component\Form\DataTransformerInterface;

class DateToStringTransformer implements DataTransformerInterface
{
    protected $format;

    public function __construct($format = 'mm/dd/yyyy')
    {
        $this->format = $format;
    }
    
    public function reverseTransform($value)
    {
        return new DateTime($value);
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
        return $value->format($this->fixFormat($this->format));
    }

    /**
     * @param string $format
     * @return string
     */
    protected function fixFormat($format)
    {
        return strtr($format, array(
            'dd' => 'd',
            'd' => 'j',
            'DD' => 'l',
            'D' => 'D',
            'mm' => 'm',
            'm' => 'n',
            'yyyy' => 'Y',
            'yy' => 'y'
        ));
    }

}
