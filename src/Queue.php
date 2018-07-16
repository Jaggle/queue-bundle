<?php
/**
 * This file is part of project queue-bundle.
 *
 * Author: Jaggle
 * Create: 2018-07-15 19:09:07
 */

namespace Jaggle\QueueBundle;

use Jaggle\QueueBundle\Contracts\EncrypterContract;
use Jaggle\QueueBundle\Contracts\JobContract;
use Jaggle\QueueBundle\Support\Arr;


abstract class Queue
{
    /**
     * @var string the name of current queue.
     */
    protected $name = 'default';

    /**
     * @var EncrypterContract
     */
    protected $crypt;

    abstract function push(JobContract $job);

    /**
     * Marshal a push queue request and fire the job.
     *
     * @throws \RuntimeException
     *
     * @deprecated since version 5.1.
     */
    public function marshal()
    {
        throw new \RuntimeException('Push queues only supported by Iron.');
    }

    /**
     * Push an array of jobs onto the queue.
     *
     * @param  array   $jobs
     * @param  string  $queue
     * @return void
     */
    public function bulk($jobs, $queue = null)
    {
        foreach ((array) $jobs as $job) {
            $this->push($job);
        }
    }

    /**
     * Create a payload string from the given job and data.
     *
     * @param  string  $job
     * @param  mixed   $data
     * @param  string  $queue
     * @return string
     */
    protected function createPayload(JobContract $job)
    {
        return json_encode($this->createPlainPayload($job));
    }

    /**
     * Create a typical, "plain" queue payload array.
     *
     * @param  JobContract  $job
     * @return array
     */
    protected function createPlainPayload(JobContract $job)
    {
        return [
            'id' => $job->getId(),
            'data' => $job->getData(),
        ];
    }

    /**
     * Prepare any queueable entities for storage in the queue.
     *
     * @param  mixed  $data
     * @return mixed
     */
    protected function prepareQueueableEntities($data)
    {
        if ($data instanceof QueueableEntity) {
            return $this->prepareQueueableEntity($data);
        }

        if (is_array($data)) {
            $data = array_map(function ($d) {
                if (is_array($d)) {
                    return $this->prepareQueueableEntities($d);
                }

                return $this->prepareQueueableEntity($d);
            }, $data);
        }

        return $data;
    }

    /**
     * Prepare a single queueable entity for storage on the queue.
     *
     * @param  mixed  $value
     * @return mixed
     */
    protected function prepareQueueableEntity($value)
    {
        if ($value instanceof QueueableEntity) {
            return '::entity::|'.get_class($value).'|'.$value->getQueueableId();
        }

        return $value;
    }

    /**
     * Set additional meta on a payload string.
     *
     * @param  string  $payload
     * @param  string  $key
     * @param  string  $value
     * @return string
     */
    protected function setMeta($payload, $key, $value)
    {
        $payload = json_decode($payload, true);

        return json_encode(Arr::set($payload, $key, $value));
    }

    /**
     * Calculate the number of seconds with the given delay.
     *
     * @param  \DateTime|int  $delay
     * @return int
     */
    protected function getSeconds($delay)
    {
        if ($delay instanceof \DateTime) {
            return max(0, $delay->getTimestamp() - $this->getTime());
        }

        return (int) $delay;
    }

    /**
     * Get the current UNIX timestamp.
     *
     * @return int
     */
    protected function getTime()
    {
        return time();
    }

    /**
     * Set the encrypter instance.
     *
     * @param  EncrypterContract  $crypt
     * @return void
     */
    public function setEncrypter(EncrypterContract $crypt)
    {
        $this->crypt = $crypt;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}