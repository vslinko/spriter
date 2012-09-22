<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter\Test;

use ArrayIterator;
use DirectoryIterator;
use PHPUnit_Framework_TestCase;
use Imagine\Gd\Imagine;
use Imagine\Image\Point;
use Rithis\Spriter\Spriter;
use Rithis\Spriter\Sprite;
use Rithis\Spriter\Exception;

class SpriteTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Rithis\Spriter\Exception
     * @expectedExceptionMessage Iterator must return SplFileInfo object
     */
    public function testIteratorReturnException()
    {
        $sprite = new Sprite(new ArrayIterator(array("I'm not SplFileInfo object")), new Imagine());

        count($sprite);
    }

    /**
     * @expectedException \Rithis\Spriter\Exception
     */
    public function testNotImageException()
    {
        $sprite = new Sprite(new DirectoryIterator(__DIR__ . '/images'), new Imagine());

        count($sprite);
    }

    public function testSize()
    {
        $sprite = (new Spriter(new Imagine()))->scan(__DIR__ . '/images');

        $this->assertEquals(455, $sprite->getWidth());
        $this->assertEquals(175, $sprite->getHeight());
    }

    public function testImage()
    {
        $imagine = new Imagine();

        $image = (new Spriter($imagine))->scan(__DIR__ . '/images')->getImage();

        $this->assertEquals(455, $image->getSize()->getWidth());
        $this->assertEquals(175, $image->getSize()->getHeight());

        $originalColor = $imagine->open(__DIR__ . '/images/twitter.jpg')->getColorAt(new Point(10, 10));
        $imageColor = $image->getColorAt(new Point(10, 10));

        $this->assertEquals($originalColor->getRed(), $imageColor->getRed());
        $this->assertEquals($originalColor->getGreen(), $imageColor->getGreen());
        $this->assertEquals($originalColor->getBlue(), $imageColor->getBlue());
        $this->assertEquals($originalColor->getAlpha(), $imageColor->getAlpha());
    }
}
