<?php
namespace SonataExtensionsBundle\Admin\Traits;

use SonataExtensionsBundle\Admin\JsControllerCollection;

trait JavascriptTrait
{
    public function getJsControllers() {
        $collection = new JsControllerCollection;
        $this->configureJsControllers($collection);
        return $collection;
    }
    
    public function configureJsControllers(JsControllerCollection $collection)
    {
        
    }
}