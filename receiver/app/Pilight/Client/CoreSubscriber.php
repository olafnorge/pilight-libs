<?php
namespace Pilight\Client;


final class CoreSubscriber extends Subscriber
{
    protected $filters = ['core'];
    protected $options = ['core' => 1];
}