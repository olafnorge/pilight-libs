<?php
require_once '../vendor/autoload.php';

use Elasticsearch\Client;
use Pilight\Reader\Config as ConfigReader;
use Pilight\Command\Registry as RegistryCommand;
use Pilight\Reader\Config;
use Pilight\Reader\Registry as RegistryReader;
use Pilight\Subscriber\Config as ConfigSubscriber;
use Pilight\Command\Control;
use Pilight\Subscriber\Core;
use Pilight\Subscriber\Forward;
use Pilight\Watchdog;
use Pilight\Command\Registry;
use Pilight\Command\Send;
use Pilight\Subscriber\Stats;
use Pilight\Reader\Values;
use Pilight\Host;
use Pilight\Subscriber\Message;

try {
    $Client = new Client(['hosts' => ['elastic.olafnorge.de']]);
    $Host = new Host('192.168.6.7', 5000);

    //$Receiver = new CoreReceiver($Host);
    //$Receiver = new ForwardReceiver($Host);
    //$Receiver = new Message($Host);
    //$Receiver = new StatsReceiver($Host);

    //$Requester = new ConfigPublisher($Host);
    //$Requester = new ControlRequester($Host);

    $Requester = new RegistryCommand($Host);
    print_r([$Requester->set('olafnorge.value', 5)]);
    //print_r([$Requester->remove('olafnorge.value')]);

    //$Requester = new RegistryReader($Host);
    //$Requester = new SendPublisher($Host);
    //$Requester = new Values($Host);

    //$Requester = new Heartbeat($Host);

    //print_r($Requester->execute(['code' => ['device' => 'switch_kitchen', 'state' => 'on'], 'uuid' => '0000-b8-27-eb-ee9290']));
    //var_dump($Requester->publish(['code' => ['protocol' => ['duwi3'], 'id' => 0, 'unit' => 0, 'on' => 1, 'uuid' => '0000-b8-27-eb-135d8f']]));
    //print_r($Requester->execute(['type' => 'get', 'key' => 'pilight.version.current']));
    //print_r([$Requester->read('olafnorge.value')]);

    $Receiver = new Config($Host);
    print_r($Receiver->read());

    exit;

    $Receiver->listen(function ($message) use ($Client) {
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