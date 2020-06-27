<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatechismParagraphQuestionBestFitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catechism_paragraph_question_best_fit', function (Blueprint $table) {
            $table->integer('catechism_paragraph_id');
            $table->integer('question_id');

            $table->foreign('catechism_paragraph_id')->references('id')->on('catechism_paragraphs');
            $table->foreign('question_id')->references('id')->on('questions');

            $table->primary(['catechism_paragraph_id','question_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catechism_paragraph_question_best_fit');
    }
}
