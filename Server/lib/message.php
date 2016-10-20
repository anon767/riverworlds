<?php

class Message {

    public static function sendToAll($array, $message, $server, $json, $exclude = -1) {
        foreach ($array as $player) {
            if ($player->getConId() !== $exclude) {
                Message::send($player, $message, $server, $json);
            }
        }
    }

    public static function send($player, $message, $server, $json) {
        if ($json && $player && $player->getOnline() && isset($server->wsClients[$player->getConId()])) {
            $server->wsSend($player->getConId(), ($message));
        } elseif (!$json && $player && $player->getOnline() && isset($server->wsClients[$player->getConId()])) {
            $server->wsSend($player->getConId(), (JsonGenerator::getJson($message)));
        } 
    }

}
