<?php

namespace App\Helpers;

use Bluerhinos\phpMQTT;

class MqttHelper
{
    public static function publishMessage($topic, $message)
    {
        $server = "mqtt.my.id";
        $port = 1883; // Port default MQTT
        $client_id = "laravel-client";

        $mqtt = new phpMQTT($server, $port, $client_id);

        if ($mqtt->connect()) {
            $mqtt->publish($topic, $message, 0);
            $mqtt->close();
            return true;
        }

        return false;
    }
}
