<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter\Formatter;

use Twig_Environment;
use Twig_Loader_String;

class LessFormatter extends TwigFormatter
{
    public function __construct($url = null)
    {
        $template = file_get_contents(__DIR__ . '/../Resources/views/sprite.less.twig');

        parent::__construct(new Twig_Environment(new Twig_Loader_String()), $template, array(
            'url' => $url,
        ));
    }
}
