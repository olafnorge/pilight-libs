<?php
namespace Pilight\Subscriber;


use Pilight\AbstractSubscriber;

/**
 * Class Config
 * @package Pilight\Subscriber
 */
final class Config extends AbstractSubscriber
{
    protected $filters = ['config'];
    protected $options = ['config' => 1];
}