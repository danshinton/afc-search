<?php

use App\Net\Shinton\IndexException;
use Illuminate\Database\Seeder;
use App\Question;
use App\CatechismParagraph;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        DB::table('questions')->delete();
        DB::table('catechism_paragraph_question_best_fit')->delete();
        DB::table('catechism_paragraph_question_related')->delete();

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
            throw new IndexException('Line not formatted correctly: ' . $line);
        }

        return Question::create([
            'number' => intval(trim($fields[0])),
            'volume' => intval(trim($fields[1])),
            'chapter' => intval(trim($fields[2])),
            'chapter_title' => $fields[3],
            'page' => intval(trim($fields[4])),
            'title' => $fields[5],
        ]);
    }

    /*
     * 1|34,41-43,203-279|1,14,27-30,32,34-37,41-43,47-48,64,200,203-279
     */
    private function saveRelationships($line) {
        $fields = explode('|', $line);

        if (count($fields) != 3) {
            throw new IndexException('Line not formatted correctly: ' . $line);
        }

        $question = Question::where('number', intval($fields[0]))->first();

        $bestFit = $this->parseChapters(trim($fields[1]));
        foreach ($bestFit as $paragraphNumber) {
            $paragraph = CatechismParagraph::where('number', $paragraphNumber)->first();
            $question->bestFit()->save($paragraph);
        }

        foreach ($this->parseChapters(trim($fields[2])) as $paragraphNumber) {
            if (!in_array($paragraphNumber, $bestFit)) {
                $paragraph = CatechismParagraph::where('number', $paragraphNumber)->first();
                $question->related()->save($paragraph);
            }
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
}
