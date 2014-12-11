<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

$app = new \Slim\Slim();

$pdo = new PDO('mysql:host=localhost;dbname=lessonapp', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$loader = new Twig_Loader_Filesystem(dirname(__FILE__) . '/../src/View');
$twig = new Twig_Environment($loader, array(
    'debug' => true
    //'cache' => dirname(__FILE__) . '/../cache',
));

// routes
$app->get('/', [new \LessonApp\Controller\LessonController($pdo, $twig, $app), 'index'])->setName('home');
$app->get('/lesson/list', [new \LessonApp\Controller\LessonController($pdo, $twig, $app), 'all'])->setName('lesson_list');
$app->get('/lesson/add', [new \LessonApp\Controller\LessonController($pdo, $twig, $app), 'add'])->setName('lesson_add');
$app->get('/lesson/:id', [new \LessonApp\Controller\LessonController($pdo, $twig, $app), 'view'])->setName('lesson_view');

$app->run();