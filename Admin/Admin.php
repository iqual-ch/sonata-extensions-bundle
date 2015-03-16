<?php
namespace SonataExtensionsBundle\Admin;

use Knp\Menu\MenuFactory;
use Sonata\AdminBundle\Admin\Admin as BaseAdmin;

/**
 * @method MenuFactory getMenuFactory()
 */
class Admin extends BaseAdmin
{
    use Traits\LeftMenuTrait;
    use Traits\PageHeaderTrait;
    use Traits\JavascriptTrait;
    
    public function getBaseRouteName()
    {
        if (null === $this->baseRouteName) {
            if (!$this->isChild()) {
                return null;
            } else {
                $this->baseRouteName = sprintf('%s_%s',
                    $this->getParent()->getBaseRouteName(),
                    $this->urlize($this->getEntityName())
                );
            }
            
            return $this->baseRouteName;
        } else {
            return parent::getBaseRouteName();
        }
    }
    
    public function getBaseRoutePattern()
    {
        if (null === $this->baseRoutePattern) {
            if (!$this->isChild()) {
                return null;
            } else {
                $this->baseRoutePattern = sprintf('%s/{id}/%s',
                    $this->getParent()->getBaseRoutePattern(),
                    $this->urlize($this->getEntityName(), '-')
                );
            }
            return $this->baseRoutePattern;
        } else {
            return parent::getBaseRoutePattern();
        }
    }
    
    public function getEntityName()
    {
        $parts = explode('\\', get_class($this));
        return str_replace('Admin', '', array_pop($parts));
    }
    
    public function removeFormGroup($group)
    {
        $groups = $this->getFormGroups();
        if (isset($groups[$group])) {
            unset($groups[$group]);
            $this->setFormGroups($groups);
        }
    }
    
    public function getModelRepository($class)
    {
        return $this->getModelManager()->getEntityManager($class)->getRepository($class);
    }
}