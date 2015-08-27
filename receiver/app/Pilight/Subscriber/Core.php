<?php
namespace Pilight\Subscriber;


use Pilight\AbstractSubscriber;

final class Core extends AbstractSubscriber
{
    protected $filters = ['core'];
    protected $options = ['core' => 1];
}