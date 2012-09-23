<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter;

use Countable;
use Iterator;
use IteratorAggregate;
use SplFileInfo;
use ArrayIterator;
use Imagine\Image\ImagineInterface;
use Imagine\Image\Box;
use Imagine\Image\Color;
use Imagine\Image\Point;

class Sprite implements Countable, IteratorAggregate
{
    private $files;
    private $imagine;
    private $padding;
    private $aggregated;
    private $width;
    private $height;

    public function __construct(Iterator $files, ImagineInterface $imagine, $padding = 10)
    {
        $this->files = $files;
        $this->imagine = $imagine;
        $this->padding = $padding;
    }

    private function aggregate()
    {
        if ($this->aggregated) {
            return $this->aggregated;
        }

        list($images, $totalHeight) = $this->prepareImages();

        if (count($images) == 0) {
            return $this->aggregated = array();
        }

        $x = 0;
        $y = 0;
        $maxColumnWidth = 0;

        foreach ($images as $key => $image) {
            if ($x == 0) {
                if ($this->height > $totalHeight / 4) {
                    $x += $maxColumnWidth;
                    $y = 0;
                    $image['x'] = $x;
                    $image['y'] = $y;
                } else {
                    $image['x'] = $x;
                    $image['y'] = $y;
                    $this->height += $image['height'] + $this->padding;
                    $maxColumnWidth = max($maxColumnWidth, $image['width'] + $this->padding);
                }
            } else if ($y + $image['height'] + $this->padding > $this->height) {
                $x += $maxColumnWidth;
                $y = 0;
                $maxColumnWidth = $image['width'] + $this->padding;
                $image['x'] = $x;
                $image['y'] = $y;
            } else {
                $image['x'] = $x;
                $image['y'] = $y;
                $maxColumnWidth = max($maxColumnWidth, $image['width'] + $this->padding);
            }

            $y += $image['height'] + $this->padding;

            $images[$key] = $image;
        }

        $this->width = $x + $maxColumnWidth;

        return $this->aggregated = $images;
    }

    private function prepareImages()
    {
        $items = array();

        $height = 0;

        foreach ($this->files as $file) {
            if (!$file instanceof SplFileInfo) {
                throw new Exception('Iterator must return SplFileInfo object');
            }

            try {
                $image = $this->imagine->open($file->getRealPath());
            } catch (\Imagine\Exception\InvalidArgumentException $e) {
                throw new Exception(sprintf('File "%s" provided by iterator is not valid image file', $file->getRealPath()), 0, $e);
            }

            $height += $image->getSize()->getHeight();

            $items[] = array(
                'x' => 0,
                'y' => 0,
                'width' => $image->getSize()->getWidth(),
                'height' => $image->getSize()->getHeight(),
                'file' => $file,
                'image' => $image,
            );
        }

        uasort($items, function ($a, $b) {
            return $a['height'] < $b['height'];
        });

        return array(array_values($items), $height);
    }

    public function setPadding($padding)
    {
        $this->padding = $padding;

        return $this;
    }

    public function getPadding()
    {
        return $this->padding;
    }

    public function getWidth()
    {
        $this->aggregate();

        return $this->width;
    }

    public function getHeight()
    {
        $this->aggregate();

        return $this->height;
    }

    public function getImage()
    {
        $this->aggregate();

        $transparent = new Color(0, 100);
        $image = $this->imagine->create(new Box($this->width, $this->height), $transparent);

        foreach ($this as $spritePiece) {
            $image->paste($spritePiece['image'], new Point($spritePiece['x'], $spritePiece['y']));
        }

        return $image;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->aggregate());
    }

    public function count()
    {
        return count($this->aggregate());
    }
}
