<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Command;


use Pilight\AbstractCommand;

class Registry extends AbstractCommand
{
    protected $action = 'registry';
    protected $options = ['core' => 1, 'config' => 1, 'receiver' => 1];

    /**
     * @param array $command
     * @param $callbacks
     * @return bool
     */
    public function write(array $command, $callbacks = null) {
        return parent::write($command, $callbacks);
    }
}