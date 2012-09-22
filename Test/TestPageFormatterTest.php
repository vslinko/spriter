<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter\Test;

use PHPUnit_Framework_TestCase;
use Imagine\Gd\Imagine;
use Rithis\Spriter\Spriter;
use Rithis\Spriter\Formatter\TestPageFormatter;

class TestPageFormatterTest extends PHPUnit_Framework_TestCase
{
    public function testScan()
    {
        $sprite = (new Spriter(new Imagine()))->scan(__DIR__ . '/images');

        $html = (new TestPageFormatter())->format($sprite);

        $this->assertContains('.icon', $html);
        $this->assertContains('.facebook', $html);
        $this->assertContains('<div class="icon facebook"></div>', $html);
    }
}
