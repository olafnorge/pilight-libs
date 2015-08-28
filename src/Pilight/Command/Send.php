<?php
namespace Pilight\Command;


use Pilight\AbstractCommand;

/**
 * Class Send
 * @package Pilight\Command
 */
class Send extends AbstractCommand
{
    protected $action = 'send';
    protected $options = ['receiver' => 1];

    /**
     * @param array $command
     * @return bool
     */
    public function send(array $command) {
        return parent::execute($command, [$this, 'evaluate']) === ['status' => 'success'];
    }
}