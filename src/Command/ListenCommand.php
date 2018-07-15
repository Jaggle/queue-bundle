<?php

/**
 * This file is part of project queue-bundle.
 *
 * Author: Jaggle
 * Create: 2018-07-15 18:26:38
 */

namespace Jaggle\QueueBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ListenCommand extends Command
{
    protected function configure()
    {
        $this->setName('queue:check');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $out = new SymfonyStyle($input, $output);

        $out->success('everything is ok now!');
    }
}