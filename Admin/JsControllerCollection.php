<?php
namespace SonataExtensionsBundle\Admin;

use Doctrine\Common\Collections\ArrayCollection;

class JsControllerCollection extends ArrayCollection
{
    public function set($routeOrArray, $controller = null)
    {
        if (func_num_args() == 2) {
             parent::set($routeOrArray, $controller);
        } else {
            foreach ($routeOrArray as $route => $controller) {
                parent::set($route, $controller);
            }
        }
    }
}