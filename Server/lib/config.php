<?php

require_once("lib/bootstrap.php");
DEFINE("TICKRATE", "60");
DEFINE("IP", "127.0.0.1");
DEFINE("TILESIZE", "32");
DEFINE("STARTMAP", 1);
DEFINE("MAXHP",100);
DEFINE("NOID",-1);
DEFINE("SPEED",2);

DEFINE("LOGIN", 0); // Login => [u => "user",p => "pwd"]
DEFINE("REGISTER", 1); // REGISTER => [e => "email",u => "user",p => "pwd"]
DEFINE("MOVE", 2); // MOVE => ["u" => "userid" , d = "num"] 0 right 1 left 2 up 3 down
DEFINE("MAP", 3); // MAP => [x => "x" , y => "y" , w = "boolean" , sprite = "path" , frame = "num" ,layer = "num", id ="num"]
DEFINE("INITIAL", 4); // INITIAL => [name ="bla" , id => "num" ,x => "x" , y => "y" , sprite => "sprite" , health => "health"]
DEFINE("ADDTILE", 5); // ADDTILE => [map => "num",x => "x" , y => "y" , w = "boolean" , sprite = "path" , frame = "num" ,layer = "num"]
DEFINE("DELTILE", 6); // DELTILE => [map => "num" , id => "num"]
DEFINE("REQUESTMAPCHANGE", 7); // REQUESTMAPCHANGE => [granted => "boolean"]
DEFINE("GETMAPID", 8); // GETMAPID => ["name" => "name" ,"width" = > "num", "height" => "num", id => "num"]
DEFINE("GETCONID", 9); // GETCONID => [id => "num"]
DEFINE("PLAYER", 10); // PLAYER => ["name" => bla ,id => "num" ,x => "x" , y => "y" , sprite => "sprite" , health => "health"]
DEFINE("REQUESTREFRESH", 11); // REQUESTREFRESH => []
DEFINE("KICK", 12); // KICK => [message => "text"]
DEFINE("LEFT", 13); // LEFT => [id = "num"]
DEFINE("UPDATETILE", 14); // UPDATETILE => [map=> "num",id => "num",layer => "num" , walkable => "boolean"]]
DEFINE("CHANGEMAP", 15); // CHANGEMAP =>[message => "msg" ]
DEFINE("REFRESHMAP", 16); // REFRESHMAP => []
DEFINE("MESSAGE", 17); // MESSAGE => {message => "text"}
DEFINE("TALK", 18); // TALK => {t => "text",p => "pid"}
DEFINE("NPC", 19); // NPC => {x,y,name,sprite,speech}
DEFINE("ITEM",20); // ITEM [name,armor,damage,sprite]