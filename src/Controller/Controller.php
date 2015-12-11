<?php

namespace LessonApp\Controller;

class Controller
{
    protected $app;

    function __construct(\Slim\Slim $app)
    {
        $this->app = $app;
    }

    protected function render($template, $data)
    {
        $data = array_merge($data, ['route' => $this->app->router()->getCurrentRoute()->getName()]);

        echo $this->app->template->loadTemplate($template)->render($data);
    }
}