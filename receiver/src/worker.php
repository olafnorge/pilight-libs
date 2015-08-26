<?php
require_once '../vendor/autoload.php';

use Elasticsearch\Client;
use Pilight\Client\ConfigSubscriber;
use Pilight\Client\ConfigPublisher;
use Pilight\Client\ControlPublisher;
use Pilight\Client\CoreSubscriber;
use Pilight\Client\ForwardSubscriber;
use Pilight\Client\Heartbeat;
use Pilight\Client\RegistryPublisher;
use Pilight\Client\SendPublisher;
use Pilight\Client\StatsSubscriber;
use Pilight\Client\ValuesPublisher;
use Pilight\Host\Host;
use Pilight\Client\MessageSubscriber;

try {
    $Client = new Client(['hosts' => ['elastic.olafnorge.de']]);
    $Host = new Host();

    print_r([$Host->getIp(), $Host->getPort()]);
    //exit;

    //$Receiver = new ConfigReceiver($Host);
    //$Receiver = new CoreReceiver($Host);
    //$Receiver = new ForwardReceiver($Host);
    //$Receiver = new MessageReceiver($Host);
    //$Receiver = new StatsReceiver($Host);

    //$Requester = new ConfigRequester($Host);
    //$Requester = new ControlRequester($Host);
    //$Requester = new RegistryRequester($Host);
    $Requester = new SendPublisher($Host);
    //$Requester = new ValuesRequester($Host);

    //$Requester = new Heartbeat($Host);

    //print_r($Requester->execute(['code' => ['device' => 'switch_kitchen', 'state' => 'on'], 'uuid' => '0000-b8-27-eb-ee9290']));
    var_dump($Requester->publish(['code' => ['protocol' => ['duwi3'], 'id' => 0, 'unit' => 0, 'on' => 1, 'uuid' => '0000-b8-27-eb-135d8f']]));
    //print_r($Requester->execute(['type' => 'get', 'key' => 'pilight.version.current']));
    //print_r($Requester->execute());
    exit;

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