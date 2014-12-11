<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

$app = new \Slim\Slim();

// DI
$app->container->singleton('db', function () {
    $pdo = new PDO('mysql:host=localhost;dbname=lessonapp', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
});
$app->container->singleton('template', function () {
    $loader = new Twig_Loader_Filesystem(dirname(__FILE__) . '/../src/View');
    $twig = new Twig_Environment($loader, array(
        'debug' => true
        //'cache' => dirname(__FILE__) . '/../cache',
    ));

    return $twig;
});

// routes
$app->get('/', [new \LessonApp\Controller\LessonController($app), 'index'])->setName('home');
$app->get('/lesson/list', [new \LessonApp\Controller\LessonController($app), 'all'])->setName('lesson_list');
$app->get('/lesson/add', [new \LessonApp\Controller\LessonController($app), 'add'])->setName('lesson_add');
$app->get('/lesson/:id', [new \LessonApp\Controller\LessonController($app), 'view'])->setName('lesson_view');
$app->get('/lesson/study/:id', [new \LessonApp\Controller\LessonController($app), 'study'])->setName('lesson_view');

$app->run();