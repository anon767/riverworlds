<?php

use Doctrine\ORM\Tools\Setup,
    Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";
foreach (glob("./db/dbmaps/src/*.php") as $filename) {
    include_once $filename;
}
$isDevMode = true;
$config = Setup::createYAMLMetadataConfiguration(array("./db/dbmaps/yaml"), $isDevMode);
$conn = array(
    'driver' => "mysqli",
    'user' => "root",
    'password' => "test123",
    'dbname' => "riverworlds",
    'host' => "localhost",
    'charset' => "utf-8"
);
$entityManager = EntityManager::create($conn, $config);
$entityManager->getEventManager()->addEventSubscriber(
        new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit('utf8', 'utf8_unicode_ci')
);



