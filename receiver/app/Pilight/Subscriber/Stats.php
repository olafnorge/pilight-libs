<?php
namespace Pilight\Subscriber;


final class Stats extends Subscriber
{
    protected $filters = ['core'];
    protected $options = ['stats' => 1];
}