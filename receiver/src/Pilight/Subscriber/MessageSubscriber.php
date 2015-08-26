<?php
namespace Pilight\Subscriber;

final class MessageSubscriber extends Subscriber
{
    protected $filters = ['receiver', 'sender'];
    protected $options = ['receiver' => 1];
}
