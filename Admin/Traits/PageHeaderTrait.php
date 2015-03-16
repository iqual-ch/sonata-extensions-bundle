<?php
namespace SonataExtensionsBundle\Admin\Traits;

trait PageHeaderTrait
{
    public function getPageHeader()
    {
        $parts = explode('::', $this->getRequest()->get('_controller'));
        $action = 'index';
        if (isset($parts[1])) {
            $action = str_replace('Action', '', $parts[1]);
        }
        
        $getModelName = function($class) {
            return (string) $class;
        };
        
        $objectName = array();
        if ($this->isChild()) {
            $objectName[] = $getModelName($this->getParent()->getSubject());
        }
        $objectName[] =  $getModelName($this->getSubject());
        $objectName = join(' / ', $objectName);
        $template = sprintf('page_header.action_%s', $action);
        
        $modelParts = explode('\\', $this->getClass());
        $modelClass = array_pop($modelParts);
        return $this->trans($template, array(
            '%name%' => $objectName,
            '%entity_single%' => $this->trans('label.' . strtolower($modelClass)),
            '%entity_single_lowercase%' => strtolower($this->trans('label.' . strtolower($modelClass))),
            '%entity_multi%' => $this->trans('label.' . strtolower($modelClass) . 's'),
            '%entity_multi_lowercase%' => strtolower($this->trans('label.' . strtolower($modelClass) . 's')),
        ));
    }
}