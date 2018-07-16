<?php
/**
 * This file is part of project queue-bundle.
 *
 * Author: Jaggle
 * Create: 2018-07-16 15:48:56
 */

namespace Jaggle\QueueBundle;

class EntityResolver
{
    /**
     * @param $object
     * @return QueueableEntity
     */
    public function resolve($type, $id)
    {
        return new QueueableEntity();
    }
}