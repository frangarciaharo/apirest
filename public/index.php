<?php
require_once __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

require __DIR__ .'/bootstrap.php';
use App\Http\Request;

$request = new Request();

$app->dispatch($request, $entityManager);