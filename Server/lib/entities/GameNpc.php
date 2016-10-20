<?php

class GameNpc extends GameEntity {

    var $name;

    function _construct($world, $name, $id) {
        parent::_construct($world, $id);
        $this->name = $name;
    }

    public function buildNpcString() {
        $npc = $this->getNpc();
        return ["x" => $npc->getX(), "y" => $npc->getY(), "sprite" => $npc->getSprite(), "name" => $this->name, "speech" => $npc->getSpeech()];
    }

    public function getMap() {
        return $this->getNpc()->getMap();
    }

    public function getNpc() {
        return $this->world->getDatabaseManager()->getRepository("Npc")->find($this->id);
    }

    function update() {
        
    }

}
