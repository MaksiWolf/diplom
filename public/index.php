<?php 
require '../vendor/autoload.php';
require '../app/init.php';

$containerDI = $builder->build();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', PROJECT_FOLDER, ['\App\Controllers\Posts', 'index']); //

    $r->addRoute('GET', PROJECT_FOLDER.'user/login', ['\App\Controllers\User','login']); //Авторизацию
    $r->addRoute('POST', PROJECT_FOLDER.'user/login', ['\App\Controllers\User','login']); //Авторизацию

    $r->addRoute('GET', PROJECT_FOLDER.'user/register', ['\App\Controllers\User','register']); //регистрация
    $r->addRoute('POST', PROJECT_FOLDER.'user/register', ['\App\Controllers\User','register']); //регистрация

    $r->addRoute('GET', PROJECT_FOLDER.'user/logout', ['\App\Controllers\User','logout']); //выход

    $r->addRoute('GET', PROJECT_FOLDER.'post/insert', ['\App\Controllers\Posts','insertpost']); //Добавить статью
    $r->addRoute('POST', PROJECT_FOLDER.'post/insert', ['\App\Controllers\Posts','insertpost']); //Добавить статью

    $r->addRoute('GET', PROJECT_FOLDER.'post/viev/{id:\d+}', ['\App\Controllers\Posts','viewpost']); //Прочитать
    $r->addRoute('POST', PROJECT_FOLDER.'post/viev/{id:\d+}', ['\App\Controllers\Posts','viewpost']); //Прочитать

    $r->addRoute('GET', PROJECT_FOLDER.'post/edit/{id:\d+}', ['\App\Controllers\Posts','editpost']); //Редактировать
    $r->addRoute('POST', PROJECT_FOLDER.'post/edit/{id:\d+}', ['\App\Controllers\Posts','editpost']); //Редактировать

    $r->addRoute('GET', PROJECT_FOLDER.'post/delete/{id:\d+}', ['\App\Controllers\Posts','deletepostbyId']); //удалить
    $r->addRoute('POST', PROJECT_FOLDER.'post/delete/{id:\d+}', ['\App\Controllers\Posts','deletepostbyId']); //удалить
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $containerDI->call($handler, $vars);
        break;
    default:
        echo "no routing";
}