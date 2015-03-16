<?php
namespace SonataExtensionsBundle\Admin\Traits;

use Knp\Menu\ItemInterface;

trait LeftMenuTrait
{
    /**
     * @var ItemInterface
     */
    protected $leftMenu;
    
    /**
     * @return ItemInterface
     */
    public function getLeftMenu()
    {
        $menu = $this->menuFactory->createItem('left_menu');
        $this->configureLeftMenu($menu);
        return $menu;
    }
    
    public function configureLeftMenu(ItemInterface $menu)
    {
        
    }
}

