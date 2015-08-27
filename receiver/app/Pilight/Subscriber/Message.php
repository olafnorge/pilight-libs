<?php
namespace Pilight\Subscriber;

use Pilight\AbstractSubscriber;

/**
 * Class Message
 * @package Pilight\Subscriber
 */
final class Message extends AbstractSubscriber
{
    protected $filters = ['receiver', 'sender'];
    protected $options = ['receiver' => 1];
}
