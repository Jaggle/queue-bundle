<?php
/**
 * This file is part of project queue-bundle.
 *
 * Author: Jaggle
 * Create: 2018-07-16 11:54:38
 */

namespace Jaggle\QueueBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StopCommand extends Command
{
    protected function configure()
    {
        $this->setName('queue:stop');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}