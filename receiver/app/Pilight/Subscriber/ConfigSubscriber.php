<?php
namespace Pilight\Subscriber;


final class ConfigSubscriber extends Subscriber
{
    protected $filters = ['config'];
    protected $options = ['config' => 1];
}