<?php
namespace Pilight\Subscriber;


use Pilight\AbstractSubscriber;

/**
 * Class Stats
 * @package Pilight\Subscriber
 */
final class Stats extends AbstractSubscriber
{
    protected $filters = ['core'];
    protected $options = ['stats' => 1];
}