<?php

class GameMap extends GameEntity {

    var $players,  $mapArray, $accessPoints = [], $npcs = [];

    public function __construct( $id, $world) {
        parent::__construct($world,$id);
        $this->buildGraph();
        $this->buildAccessPoints();
        $this->buildNpcArray();
    }

    public function getNpcs(){
        return $this->getMap()->getNpcs();
    }
    
    private function buildNpcArray(){
        foreach($this->getNpcs() as $npc){
            $this->npcs[] = new GameNpc($this->world,$npc->getName(),$npc->getId());
            $this->world->npcs++;
        }
    }
    public function propagateNpcs($player){
        foreach($this->npcs as $npc){
            MESSAGE::send($player, [NPC => $npc->buildNpcString()], $this->world->getServer(), FALSE);
        }
    }
    private function buildGraph() {
        $this->mapArray = [];
        foreach ($this->getTiles() as $tile) {
            if (!is_array(@$this->mapArray[$tile->getX()])) {
                $this->mapArray[$tile->getX()] = [];
            }
            @$this->mapArray[$tile->getX()][$tile->getY()] = $this->mapArray[$tile->getX()][$tile->getY()] ? true : $tile->getWalkable();
        }
    }

    private function getSingleTile($tileId) {
        $tile = $this->world->getDatabaseManager()->find("Tile", $tileId);
        if ($tile) {
            return [MAP => [["x" => $tile->getX(), "y" => $tile->getY(), "w" => $tile->getWalkable(), "sprite" => $tile->getSprite(), "frame" => $tile->getFrame(), "layer" => $tile->getLayer(), "id" => $tile->getId()]]];
        } else {
            return false;
        }
    }

    private function buildMapString() {
        $array = array();
        foreach ($this->getTiles() as $num => $tile) {
            $array[$num] = ["x" => $tile->getX(), "y" => $tile->getY(), "w" => $tile->getWalkable(), "sprite" => $tile->getSprite(), "frame" => $tile->getFrame(), "layer" => $tile->getLayer(), "id" => $tile->getId()];
        }
        return [MAP => $array];
    }

    public static function getMapAt($index, $em) {
        return $em->find("Map", $index);
    }

    public function buildAccessPoints() {
        $accesspoints = $this->world->getDatabaseManager()->getRepository("AccessPoint")->findBy(array("fromMap" => $this->getMap()->getId()));
        foreach ($accesspoints as $access) {
            if ($access && $access->getFromMap()->getId() == $this->getMap()->getId()) {
                $this->accessPoints[] = $access;
            }
        }
    }

    public function addTile($x, $y, $walkable, $sprite, $frame, $layer, $clientID = null) {
        if ($clientID && !$this->world->players[$clientID]->getPlayer()->getGameMaster()) {
            return;
        }
        $tile = new Tile();
        $tile->setFrame($frame);
        $tile->setLayer($layer);
        $tile->setSprite($sprite);
        $tile->setWalkable($walkable);
        $tile->setX($x);
        $tile->setY($y);
        $tile->setMap($this->getMap());
        $this->world->getDatabaseManager()->persist($tile);
        $this->getMap()->addTile($tile);
        $this->world->getDatabaseManager()->persist($this->getMap());
        $this->world->getDatabaseManager()->flush();
        if ($clientID) {
            Message::sendToAll($this->getPlayers(), $this->getSingleTile($tile->getId()), $this->world->server, 0, $clientID);
        }
    }

    public function delTile($id, $clientID = null) {
        if ($clientID && !$this->world->players[$clientID]->getPlayer()->getGameMaster()) {
            return;
        }
        $t = $this->world->getDatabaseManager()->find("Tile", $id);
        if ($t) {
            $this->getMap()->removeTile($t);
        }
    }

    public function updateTile($id, $layer, $walkable, $clientID) {
        if ($clientID && !$this->world->players[$clientID]->getPlayer()->getGameMaster()) {
            return;
        }
        $tile = $this->world->getDatabaseManager()->getRepository("Tile")->find($id);
        $tile->setLayer($layer);
        $tile->setWalkable($walkable);
        $this->world->getDatabaseManager()->persist($tile);
        $this->world->getDatabaseManager()->flush();
    }

    public function propagatePlayers() {
        $players = $this->getPlayers();
        foreach ($players as $user) {
            foreach ($players as $player) {
                if ($user->getId() !== $player->getId() && $user->getOnline() && $user->getConId()) {
                    Message::send($player, [PLAYER => ["name" => $user->getName(), "id" => $user->getId(), "x" => $this->world->players[$user->getConId()]->x, "y" => $this->world->players[$user->getConId()]->y, "h" => $user->getHp(), "sprite" => $user->getSprite()]], $this->world->server, FALSE);
                }
            }
        }
    }

    public function propagateMap($player) {
        $this->buildGraph();
        Message::send($player, JsonGenerator::getJson([GETMAPID => ["name" => $this->getMap()->getName(), "width" => $this->getMap()->getWidth(), "height" => $this->getMap()->getHeight(), "id" => $this->getMap()->getId()]]), $this->world->server, 1);
        Message::send($player, JsonGenerator::getJson($this->buildMapString()), $this->world->server, 1);
        $this->propagatePlayers();
    }

    public function getTiles() {
        return $this->getMap()->getTiles();
    }

    public function getMap() {
        return $this->world->getDatabaseManager()->find("Map", $this->id);
    }

    public function getPlayers() {
        return $this->getMap()->getPlayers();
    }

}
