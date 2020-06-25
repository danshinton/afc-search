<?php

namespace App\Http\Controllers;

use App\Net\Shinton\CatechismIndexer;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    private $CatechismIndexer;

    function __construct(CatechismIndexer $indexer) {
        $this->CatechismIndexer = $indexer;
    }

    public function query() {
        $results = $this->CatechismIndexer->query(request('query'));

        return view('welcome', [
            'results' => $results
        ]);
    }
}
