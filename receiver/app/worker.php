<?php
require_once '../vendor/autoload.php';

use Elasticsearch\Client;
use Pilight\Subscriber\ConfigSubscriber;
use Pilight\Publisher\ConfigPublisher;
use Pilight\Publisher\ControlPublisher;
use Pilight\Subscriber\CoreSubscriber;
use Pilight\Subscriber\ForwardSubscriber;
use Pilight\Client\Heartbeat;
use Pilight\Publisher\RegistryPublisher;
use Pilight\Publisher\SendPublisher;
use Pilight\Subscriber\StatsSubscriber;
use Pilight\Publisher\ValuesPublisher;
use Pilight\Host\Host;
use Pilight\Subscriber\MessageSubscriber;

try {
    $Client = new Client(['hosts' => ['elastic.olafnorge.de']]);
    $Host = new Host('192.168.6.7', 5000);

    print_r([$Host->getIp(), $Host->getPort()]);
    //exit;

    //$Receiver = new ConfigReceiver($Host);
    //$Receiver = new CoreReceiver($Host);
    //$Receiver = new ForwardReceiver($Host);
    $Receiver = new MessageSubscriber($Host);
    //$Receiver = new StatsReceiver($Host);

    //$Requester = new ConfigPublisher($Host);
    //$Requester = new ControlRequester($Host);
    //$Requester = new RegistryRequester($Host);
    //$Requester = new SendPublisher($Host);
    //$Requester = new ValuesPublisher($Host);

    //$Requester = new Heartbeat($Host);

    //print_r($Requester->execute(['code' => ['device' => 'switch_kitchen', 'state' => 'on'], 'uuid' => '0000-b8-27-eb-ee9290']));
    //var_dump($Requester->publish(['code' => ['protocol' => ['duwi3'], 'id' => 0, 'unit' => 0, 'on' => 1, 'uuid' => '0000-b8-27-eb-135d8f']]));
    //print_r($Requester->execute(['type' => 'get', 'key' => 'pilight.version.current']));
    //print_r($Requester->publish());

    $Receiver->execute(function ($message) use ($Client) {
        print_r($message);

        /*$exclude = ['datetime'];

        if (!in_array($message['protocol'], $exclude)) {
            $document = [
                'body' => $body,
                'index' => 'pilight',
                'type' => 'pilight',
            ];

            //$Client->create($document);

            print_r($message);
        }*/
    });
} catch (\Exception $Exception) {
    echo $Exception->getMessage() . PHP_EOL;
}