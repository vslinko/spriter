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

class ImageCommand extends Command
{
    protected function configure()
    {
        $this->setName('image');
        $this->setDescription('Make sprite image');
        $this->addArgument('directory', InputArgument::REQUIRED, 'Directory with images');
        $this->addOption('recursive', 'r', InputOption::VALUE_NONE, 'Scan directory recursively');
        $this->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Output file', 'sprite.png');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $spriter = new Spriter(new Imagine());

        $spriter->scan($input->getArgument('directory'), $input->getOption('recursive'))
            ->getImage()
            ->save($input->getOption('output'));
    }
}
