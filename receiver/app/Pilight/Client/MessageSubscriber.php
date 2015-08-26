<?php
namespace Pilight\Client;

final class MessageSubscriber extends Subscriber
{
    protected $filters = ['receiver', 'sender'];
    protected $options = ['receiver' => 1];
}
