<?php

namespace App\Http\Controllers;

use App\Net\Shinton\CatechismParser;
use App\Net\Shinton\SearchResult;
use App\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    private $catechismParser;

    function __construct(CatechismParser $catechismParser) {
        $this->catechismParser = $catechismParser;
    }

    public function query() {
        $query = request('paragraphs');
        $paragraphs = $this->catechismParser->parseParagraphs($query);

        // Find the best fit questions
        $bestFit = Question::whereHas('bestFit', function($q) use($paragraphs) {
            $q->whereIn('number', $paragraphs);
        })->get();

        // Find the related questions
        $related = Question::whereHas('related', function($q) use($paragraphs) {
            $q->whereIn('number', $paragraphs);
        })->get();

        // Return the result
        $result = new SearchResult($query, $bestFit, $related);

        return view('search', [
            'results' => $result
        ]);
    }
}
