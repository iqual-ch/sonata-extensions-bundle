<?php
namespace SonataExtensionsBundle\Controller;

use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SonataExtensionsBundle\Entity\AutocompleteProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PropertyAccess\PropertyAccessor;

class AutocompleteController extends Controller
{
    /**
     * @Route("se/autocomplete/suggest", name="se_autocomplete_suggest", methods={"GET"})
     */
    public function suggestAction()
    {
        $query = $this->get('request')->get('q', '');
        $session = $this->get('session');
        $config = $session->get($this->get('request')->query->get('key'));
        if (!$config) {
            throw new Exception('No autocomplete registered.');
        }
        
        $class = $config['class'];
        $properties = $config['properties'];
        $searchProp = $config['match_against'];
        $labelGetter = $config['label_getter'];
        
        $repository = $this->getDoctrine()->getManager()->getRepository($class);
        if (!$repository instanceof AutocompleteProviderInterface) {
            throw new Exception(
                'Repository "'. get_class($repository) . '" '
                . 'for entity "' . $class . '" '
                . 'must implement interface "SonataExtensionsBundle\Entity\AutocompleteProviderInterface" '
                );
        }
        
        $accessor = new PropertyAccessor;
        $result = array();
        $items = $repository->getAutocomplete($query, $searchProp, $config['limit'], $config['sort']);
        foreach ($items as $item) {
            $row = array(
                'id' => $accessor->getValue($item, 'id'),
                'extra' => array()
            );
            
            if (method_exists($item, $labelGetter)) {
                $row['label'] = call_user_func_array(array($item, $labelGetter), array());
            } else if (property_exists($item, $labelGetter)) {
                $row['label'] = $accessor->getValue($item, $labelGetter);
            }
            
            foreach ($properties as $property) {
                $row['extra'][$property] = $accessor->getValue($item, $property);
            }
            
            $result[] = $row;
        }
        return new JsonResponse($result);
    }
}