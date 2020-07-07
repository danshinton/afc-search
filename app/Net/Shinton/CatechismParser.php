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

                    $range[0] = trim($range[0]);
                    $range[1] = trim($range[1]);

                    if (is_numeric($range[0]) && is_numeric($range[1])) {
                        $start = intval($range[0]);
                        $end = intval($range[1]);

                        for ($i = $start; $i <= $end; $i++) {
                            $paragraphs[] = $i;
                        }
                    }

                } else {
                    $paragraph = trim($paragraph);

                    if (is_numeric($paragraph)) {
                        $paragraphs[] = intval($paragraph);
                    }
                }
            }
        }

        return $paragraphs;
    }
}
