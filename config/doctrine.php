<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__.'/..');
$dotenv->load();

return function (): EntityManager {
    $paths = [__DIR__ . '/../src/Domain'];
    $isDevMode = true;
    $config = ORMSetup::createAttributeMetadataConfig(
        $paths,
        $isDevMode,
    );
    $config->enableNativeLazyObjects(true);
    $dbParams = [
        'driver'   => $_ENV['DB_DRIVER'] ?? 'pdo_mysql',
        'user'     => $_ENV['DB_USER'],
        'host'     => $_ENV['DB_HOST'],
        'port'     => $_ENV['DB_PORT'],
        'unix_socket' => $_ENV['DB_SOCKET'],
        'password' => $_ENV['DB_PASSWORD'],
        'dbname'   => $_ENV['DB_NAME'],
    ];
    $connection = DriverManager::getConnection($dbParams, $config);
    return new EntityManager($connection, $config);
};
