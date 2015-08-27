<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Publisher;


class Config extends Publisher
{
    protected $action = 'request config';
    protected $options = ['config' => 1, 'receiver' => 1];

    /**
     * @return array
     */
    public function publish() {
        return parent::publish([], [$this, 'evaluate']);
    }
}