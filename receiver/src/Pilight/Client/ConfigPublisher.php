<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Client;


class ConfigPublisher extends Publisher
{
    protected $action = 'request config';
    protected $options = ['config' => 1, 'receiver' => 1];

    /**
     * @param $callbacks
     * @return bool
     */
    public function publish($callbacks = null) {
        return parent::publish([], $callbacks);
    }
}