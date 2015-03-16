<?php
namespace SonataExtensionsBundle\Translatable;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

interface TranslatableInterface
{
    /**
     * @return ArrayCollection
     */
    public function getTranslations();
    
    /**
     * @param ArrayCollection $translations
     */
    public function setTranslations(ArrayCollection $translations);

    /**
     * @param AbstractPersonalTranslation $locale
     */
    public function getTranslation($locale);
    
    /**
     * @param AbstractPersonalTranslation $translation
     */
    public function addTranslation(AbstractPersonalTranslation $translation);
}