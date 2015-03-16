<?php
namespace SonataExtensionsBundle\Entity;

interface ArrayTransformableInterface
{
    /**
     * Converts object instance into array.
     * 
     * @return array
     */
    public function toArray();
    
    /**
     * Populates object values from array.
     * 
     * @param array $array
     * @return stdClass
     */
    public function fromArray(array $array);
}