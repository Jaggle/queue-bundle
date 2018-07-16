<?php
/**
 * This file is part of project queue-bundle.
 *
 * Author: Jaggle
 * Create: 2018-07-16 20:44:33
 */

namespace Jaggle\QueueBundle\Command;

use Jaggle\QueueBundle\RedisJob;
use Jaggle\QueueBundle\RedisQueue;
use Jaggle\QueueBundle\Service\QueueManager;
use Jaggle\QueueBundle\Tests\Jobs\TestRedisJob;
use Predis\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    /**
     * @var QueueManager
     */
    private $queueService;

    public function __construct(QueueManager $queueService)
    {
        $this->queueService = $queueService;
        $this->queueService->queue('test');
        $this->queueService->setClient(new Client());

        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('queue:test');
        $this->setDescription('test if jaggle queue bundle is installed successful');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->queueService->push(new TestRedisJob(23, ['name' => 'Jake']));

        $job = $this->queueService->pop();

        dump($job);

        $ret = $job->fire();

        dump($ret);
    }
}