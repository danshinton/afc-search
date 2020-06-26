<?php

use Illuminate\Database\Seeder;
use App\CatechismParagraph;

class CatechismParagraphSeeder extends Seeder
{
    public function run()
    {
        DB::table('catechism_paragraphs')->delete();

        for ($i = 1; $i <= 2865; $i++) {
            CatechismParagraph::create(['number' => $i]);
        }
    }
}
