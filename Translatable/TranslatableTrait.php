<?php
namespace SonataExtensionsBundle\Translatable;

use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @property ArrayCollection $translations
 */
trait TranslatableTrait
{
    /**
     * @return ArrayCollection
     */
    public function getTranslations()
    {
        return $this->translations;
    }
    
    /**
     * @param ArrayCollection $translations
     * @return $this
     */
    public function setTranslations(ArrayCollection $translations)
    {
        $this->translations = $translations;
        return $this;
    }
    
    /**
     * @param AbstractPersonalTranslation $translation
     */
    public function addTranslation(AbstractPersonalTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations->add($translation);
            $translation->setObject($this);
        }
    }
    
    /**
     * @param string $locale
     * @return AbstractPersonalTranslation
     */
    public function getTranslation($locale)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getLocale() == $locale) {
                return $translation;
            }
        }
    }
    
    public function findTranslation($locale, $field)
    {
        foreach ($this->translations as $translation) {
            if ($translation->getLocale() == $locale && $translation->getField() == $field) {
                return $translation;
            }
        }
    }
}