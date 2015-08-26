<?php
namespace Pilight\Client;


final class ConfigSubscriber extends Subscriber
{
    protected $filters = ['config'];
    protected $options = ['config' => 1];
}