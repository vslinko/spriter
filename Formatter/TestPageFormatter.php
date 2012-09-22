<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter\Formatter;

use Twig_Loader_String;
use Twig_Environment;
use Twig_Filter_Function;
use Rithis\Spriter\Sprite;
use Rithis\Spriter\Exception;

class TestPageFormatter extends TwigFormatter
{
    public function __construct()
    {
        $twig = new Twig_Environment(new Twig_Loader_String());
        $twig->addFilter('base64_encode', new Twig_Filter_Function('base64_encode'));

        $template = file_get_contents(__DIR__ . '/../Resources/views/test-page.html.twig');

        parent::__construct($twig, $template);
    }
}
