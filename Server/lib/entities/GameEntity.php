<?php

abstract class GameEntity {

    var $id, $world;

    public function __construct($world, $id) {
        $this->world = $world;
        $this->id = $id;
    }
    public function unityTest(){
        
    }
    public function update() {
        
    }

}
