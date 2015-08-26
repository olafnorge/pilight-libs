<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Client;


class RegistryPublisher extends Publisher
{
    protected $action = 'registry';
    protected $options = ['core' => 1, 'config' => 1, 'receiver' => 1];

    /**
     * @param array $command
     * @param $callbacks
     * @return bool
     */
    public function publish(array $command, $callbacks = null) {
        return parent::publish($command, $callbacks);
    }
}