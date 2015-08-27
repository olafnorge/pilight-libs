<?php
namespace Pilight\Subscriber;


use Pilight\AbstractSubscriber;

final class Forward extends AbstractSubscriber
{
    protected $options = ['forward' => 1];
}