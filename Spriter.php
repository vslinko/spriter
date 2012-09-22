<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;
use CallbackFilterIterator;
use SplFileInfo;
use Imagine\Image\ImagineInterface;

class Spriter
{
    private $imagine;

    public function __construct(ImagineInterface $imagine)
    {
        $this->imagine = $imagine;
    }

    public function scan($directory, $recursive = true)
    {
        if ($recursive) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        } else {
            $iterator = new FilesystemIterator($directory);
        }

        $iterator = new CallbackFilterIterator($iterator, function (SplFileInfo $file) {
            return in_array($file->getExtension(), array('png', 'jpg', 'jpeg', 'gif'));
        });

        return new Sprite($iterator, $this->imagine);
    }
}
