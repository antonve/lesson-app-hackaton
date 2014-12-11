<?php

namespace LessonApp\Model;

class Word
{
    public $id;
    public $reading;
    public $hanzi;
    public $meaning;

    function __construct($data = [])
    {
        $this->id = array_key_exists('id', $data) ? $data['id'] : null;
        $this->reading = array_key_exists('reading', $data) ? $data['reading'] : null;
        $this->hanzi = array_key_exists('hanzi', $data) ? $data['hanzi'] : null;
        $this->meaning = array_key_exists('meaning', $data) ? $data['meaning'] : null;
    }
}