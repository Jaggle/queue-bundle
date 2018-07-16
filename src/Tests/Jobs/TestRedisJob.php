<?php
/**
 * This file is part of project queue-bundle.
 *
 * Author: Jaggle
 * Create: 2018-07-16 20:12:41
 */

namespace Jaggle\QueueBundle\Tests\Jobs;

use Jaggle\QueueBundle\RedisJob;

class TestRedisJob extends RedisJob
{
    public function fire()
    {
        return $this->getId() . ' has fired!';
    }
}