<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Client;


class ValuesPublisher extends Publisher
{
    protected $action = 'request values';
    protected $options = ['core' => 1, 'config' => 1, 'receiver' => 1];

    /**
     * @param $callbacks
     * @return bool
     */
    public function publish($callbacks = null) {
        return parent::publish([], $callbacks);
    }
}