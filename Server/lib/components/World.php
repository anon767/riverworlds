<?php

class World {

    var $server, $maps = array(), $players = array(), $em, $connections = 0, $npcs = 0, $items;

    /**
     * Help Functions
     * 
     * 
     */
    public function getPlayerByClientId($clientID) {
        return isset($this->players[$clientID]) ? $this->players[$clientID] : NULL;
    }

    public function getServer() {
        return $this->server;
    }

    public function log($msg) {
        $this->getServer()->log($msg);
    }

    public function getMapById($id) {
        return $this->maps[$id];
    }

    public function getDatabaseManager() {
        // added reconnect for mysql
        if ($this->em->getConnection()->ping() === false) {
            $this->em->getConnection()->close();
            $this->em->getConnection()->connect();
        }
        return $this->em;
    }

    public function __construct($server, $em) {
        $this->em = $em;
        $this->server = $server;
        $this->buildMap();
        $this->resetPlayer();
        $this->loadItems();
        $this->onLoaded();
    }

    /* Initializations
     * 
     */

    public function loadItems() {
        $items = $this->getDatabaseManager()->getRepository("Item")->findAll();
        foreach ($items as $item) {
            $items[] = new GameItem($this, $item->getId());
        }
    }

    public function resetPlayer() {
        $players = $this->em->getRepository("Player")->findAll();
        $this->log(count($players) . " player has been reseted");
        foreach ($players as $player) {
            $player->setOnline(0);
            $player->setConId(-1);
            $this->em->persist($player);
            $this->em->flush();
        }
    }

    public function buildMap() {
        $this->maps = array();
        $dbMaps = $this->em->getRepository("Map")->findAll();
        foreach ($dbMaps as $map) {
            $this->maps[$map->getId()] = new GameMap($map->getId(), $this);
            if (count($map->getTiles()) == 0) {
                $this->log("map " . $map->getId() . " has no tiles, filling with green");
                for ($i = 0; $i < $map->getHeight(); $i++) {
                    for ($j = 0; $j < $map->getWidth(); $j++) {
                        $this->getMapById($map->getId())->addTile($j, $i, 1, "default_tile", 0, 0);
                    }
                }
            }
        }
    }

    /**
     * Handler
     * 
     */
    public function onConnect($clientID) {
        $this->connections++;
    }

    public function onJoin($clientID, $id, $name) {
        $this->players[$clientID] = new GamePlayer($clientID, $this, $name, $id);
        $this->getMapById($this->getPlayerByClientId($clientID)->getMap()->getId())->propagateMap($this->getPlayerByClientId($clientID));
        $this->log("($clientID) ($name) on map " . $this->getPlayerByClientId($clientID)->getMap()->getId() . " joined");
        $this->getMapById($this->getPlayerByClientId($clientID)->getMap()->getId())->propagateNpcs($this->players[$clientID]);
    }

    public function onClose($clientID) {
        $p = $this->getPlayerByClientId($clientID);
        if ($p) {
            Message::sendToAll($p->getMap()->getPlayers(), [LEFT => ["id" => $this->players[$clientID]->getPlayer()->getID()]], $this->server, 0);
            $p->setOffline();
            $p->saveCoords();
            unset($this->players[$clientID]);
            $this->log("($clientID) left");
        }
    }

    private function filterMessage($array, $message, $clientID) {
        if ($array[TALK]['p'] == $this->getPlayerByClientId($clientID)->getPlayer()->getId()) {
            Message::sendToAll($this->getPlayerByClientId($clientID)->getMap()->getPlayers(), $message, $this->server, 1);
        } else {
            $this->log("($clientID) tried to spoof message");
        }
    }

    public function onLoaded() {
        $this->log(count($this->maps) . " Maps has been built");
        $this->log($this->npcs . " Npcs loaded");
        $this->log(count($this->items) . " Items loaded");
    }

    public function onMessage($message, $clientID) {
        $array = JsonGenerator::getArray($message);
        if (!is_array($array)) {
            $this->log("received unparseable: ($message)");
            return;
        }
        $keys = key($array);
        switch ($keys) {
            case REGISTER:
                GamePlayer::createPlayer($array[REGISTER]["u"], $array[REGISTER]["p"], $array[REGISTER]["e"], $array[REGISTER]["s"], $clientID, $this);
                break;
            case LOGIN:
                GamePlayer::login($array[LOGIN]["u"], $array[LOGIN]["p"], $clientID, $this);
                break;
            case ADDTILE:
                $this->getMapById($array[ADDTILE]["map"])->addTile($array[ADDTILE]["x"], $array[ADDTILE]["y"], $array[ADDTILE]["w"], $array[ADDTILE]["sprite"], $array[ADDTILE]["frame"], $array[ADDTILE]["layer"], $clientID);
                break;
            case DELTILE:
                $this->getMapById($array[DELTILE]["map"])->delTile($array[DELTILE]["id"], $clientID);
                break;
            case REQUESTMAPCHANGE:
                if ($this->getPlayerByClientId($clientID)) {
                    $this->getPlayerByClientId($clientID)->isGameMaster();
                }
                break;
            case MOVE:
                if ($this->getPlayerByClientId($clientID)) {
                    $this->getPlayerByClientId($clientID)->move($array[MOVE]["d"]);
                }
                break;
            case REQUESTREFRESH:
                if ($this->getPlayerByClientId($clientID)) {
                    $this->getMapById($this->getPlayerByClientId($clientID)->getMap()->getId())->propagatePlayers();
                }
                break;
            case UPDATETILE:
                $this->getMapById($array[UPDATETILE]["map"])->updateTile($array[UPDATETILE]["id"], $array[UPDATETILE]["layer"], $array[UPDATETILE]["walkable"], $clientID);
                break;
            case REFRESHMAP:
                $this->getMapById($this->getPlayerByClientId($clientID)->getMap()->getId())->propagateMap($clientID);
                break;
            case TALK:
                if ($this->getPlayerByClientId($clientID)->getMap()) {
                    $this->filterMessage($array, $message, $clientID);
                }
                break;
            default:
                $this->log("Message: ($message) could not be handled");
                break;
        }
    }

    public function update() {
        if (count($this->players) > 0) {
            foreach ($this->players as $player) {
                $player->update();
            }
        }
    }

}
