<?php
namespace Pilight\Subscriber;


use Pilight\AbstractSubscriber;

final class Config extends AbstractSubscriber
{
    protected $filters = ['config'];
    protected $options = ['config' => 1];
}