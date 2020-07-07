<?php

namespace Tests\Unit;

use App\Net\Shinton\CatechismParser;
use PHPUnit\Framework\TestCase;

class CatechismParserTest extends TestCase
{
    public function testEmptyString() {
        $parser = new CatechismParser();
        $paragraphs = $parser->parseParagraphs("");

        $this->assertEquals([], $paragraphs);
    }

    public function testOne() {
        $parser = new CatechismParser();
        $paragraphs = $parser->parseParagraphs("100");

        $this->assertEquals([ 100 ], $paragraphs);
    }

    public function testRange() {
        $parser = new CatechismParser();
        $paragraphs = $parser->parseParagraphs("50-55");

        $this->assertEquals([ 50, 51, 52, 53, 54, 55 ], $paragraphs);

    }

    public function testWhitespace() {
        $parser = new CatechismParser();
        $paragraphs = $parser->parseParagraphs("   \t40 ,  70 , 5\t-9 ");

        $this->assertEquals([ 40, 70, 5, 6, 7, 8, 9 ], $paragraphs);
    }

    public function testMixed() {
        $parser = new CatechismParser();
        $paragraphs = $parser->parseParagraphs("1,2,8-9,15,22-25");

        $this->assertEquals([ 1, 2, 8, 9, 15, 22, 23, 24, 25 ], $paragraphs);
    }

    public function testInvalid() {
        $parser = new CatechismParser();
        $paragraphs = $parser->parseParagraphs("hello,my-man");

        $this->assertEquals([], $paragraphs);
    }
}
