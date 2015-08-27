<?php
namespace Pilight\Subscriber;


use Pilight\AbstractSubscriber;

/**
 * Class Forward
 * @package Pilight\Subscriber
 */
final class Forward extends AbstractSubscriber
{
    protected $options = ['forward' => 1];
}