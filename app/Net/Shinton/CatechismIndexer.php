<?php


namespace App\Net\Shinton;


class CatechismIndexer
{
    private $bestFitIndex;
    private $allIndex;
    private $questionIndex;

    function __construct() {
        $this->init();
    }

    private function init() {
        $this->bestFitIndex = array();
        $this->allIndex = array();
        $this->questionIndex = array();

        $this->buildIndex(resource_path() . '/data/AFC-CCC.txt');
        $this->buildToc(resource_path() . '/data/AFC-TOC.txt');
    }

    private function buildIndex($dataPath) {
        foreach (file($dataPath) as $line) {
            $fields = explode('|', $line);
            if (count($fields) != 3) {
                throw new IndexException('Line not formatted correctly: ' . $line);
            }

            $question = intval($fields[0]);

            foreach ($this->parseChapters(trim($fields[1])) as $chapter) {
                $this->addToIndex($this->bestFitIndex, $chapter, $question);
            }

            foreach ($this->parseChapters(trim($fields[2])) as $chapter) {
                $this->addToIndex($this->allIndex, $chapter, $question);
            }
        }
    }

    private function buildToc($dataPath) {
        foreach (file($dataPath) as $line) {
            $question = new Question($line);
            $this->questionIndex[$question->number] = $question;
        }
    }

    private function parseChapters($line) {
        $chapters = array();

        if (!empty($line)) {
            foreach (explode(',', $line) as $chapter) {
                if (preg_match('/\p{Pd}/', $chapter)) {
                    $range = preg_split('/\p{Pd}/', $chapter);
                    if (count($range) != 2) {
                        throw new IndexException('Range not formatted correctly: ' . $chapter);
                    }

                    $start = intval($range[0]);
                    $end = intval($range[1]);

                    for ($i = $start; $i <= $end; $i++) {
                        $chapters[] = $i;
                    }

                } else {
                    $chapters[] = intval(trim($chapter));
                }
            }
        }

        return $chapters;
    }

    public function query($query) {
        $chapters = $this->parseChapters($query);
        $bestFit = array();
        $related = array();

        foreach ($chapters as $chapter) {
            if (array_key_exists($chapter, $this->bestFitIndex)) {
                $questions = $this->bestFitIndex[$chapter];
                foreach ($questions as $question) {
                    $bestFit[] = $question;
                }
            }

            if (array_key_exists($chapter, $this->allIndex)) {
                $questions = $this->allIndex[$chapter];
                foreach ($questions as $question) {
                    $related[] = $question;
                }
            }
        }

        $bestFit = array_unique($bestFit, SORT_NUMERIC);
        $related = array_unique($related, SORT_NUMERIC);
        $related = array_diff($related, $bestFit);

        sort($bestFit);
        sort($related);

        $bestFitQuestions = array();
        $relatedQuestions = array();

        foreach ($bestFit as $question) {
            $bestFitQuestions[] = $this->questionIndex[$question];
        }

        foreach ($related as $question) {
            $relatedQuestions[] = $this->questionIndex[$question];
        }

        return new SearchResult($query, $bestFitQuestions, $relatedQuestions);
    }

    private function addToIndex(&$index, $chapter, $question) {
        if (!array_key_exists($chapter, $index)) {
            $index[$chapter] = array();
        }

        $index[$chapter][] = $question;
    }
}
