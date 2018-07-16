<?php
/**
 * This file is part of project queue-bundle.
 *
 * Author: Jaggle
 * Create: 2018-07-16 15:28:07
 */

namespace Jaggle\QueueBundle;

use Jaggle\QueueBundle\Contracts\JobContract;
use Jaggle\QueueBundle\Support\Arr;

class RedisJob extends Job implements JobContract
{
    /**
     * The Redis queue instance.
     *
     * @var RedisQueue
     */
    protected $redis;

    /**
     * The Redis job payload.
     *
     * @var string
     */
    protected $job;

    protected $payload;

    /**
     * Create a new job instance.
     *
     * RedisJob constructor.
     * @param $id
     * @param array $data
     */
    public function __construct($id, array $data)
    {
        $this->setId($id);
        $this->setData($data);
    }

    /**
     * Fire the job.
     *
     * @return void
     */
    public function fire()
    {
        $this->resolveAndFire(json_decode($this->getRawBody(), true));
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->job;
    }

    /**
     * Delete the job from the queue.
     *
     * @return void
     */
    public function delete()
    {
        parent::delete();

        $this->redis->deleteReserved($this->queue, $this->job);
    }

    /**
     * Release the job back into the queue.
     *
     * @param  int   $delay
     * @return void
     */
    public function release($delay = 0)
    {
        parent::release($delay);

        $this->delete();

        $this->redis->release($this->queue, $this->job, $delay, $this->attempts() + 1);
    }

    /**
     * Get the number of times the job has been attempted.
     *
     * @return int
     */
    public function attempts()
    {
        return Arr::get(json_decode($this->job, true), 'attempts');
    }

    /**
     * Get the job identifier.
     *
     * @return string
     */
    public function getJobId()
    {
        return Arr::get(json_decode($this->job, true), 'id');
    }

    /**
     * Get the underlying Redis job.
     *
     * @return string
     */
    public function getRedisJob()
    {
        return $this->job;
    }
}