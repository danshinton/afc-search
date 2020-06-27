<?php

use App\Net\Shinton\CatechismParser;
use App\Net\Shinton\ParseException;
use Illuminate\Database\Seeder;
use App\Question;
use App\CatechismParagraph;

class QuestionSeeder extends Seeder
{
    private $catechismParser;

    function __construct(CatechismParser $catechismParser) {
        $this->catechismParser = $catechismParser;
    }

    public function run()
    {
        DB::table('catechism_paragraph_question_best_fit')->delete();
        DB::table('catechism_paragraph_question_related')->delete();
        DB::table('questions')->delete();

        $dataPath = resource_path() . '/data/AFC-TOC.txt';

        foreach (file($dataPath) as $line) {
            $this->saveQuestion($line);
        }

        $dataPath = resource_path() . '/data/AFC-CCC.txt';

        foreach (file($dataPath) as $line) {
            $this->saveRelationships($line);
        }
    }

    /*
     * 1|1|1|God is the Supreme Being|5|Who is God?
     */
    private function saveQuestion($line) {
        $fields = explode("|", $line);

        if (count($fields) != 6) {
            throw new ParseException('Line not formatted correctly: ' . $line);
        }

        return Question::create([
            'number' => intval(trim($fields[0])),
            'volume' => intval(trim($fields[1])),
            'chapter' => intval(trim($fields[2])),
            'chapter_title' => trim($fields[3]),
            'page' => intval(trim($fields[4])),
            'title' => trim($fields[5]),
        ]);
    }

    /*
     * 1|34,41-43,203-279|1,14,27-30,32,34-37,41-43,47-48,64,200,203-279
     */
    private function saveRelationships($line) {
        $fields = explode('|', $line);

        if (count($fields) != 3) {
            throw new ParseException('Line not formatted correctly: ' . $line);
        }

        $question = Question::where('number', intval($fields[0]))->first();

        $bestFit = $this->catechismParser->parseParagraphs(trim($fields[1]));
        foreach ($bestFit as $paragraphNumber) {
            $paragraph = CatechismParagraph::where('number', $paragraphNumber)->first();
            $question->bestFit()->save($paragraph);
        }

        foreach ($this->catechismParser->parseParagraphs(trim($fields[2])) as $paragraphNumber) {
            if (!in_array($paragraphNumber, $bestFit)) {
                $paragraph = CatechismParagraph::where('number', $paragraphNumber)->first();
                $question->related()->save($paragraph);
            }
        }
    }
}
