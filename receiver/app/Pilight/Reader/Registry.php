<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Reader;


use Pilight\AbstractReader;

class Registry extends AbstractReader
{
    protected $action = 'registry';
    protected $command = ['type' => 'get'];
    protected $options = ['core' => 1, 'config' => 1, 'receiver' => 1];

    /**
     * @param string $key
     * @param $callbacks
     * @return bool
     */
    public function read($key, $callbacks = null) {
        $this->command = array_merge(['key' => $key], $this->command);
        return parent::read($callbacks);
    }
}