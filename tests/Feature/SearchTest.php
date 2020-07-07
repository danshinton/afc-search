<?php

namespace Tests\Feature;

use App\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class SearchTest extends TestCase
{
    public function testSearch() {
        // TODO: Figure out how to properly set up a search test
//        $mockQuestion = Mockery::mock(new Question());
//
//        $this->app->instance('App\Question', $mockQuestion);
//
//        $bestFit = array();
//        $question = new Question();
//        $question->number = 1;
//        $question->volume = 2;
//        $question->chapter = 3;
//        $question->chapter_title = "Test Chapter Title";
//        $question->page = 4;
//        $question->title = "Test Title";
//
//        $bestFit[] = $question;
//
//        $mockQuestion
//            ->shouldReceive('whereHas')
//            ->with('bestFit', Mockery::any())
//            ->once()
//            ->andReturn($question->newCollection($bestFit));
//
//        $mockQuestion
//            ->shouldReceive('where')
//            ->with('related', Mockery::any())
//            ->once()
//            ->andReturn($question->newCollection([]));

        $response = $this->post('/', ['paragraphs' => '1']);

        $response->assertStatus(200);
    }
}
