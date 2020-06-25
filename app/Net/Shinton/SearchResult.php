<?php


namespace App\Net\Shinton;


class SearchResult
{
    public $query;
    public $bestFit;
    public $related;
    public $total;

    function __construct($query, $bestFit, $related) {
        $this->query = $query;
        $this->bestFit = $bestFit;
        $this->related = $related;
        $this->total = count($bestFit) + count($related);
    }
}
