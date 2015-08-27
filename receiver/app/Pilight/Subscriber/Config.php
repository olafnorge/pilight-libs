<?php
namespace Pilight\Subscriber;


final class Config extends Subscriber
{
    protected $filters = ['config'];
    protected $options = ['config' => 1];
}