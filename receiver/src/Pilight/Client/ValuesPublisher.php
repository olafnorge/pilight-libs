<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Client;


class ValuesPublisher extends Publisher
{
    protected $action = 'request values';
    protected $options = ['receiver' => 1];

    /**
     * @return array
     */
    public function publish()
    {
        return parent::publish([], [$this, 'evaluate']);
    }
}