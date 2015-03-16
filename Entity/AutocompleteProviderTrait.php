<?php
namespace SonataExtensionsBundle\Entity;

trait AutocompleteProviderTrait
{
    public function getAutocompleteQueryBuilder($query, $field, $limit = null, array $sort = null)
    {
        $qb = $this->createQueryBuilder('ap');
        $qb->where($qb->expr()->like('ap.' . $field, $qb->expr()->literal('%' . $query . '%')));
        if ($limit) {
            $qb->setMaxResults($limit);
        }
        if ($sort) {
            foreach ($sort as $column => $dir) {
                $qb->orderBy('ap.' . $column, strtoupper($dir));
            } 
        }
        return $qb;
    }
    
    /**
     * @param string $query
     * @param string $field
     * @param int|null $limit
     * @param array $sort
     * @return array
     */
    public function getAutocomplete($query, $field, $limit = null, array $sort = null)
    {
        return $this->getAutocompleteQueryBuilder($query, $field, $limit, $sort)->getQuery()->getResult();
    }
}