<?php

require dirname(__DIR__, 4) . '/vendor/autoload.php';

$entityManagerFactory = require dirname(__DIR__, 4) . '/config/doctrine.php';

$entityManager = $entityManagerFactory();

return $entityManager;