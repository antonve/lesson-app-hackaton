<?php

namespace LessonApp\Model;

class Lesson
{
	public $id;
    public $title;
    public $content;
	public $date_started;
	public $interval;
	public $next_date;
	public $last_studied;
    public $characters;
    public $words;

	function __construct($data = [])
	{
		$this->id = array_key_exists('id', $data) ? $data['id'] : null;
        $this->title = array_key_exists('title', $data) ? $data['title'] : null;
        $this->content = array_key_exists('content', $data) ? $data['content'] : null;
		$this->date_started = array_key_exists('date_started', $data) ? new \DateTime($data['date_started']) : new \DateTime();
		$this->next_date = array_key_exists('next_date', $data) ? new \DateTime($data['next_date']) : new \DateTime();
		$this->interval = array_key_exists('interval', $data) ? $data['interval'] : null;
		$this->last_studied = array_key_exists('last_studied', $data) ? new \DateTime($data['last_studied']) : new \DateTime();
        $this->characters = array_key_exists('characters', $data) ? $data['characters'] : [];
        $this->words = array_key_exists('words', $data) ? $data['words'] : [];
	}

	function study(\DateTime $date)
	{
		$reviewTime = 2;

		if ($this->interval == 8) {
			$this->interval = 24;
			$reviewTime = 4;
		}
		if ($this->interval == 4) {
			$this->interval = 8;
			$reviewTime = 5;
		}
		if ($this->interval == 2) {
			$this->interval = 4;
			$reviewTime = 8;
		}
		if ($this->interval == 1) {
			$this->interval++;
			$reviewTime = 10;
		}
		if ($this->interval == 0) {
			$this->interval = 1;
			$reviewTime = 20;
		}
		
		$this->last_studied = $date;
		$this->next_date = $this->next_date->modify("+" . $this->interval . " days");

		return $reviewTime;
	}

	function hasToStudy(\DateTime $date)
	{
		if ($this->interval == 24 && $this->last_studied->getTimestamp() <= $date->getTimestamp()) {
			return false;
		}

		return $date->getTimestamp() >= $this->next_date->getTimestamp();
	}
}