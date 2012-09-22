<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter\Test;

use PHPUnit_Framework_TestCase;
use Imagine\Gd\Imagine;
use Rithis\Spriter\Spriter;

class SpriterTest extends PHPUnit_Framework_TestCase
{
    private $spriter;

    protected function setUp()
    {
        $imagine = new Imagine();
        $this->spriter = new Spriter($imagine);
    }

    /**
     * @dataProvider provider
     */
    public function testScan($directory, $recursive, $expected)
    {
        $sprite = $this->spriter->scan($directory, $recursive);

        $this->assertInstanceOf('Rithis\\Spriter\\Sprite', $sprite);
        $this->assertEquals($expected, count($sprite));
    }

    public function provider()
    {
        return array(
            array(__DIR__ . '/images', false, 4),
            array(__DIR__, true, 4),
            array(__DIR__, false, 0),
        );
    }
}
