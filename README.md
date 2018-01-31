# Riverworlds

A simple MMORPG programmed in PHP (server-side) and JavaScript (client-side)

##quick demo



## Dependencies
1. Mysql Server
2. PHP

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

