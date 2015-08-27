<?php
/**
 * Created by PhpStorm.
 * User: volker
 * Date: 24.08.15
 * Time: 22:22
 */

namespace Pilight\Reader;


use Pilight\AbstractReader;

class Values extends AbstractReader
{
    protected $action = 'request values';
    protected $options = ['receiver' => 1];
}