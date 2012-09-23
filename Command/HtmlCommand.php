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
use Rithis\Spriter\Formatter\TestPageFormatter;

class HtmlCommand extends Command
{
    protected function configure()
    {
        $this->setName('html');
        $this->setDescription('Make html page with sprite');
        $this->addArgument('directory', InputArgument::REQUIRED, 'Directory with images');
        $this->addOption('recursive', 'r', InputOption::VALUE_NONE, 'Scan directory recursively');
        $this->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Output file', 'index.html');
        $this->addOption('padding', 'p', InputOption::VALUE_REQUIRED, 'Image padding', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $spriter = new Spriter(new Imagine());

        $sprite = $spriter->scan($input->getArgument('directory'), $input->getOption('recursive'));
        $sprite->setPadding($input->getOption('padding'));

        $formatter = new TestPageFormatter();
        $html = $formatter->format($sprite);

        file_put_contents($input->getOption('output'), $html);
    }
}
