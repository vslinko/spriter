<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter\Formatter;

use Twig_Environment;
use Twig_Loader_String;
use Rithis\Spriter\Sprite;

class CssFormatter extends TwigFormatter
{
    public function __construct($url)
    {
        $template = file_get_contents(__DIR__ . '/../Resources/views/sprite.css.twig');

        parent::__construct(new Twig_Environment(new Twig_Loader_String()), $template, array(
            'url' => $url,
        ));
    }
}
