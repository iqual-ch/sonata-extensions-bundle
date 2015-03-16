<?php
namespace SonataExtensionsBundle\Entity;

interface TransformableInterface
{
    /**
     * @return array
     */
    public function transform();
    
    /**
     * @return stdClass
     */
    public function reverseTransform($data);
}