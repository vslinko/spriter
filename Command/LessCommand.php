<?php
/**
 * @copyright 2012 Rithis Studio LLC
 * @author Vyacheslav Slinko <vyacheslav.slinko@rithis.com>
 */

namespace Rithis\Spriter\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Imagine\Gd\Imagine;
use Rithis\Spriter\Spriter;
use Rithis\Spriter\Formatter\LessFormatter;

class LessCommand extends Command
{
    protected function configure()
    {
        $this->setName('less');
        $this->setDescription('Make sprite and less file');
        $this->addArgument('directory', InputArgument::REQUIRED, 'Directory with images');
        $this->addOption('recursive', 'r', InputOption::VALUE_NONE, 'Scan directory recursively');
        $this->addOption('url', 'u', InputOption::VALUE_REQUIRED, 'URL with sprite');
        $this->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Output directory', '.');
        $this->addOption('sprite-name', 's', InputOption::VALUE_REQUIRED, 'Sprite file name', 'sprite.png');
        $this->addOption('less-name', 'c', InputOption::VALUE_REQUIRED, 'LESS file name', 'sprite.less');
        $this->addOption('padding', 'p', InputOption::VALUE_REQUIRED, 'Image padding', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $spriter = new Spriter(new Imagine());

        $sprite = $spriter->scan($input->getArgument('directory'), $input->getOption('recursive'));
        $sprite->setPadding($input->getOption('padding'));

        $url = $input->getOption('url') ?: $input->getOption('sprite-name');

        $formatter = new LessFormatter($url);
        $less = $formatter->format($sprite);

        $sprite->getImage()->save(sprintf('%s/%s', $input->getOption('output'), $input->getOption('sprite-name')));

        file_put_contents(sprintf('%s/%s', $input->getOption('output'), $input->getOption('less-name')), $less);
    }
}
