<?php
namespace Pilight\Subscriber;


use Pilight\AbstractSubscriber;

/**
 * Class Core
 * @package Pilight\Subscriber
 */
final class Core extends AbstractSubscriber
{
    protected $filters = ['core'];
    protected $options = ['core' => 1];
}