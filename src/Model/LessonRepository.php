<?php

namespace LessonApp\Model;

class LessonRepository
{
    private $db;

    function __construct(\PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function getAllLessons()
    {
        $lessons = [];

        $stmt = $this->db->prepare('
            SELECT id, title, `interval`, last_studied, date_started, next_date
            FROM lessons
            ORDER BY id DESC
        ');
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $lessons[] = new Lesson($row);
        }

        return $lessons;
    }

    public function getLessonsForToday()
    {
        $lessons = [];

        $stmt = $this->db->prepare('
            SELECT id, title, `interval`, last_studied, date_started, next_date
            FROM lessons
            WHERE next_date <= DATE(NOW()) AND `interval` < 25
            ORDER BY `interval` DESC
        ');
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $lessons[] = new Lesson($row);
        }

        return $lessons;
    }

    public function getLessonById($id)
    {
        $stmt = $this->db->prepare('
            SELECT l.id,
                   l.title,
                   l.content,
                   l.`interval`,
                   l.last_studied,
                   l.date_started,
                   l.next_date,
                   ch.character,
                   w.hanzi,
                   w.reading,
                   w.meaning
            FROM lessons as l
            LEFT JOIN characters as ch ON (ch.lesson_id = l.id)
            LEFT JOIN words as w ON (w.lesson_id = l.id)
            WHERE l.id = :id
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $characters = [];
        $words = [];

        foreach ($results as $result) {
            if ($result['character'] !== null && !in_array($result['character'], $characters)) {
                $characters[] = $result['character'];
            }
            if ($result['hanzi'] !== null && !array_key_exists($result['hanzi'], $words)) {
                $words[$result['hanzi']] = new Word($result);
            }
        }

        $lesson = new Lesson(array_merge($results[0], ['characters' => $characters], ['words' => $words]));

        return $lesson;
    }
}