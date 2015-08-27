<?php
namespace Pilight\Command;


use Pilight\AbstractCommand;

/**
 * Class Control
 * @package Pilight\Command
 */
class Control extends AbstractCommand
{
    protected $action = 'control';
    protected $options = ['receiver' => 1];

    /**
     * @param array $command
     * @return bool
     */
    public function control(array $command) {
        return parent::execute($command, [$this, 'evaluate']) === ['status' => 'success'];
    }
}