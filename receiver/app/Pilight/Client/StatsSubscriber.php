<?php
namespace Pilight\Client;


final class StatsSubscriber extends Subscriber
{
    protected $filters = ['core'];
    protected $options = ['stats' => 1];
}