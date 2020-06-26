<?php


namespace App\Net\Shinton;


class CatechismParser
{
    public function parseParagraphs($line) {
        $paragraphs = array();

        if (!empty($line)) {
            foreach (explode(',', $line) as $paragraph) {
                if (preg_match('/\p{Pd}/', $paragraph)) {
                    $range = preg_split('/\p{Pd}/', $paragraph);
                    if (count($range) != 2) {
                        throw new ParseException('Range not formatted correctly: ' . $paragraph);
                    }

                    $start = intval($range[0]);
                    $end = intval($range[1]);

                    for ($i = $start; $i <= $end; $i++) {
                        $paragraphs[] = $i;
                    }

                } else {
                    $paragraphs[] = intval(trim($paragraph));
                }
            }
        }

        return $paragraphs;
    }
}
