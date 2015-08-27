<?php
namespace Pilight\Subscriber;

use Pilight\AbstractSubscriber;

final class Message extends AbstractSubscriber
{
    protected $filters = ['receiver', 'sender'];
    protected $options = ['receiver' => 1];
}
