<?php
namespace Pilight\Reader;


use Pilight\AbstractReader;

/**
 * Class Registry
 * @package Pilight\Reader
 */
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