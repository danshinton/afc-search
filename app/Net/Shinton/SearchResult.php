<?php


namespace App\Net\Shinton;


class SearchResult
{
    public $query;
    public $bestFit;
    public $related;
    public $total;
    public $name;

    function __construct($query, $bestFit, $related, $name) {
        $this->query = $query;
        $this->bestFit = $bestFit;
        $this->related = $related;
        $this->total = count($bestFit) + count($related);
        $this->name = $name;
    }
}
