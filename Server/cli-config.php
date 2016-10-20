<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
include 'lib/bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);