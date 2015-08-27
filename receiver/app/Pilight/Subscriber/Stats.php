<?php
namespace Pilight\Subscriber;


use Pilight\AbstractSubscriber;

final class Stats extends AbstractSubscriber
{
    protected $filters = ['core'];
    protected $options = ['stats' => 1];
}