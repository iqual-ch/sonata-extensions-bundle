<?php
namespace SonataExtensionsBundle\Admin\Extension;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Admin\AdminExtension;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class RemoveParentAssociationFilterAdminExtension extends AdminExtension
{
    protected $admin;
    
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }
    
    public function configureDatagridFilters(DatagridMapper $filter)
    {
        $field = $filter->get($this->admin->getParentAssociationMapping());
        if ($field) {
            $filter->get($this->admin->getParentAssociationMapping())->setLabel(false);
        }
    }

}