<?php

namespace LessonApp\Controller;
use LessonApp\Model\LessonRepository;
use LessonApp\Model\Lesson;

class LessonController extends Controller
{
    public function index()
    {
        $repo = new LessonRepository($this->app->db);
        $lessons = $repo->getLessonsForToday();

        $this->render('index.html.twig', ['lessons' => $lessons]);
    }

    public function all()
    {
        $repo = new LessonRepository($this->app->db);
        $lessons = $repo->getAllLessons();

        $this->render('lesson.list.html.twig', ['lessons' => $lessons]);
    }

    public function add()
    {
    }

    public function view($id)
    {
        $repo = new LessonRepository($this->app->db);
        $lesson = $repo->getLessonById($id);

        $this->render('lesson.view.html.twig', ['lesson' => $lesson]);
    }
}