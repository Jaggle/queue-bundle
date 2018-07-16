<?php
/**
 * This file is part of project queue-bundle.
 *
 * Author: Jaggle
 * Create: 2018-07-15 19:10:28
 */

namespace Jaggle\QueueBundle\Contracts;

interface QueueContract
{

    /**
     * Push a new job onto the queue.
     *
     * @param  JobContract  $job
     * @return boolean
     */
    public function push(JobContract $job);

    /**
     * Push a raw payload onto the queue.
     *
     * @param  string  $payload
     * @param  string  $queue
     * @param  array   $options
     * @return mixed
     */
    public function pushRaw($payload, $queue = null, array $options = []);

    /**
     * Push a new job onto the queue after a delay.
     *
     * @param  \DateTime|int  $delay
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @return mixed
     */
    public function later($delay, $job, $data = '', $queue = null);

    /**
     * Pop the next job off of the queue.
     *
     * @return JobContract|null
     */
    public function pop();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);
}