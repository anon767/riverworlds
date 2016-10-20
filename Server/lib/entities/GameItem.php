<?php

class GameItem extends GameEntity {

    var $name;

    function _construct($world, $name, $id) {
        parent::_construct($world, $id);
        $this->name = $name;
    }

    public function buildString() {
        $item = $this->getItem();
        return ["damage" => $item->getDamage(), "armor" => $item->getArmor(), "sprite" => $item->getSprite(), "name" => $this->name];
    }

    public function getItem() {
        return $this->world->getDatabaseManager()->getRepository("Item")->find($this->id);
    }

    function update() {
        
    }

}
