<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter\Formatter;

use Rithis\Spriter\Sprite;

interface FormatterInterface
{
    public function format(Sprite $sprite);
}
