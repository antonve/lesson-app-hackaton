<?php

namespace LessonApp\Controller;

class Controller
{
	protected $db;
	protected $template;
    protected $slim;

	function __construct(\PDO $pdo = null, \Twig_Environment $twig = null, \Slim\Slim $slim)
	{
		$this->db = $pdo;
		$this->template = $twig;
        $this->slim = $slim;
	}

	protected function render($template, $data)
	{
        $data = array_merge($data, ['route' => $this->slim->router()->getCurrentRoute()->getName()]);

		echo $this->template->loadTemplate($template)->render($data);
	}
}