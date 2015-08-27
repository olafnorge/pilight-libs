<?php
namespace Pilight\Command;


use Pilight\AbstractCommand;

/**
 * Class Registry
 * @package Pilight\Command
 */
class Registry extends AbstractCommand
{
    protected $action = 'registry';
    protected $options = ['core' => 1, 'config' => 1, 'receiver' => 1];

    /**
     * @param string $key
     * @return bool
     */
    public function remove($key) {
        $command = ['key' => $key, 'type' => 'remove'];
        return $this->execute($command, [$this, 'evaluate']) === ['status' => 'success'];
    }

    /**
     * @param string $key
     * @param string|int $value
     * @return bool
     */
    public function set($key, $value) {
        $command = ['key' => $key, 'value' => $value, 'type' => 'set'];
        return $this->execute($command, [$this, 'evaluate']) === ['status' => 'success'];
    }
}