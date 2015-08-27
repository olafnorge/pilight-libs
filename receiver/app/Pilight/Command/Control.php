<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Command;


use Pilight\AbstractCommand;

class Control extends AbstractCommand
{
    protected $action = 'control';
    protected $options = ['receiver' => 1];

    /**
     * @param array $command
     * @param $callbacks
     * @return bool
     */
    public function write(array $command, $callbacks = null) {
        return parent::write($command, $callbacks) === ['status' => 'success'];
    }
}