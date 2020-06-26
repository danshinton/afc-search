<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function bestFit()
    {
        return $this->belongsToMany('App\CatechismParagraph', 'catechism_paragraph_question_best_fit', 'question_id', 'catechism_paragraph_id');
    }

    public function related()
    {
        return $this->belongsToMany('App\CatechismParagraph', 'catechism_paragraph_question_related', 'question_id', 'catechism_paragraph_id');
    }
}
