<?php


namespace App\Net\Shinton;


use http\Exception\InvalidArgumentException;

class Question
{
    public $number;
    public $title;
    public $volume;
    public $chapter;
    public $chapterTitle;
    public $pageNumber;

    function __construct($line) {
        $fields = explode("|", $line);

        if (count($fields) != 6) {
            throw new IndexException('Line not formatted correctly: ' . $line);
        }

        $this->number = intval(trim($fields[0]));
        $this->volume = intval(trim($fields[1]));
        $this->chapter = intval(trim($fields[2]));
        $this->chapterTitle = $fields[3];
        $this->pageNumber = intval(trim($fields[4]));
        $this->title = $fields[5];
    }

    public function __toString() {
        return strval($this->number);
    }
}
