<?php

class GamePlayer extends GameEntity {

    var $name = null, $conId, $x, $y;

    public function __construct($conId, $world, $name, $id) {
        parent::__construct($world, $id);
        $this->conId = $conId;
        $this->name = $name;
        $this->setCoords();
    }

    public function isGameMaster() {
        if ($this->getPlayer()->getGameMaster()) {
            MESSAGE::send($this, [REQUESTMAPCHANGE => ["granted" => 1]], $this->getWorld()->getServer(), FALSE);
        } else {
            MESSAGE::send($this, [MESSAGE => ["message" => "sorry you are not a Gamemaster"]], $this->getWorld()->getServer(), FALSE);
        }
    }

    public function getWorld() {
        return $this->world;
    }

    public function setCoords() {
        $user = $this->getPlayer();
        $this->x = $user->getX();
        $this->y = $user->getY();
    }

    public function setOffline() {
        $user = $this->getPlayer();
        $user->setConId(NOID);
        $user->setOnline(FALSE);
        $this->getWorld()->getDatabaseManager()->persist($user);
        $this->getWorld()->getDatabaseManager()->flush();
    }

    public static function login($name, $pwd, $clientID, $world) {
        $user = $world->getDatabaseManager()->getRepository("Player")->findOneBy(array("name" => $name));
        if ($user && $user->getPwd() === $pwd) {
            $user->setOnline(TRUE);
            $user->setConId($clientID);
            $user->setLastJoin(time());
            $user->setIp($world->getServer()->wsClients[$clientID][6]);
            $world->getDatabaseManager()->persist($user);
            $world->getDatabaseManager()->flush();
            $world->onJoin($clientID, $user->getId(), $name);
            Message::send($world->getPlayerByClientId($clientID), [INITIAL => ["name" => $user->getName(), "id" => $user->getId(), "x" => $user->getX(), "y" => $user->getY(), "h" => $user->getHp(), "sprite" => $user->getSprite()]], $world->getServer(), FALSE);
            return true;
        } else {
            $world->getServer()->wsSend($clientID, (JsonGenerator::getJson([KICK => ["message" => "Login failed"]])));
            return false;
        }
    }

    public function getPlayer() {
        return $this->getWorld()->getDatabaseManager()->getRepository("Player")->findOneBy(array("name" => $this->name));
    }

    public function getMap() {
        return $this->getPlayer()->getMap();
    }

    public function getConId() {
        return $this->conId;
    }

    public function getOnline() {
        return $this->getPlayer()->getOnline();
    }

    public static function createPlayer($name, $pwd, $email, $sprite, $clientID, $world) {
        $checkPlayer = $world->getDatabaseManager()->getRepository("Player")->findOneBy(array("name" => $name));
        if ($checkPlayer) {
            $world->getServer()->wsSend($clientID, (JsonGenerator::getJson([KICK => ["message" => "user already existing"]])));
            return false;
        }
        $player = new Player();
        $player->setConId($clientID);
        $player->setName($name);
        $player->setPwd($pwd);
        $player->setLevel(0);
        $player->setExperience(0);
        $map = GameMap::getMapAt(STARTMAP, $world->getDatabaseManager());
        $player->setX($map->getStartX());
        $player->setY($map->getStartY());
        $player->setMap($map);
        $map->addPlayer($player);
        $player->setHp(MAXHP);
        $player->setSprite($sprite);
        $player->setEmail($email);
        $world->getDatabaseManager()->persist($player);
        $world->getDatabaseManager()->flush();
        $world->getDatabaseManager()->persist($map);
        $world->getDatabaseManager()->flush();
        $world->log("New Player ($name) registrated");
        $world->getServer()->wsSend($clientID, (JsonGenerator::getJson([KICK => ["message" => "successfully registrated"]])));
    }

    public function saveCoords() {
        $em = $this->getWorld()->getDatabaseManager();
        $user = $this->getPlayer();
        $user->setX($this->x);
        $user->setY($this->y);
        $em->persist($user);
        $em->flush();
    }

    public function changeMap($accesspoint) {
        if ($accesspoint) {
            MESSAGE::send($this, [CHANGEMAP => ["message" => "Walking to " . $accesspoint->getToMap()->getName()]], $this->getWorld()->getServer(), FALSE);
            $map = $this->getMap();
            $user = $this->getPlayer();
            $map->removePlayer($user);
            $this->getWorld()->getDatabaseManager()->persist($map);
            Message::sendToAll($this->getMap()->getPlayers(), [LEFT => ["id" => $this->getPlayer()->getID()]], $this->getWorld()->getServer(), FALSE);
            $user->setMap($accesspoint->getToMap());
            $newmap = $accesspoint->getToMap();
            $newmap->addPlayer($this->getPlayer());
            $this->x = ($accesspoint->getToMap()->getStartX());
            $this->y = ($accesspoint->getToMap()->getStartY());
            $user->setX($this->x);
            $user->setY($this->y);
            $this->getWorld()->getDatabaseManager()->persist($user);
            $this->getWorld()->getDatabaseManager()->flush();
            $this->getWorld()->getMapById($this->getMap()->getId())->propagateMap($this);
            Message::send($this, [INITIAL => ["name" => $user->getName(), "id" => $user->getId(), "x" => $this->x, "y" => $this->y, "h" => $user->getHp(), "sprite" => $user->getSprite()]], $this->getWorld()->getServer(), FALSE);
        }
    }

    public function move($direction) {
        $newx = $this->x;
        $newy = $this->y;
        $mapGraph = $this->getWorld()->getMapById($this->getMap()->getId())->mapArray;
        switch ($direction) {
            case 0 :
                $newx = $this->x + SPEED;
                break;
            case 1:
                $newx = $this->x - SPEED;
                break;
            case 2:
                $newy = $this->y + SPEED;
                break;
            case 3:
                $newy = $this->y - SPEED;
                break;
        }
        if (@$mapGraph[floor($newx / 32)][floor($newy / 32)]) {
            foreach ($this->getWorld()->getMapById($this->getMap()->getId())->accessPoints as $accesspoint) {
                if (floor($accesspoint->getX() / 32) == floor($newx / 32) && floor($accesspoint->getY() / 32) == floor($newy / 32)) {
                    $this->changeMap($accesspoint);
                }
            }
            if (abs($this->x - $newx) < 10 && abs($this->y - $newy) < 10) {
                $this->x = ($newx);
                $this->y = ($newy);
                Message::sendToAll($this->getMap()->getPlayers(), [MOVE => ["u" => $this->getPlayer()->getId(), "d" => $direction]], $this->getWorld()->getServer(), FALSE);
            }
        }
    }

}
