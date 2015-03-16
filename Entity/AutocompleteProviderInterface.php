<?php
namespace SonataExtensionsBundle\Entity;

interface AutocompleteProviderInterface
{
    public function getAutocomplete($query, $field);
}