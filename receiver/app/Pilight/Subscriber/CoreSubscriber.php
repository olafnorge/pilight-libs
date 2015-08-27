<?php
namespace Pilight\Subscriber;


final class CoreSubscriber extends Subscriber
{
    protected $filters = ['core'];
    protected $options = ['core' => 1];
}