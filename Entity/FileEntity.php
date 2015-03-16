<?php
namespace SonataExtensionsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use SonataExtensionsBundle\Util\FileModel;
use SonataExtensionsBundle\Entity\TransformableInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\MappedSuperclass
 */
abstract class FileEntity
{
    /**
     * Original name on disk.
     * @var string
     *
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    protected $originalName;
    
    /**
     * File name on disk.
     * @var string
     *
     * @ORM\Column(type="string", length=512, nullable=true)
     */
    protected $filename;
    
    /**
     * @var File
     */
    protected $file;
    
    /**
     * Path to directory where to upload files in.
     * 
     * @return string
     */
    abstract public function getUploadDirectory();
    
    /**
     * Internal funtions. Same as "getUploadDirectory" but creates directory structure.
     * 
     * @return string
     */
    public function getTargetDirectory()
    {
        $dir = $this->getUploadDirectory();
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return $dir;
    }
    
    /**
     * Returns absolute file path.
     * 
     * @return string
     * @throws Exception
     */
    public function getAbsolutePath()
    {
        $a = $this->getPathname();
        $path = realpath($this->getPathname());
        if (!$path || !is_file($path)) {
            throw new Exception(
                'Unable to locate file: "' . $this->filename . '" '
                . 'in directory "' . $this->getTargetDirectory() . '" '
                . 'path used: "' . $path . '"'
            );
        }
        return $path;
    }
    
    /**
     * A path, accessible for client (view, download, etc).
     * @return string
     */
    public function getDisplayPath()
    {
        return '/' . $this->getPathname();
    }
    
    /**
     * Relative path to file.
     * 
     * @param string $name
     * @return string
     */
    public function getPathname($name = null)
    {
        return $this->getTargetDirectory() . DIRECTORY_SEPARATOR . ($name ? $name : $this->filename);
    }
    
    /**
     * A file name on disk.
     * 
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return FileEntity
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }
    
    /**
     * Original file name.
     * 
     * @return string
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }

    /**
     * @param string $originalName
     * @return FileEntity
     */
    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
        return $this;
    }

    /**
     * Removes old file and uploads a new one. 
     * Generates unique name. Copies uploaded file to destination directory.
     * 
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function postUpdate()
    {
        if ($this->file) {
            if ($this->exists()) {
                $this->remove();
            }

            $this->filename = sprintf('%s.%s', md5(uniqid()), $this->file->getClientOriginalExtension());
            $this->originalName = $this->file->getClientOriginalName();
            copy($this->file->getPathname(), $this->getPathname());
            $this->file = null;
        }
    }
    
    /**
     * Compatibility with Symfony's standard upload process.
     * 
     * @param File $file
     */
    public function setFile(File $file)
    {
        $this->file = $file;
        $this->originalName = $file->getClientOriginalName();
    }
    
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Check if file still exists.
     * 
     * @return boolean
     */
    public function exists()
    {
        try {
            $this->getAbsolutePath();
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
    
    /**
     * Remove file from disk.
     * NB: this does not remove entity from database.
     * 
     * @ORM\PostRemove
     * @return bool
     */
    public function remove()
    {
        if ($this->exists()) {
            return unlink($this->getAbsolutePath());
        }
    }
    
    public function __toString()
    {
        return $this->originalName;
    }

}
