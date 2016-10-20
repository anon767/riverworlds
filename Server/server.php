<?php

set_time_limit(0);
include "lib/message.php";
include "lib/entities/GameEntity.php";
include "lib/entities/GamePlayer.php";
include "lib/entities/GameNpc.php";
include "lib/entities/GameItem.php";
include "lib/components/GameMap.php";
include "lib/components/World.php";
require_once 'lib/websocket.php';
require_once 'lib/json.php';
require_once 'lib/config.php';
$Server = new PHPWebSocket();
$world = new World($Server, $entityManager);

function wsOnMessage($clientID, $message, $messageLength, $binary, $Server) {
    global $world;
    if ($messageLength === 0) {
        $Server->wsClose($clientID);
        return;
    } else {
        $world->onMessage($message, $clientID);
    }
}

// when a client connects
function wsOnOpen($clientID) {
    global $world;
    $world->onConnect($clientID);
}

// when a client closes or lost connection
function wsOnClose($clientID, $status) {
    global $world;
    $world->onClose($clientID);
}

// start the server
    $Server->bind('message', 'wsOnMessage');
    $Server->bind('open', 'wsOnOpen');
    $Server->bind('close', 'wsOnClose');
// for other computers to connect, you will probably need to change this to your LAN IP or external IP,
// alternatively use: gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME']))
    $Server->wsStartServer(IP, 8080, function ($Server) {
        global $world;
        $world->update();
    });

