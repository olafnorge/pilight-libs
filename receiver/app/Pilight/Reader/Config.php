<?php
namespace Pilight\Reader;


use Pilight\AbstractReader;

/**
 * Class Config
 * @package Pilight\Reader
 */
class Config extends AbstractReader
{
    protected $action = 'request config';
    protected $options = ['config' => 1, 'receiver' => 1];
}