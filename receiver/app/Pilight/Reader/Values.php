<?php
namespace Pilight\Reader;


use Pilight\AbstractReader;

/**
 * Class Values
 * @package Pilight\Reader
 */
class Values extends AbstractReader
{
    protected $action = 'request values';
    protected $options = ['receiver' => 1];
}