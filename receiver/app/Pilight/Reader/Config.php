<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Reader;


use Pilight\AbstractReader;

class Config extends AbstractReader
{
    protected $action = 'request config';
    protected $options = ['config' => 1, 'receiver' => 1];
}