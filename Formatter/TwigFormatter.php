<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter\Formatter;

use Twig_Environment;
use Rithis\Spriter\Sprite;

class TwigFormatter implements FormatterInterface
{
    private $twig;
    private $template;
    private $context;

    public function __construct(Twig_Environment $twig, $template, $context = array())
    {
        $this->twig = $twig;
        $this->template = $template;
        $this->context = $context;
    }

    public function format(Sprite $sprite)
    {
        $context = array_merge($this->context, array('sprite' => $sprite));

        return $this->twig->render($this->template, $context);
    }
}
