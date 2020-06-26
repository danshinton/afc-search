<?php

namespace App\Http\Controllers;

use App\Net\Shinton\SearchResult;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function query() {
        $chapters = $this->parseChapters(request('query'));

        $bestFit = Question::whereHas('bestFit', function($q) use($chapters) {
            $q->whereIn('number', $chapters);
        })->get();

        $related = Question::whereHas('related', function($q) use($chapters) {
            $q->whereIn('number', $chapters);
        })->get();

        $result = new SearchResult(request('query'), $bestFit, $related);

        return view('welcome', [
            'results' => $result
        ]);
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
