<?php
namespace Pilight\Subscriber;

final class Message extends Subscriber
{
    protected $filters = ['receiver', 'sender'];
    protected $options = ['receiver' => 1];
}
