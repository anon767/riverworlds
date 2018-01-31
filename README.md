# Riverworlds

A simple MMORPG programmed in PHP (server-side) and JavaScript (client-side)

## Quick demo

![game screen](https://raw.githubusercontent.com/anon767/riverworlds/master/riverworlds1.gif "game screen")

![editor](https://raw.githubusercontent.com/anon767/riverworlds/master/riverworlds2.gif "EDITOR")


## Dependencies
1. Mysql Server
2. PHP
## What

I programmed this small game for educational purposes some years ago. Basically an extensible multiplayer browsergame.
The client and server communicate over Websockets.

## usage

```
git clone https://github.com/anon767/riverworlds.git
cd riverworlds/Server
php composer.phar update
```

Then adjust the config in Server/lib/bootstrap.php to your needs.
Afterwards

```
php vendor/doctrine/orm/bin/doctrine orm:schema-tool:create
php server.php
```

open the your browser and start the client over the browser

