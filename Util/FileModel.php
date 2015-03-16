<?php

namespace SonataExtensionsBundle\Util;

use SonataExtensionsBundle\Entity\FileEntity;
use Symfony\Component\HttpFoundation\File\File;

class FileModel extends File
{
    protected $model;
    
    public function getModel()
    {
        return $this->model;
    }

    public function setModel(FileEntity $model)
    {
        $this->model = $model;
        return $this;
    }
}
