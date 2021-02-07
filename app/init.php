<?php
error_reporting(0);
include 'config.php';
if (!session_id()) @session_start();

use League\Plates\Engine;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use Tamtamchik\SimpleFlash\Flash;

$builder = new DI\ContainerBuilder();
$builder->addDefinitions([
    Engine::class => function () {
        return new Engine('../app/views');
    },
    PDO::class => function () {
        return new PDO('mysql:host=' . DB_HOST.':'.DB_PORT . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
    },
    QueryFactory::class => function () {
        return new QueryFactory ('mysql');
    },
    Auth::class => function ($builder) {
        return new Auth ($builder->get('PDO'));
    }
]);
