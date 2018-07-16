<?php
/**
 * This file is part of project queue-bundle.
 *
 * Author: Jaggle
 * Create: 2018-07-15 19:05:00
 */

namespace Jaggle\QueueBundle\Service;

use Jaggle\QueueBundle\Contracts\JobContract;
use Jaggle\QueueBundle\Contracts\QueueContract;
use Jaggle\QueueBundle\Exceptions\InvalidArgumentException;
use Jaggle\QueueBundle\RedisQueue;
use Predis\ClientInterface;

class QueueManager
{
    /**
     * @var RedisQueue
     */
    public $queue;

    public function __construct($type = RedisQueue::class)
    {
        if (!class_exists($type)) {
            throw new InvalidArgumentException(
                $type . ' class not exists'
            );
        }

        $queue = new $type;

        if (!($queue instanceof QueueContract)) {
            throw new InvalidArgumentException(
                $type . ' is not a valid queue type, queue type must implements ' . QueueContract::class
            );
        }

        $this->queue = $queue;
    }

    public function queue($queueName)
    {
        $this->queue->setName($queueName);
    }

    public function push(JobContract $job)
    {
        return $this->queue->push($job);
    }

    /**
     * @return JobContract|null
     */
    public function pop()
    {
        return $this->queue->pop();
    }

    public function setClient(ClientInterface $client)
    {
        $this->queue->setRedis($client);
    }

    public function greet()
    {
        return 'hello, this is ' . get_class($this);
    }
}