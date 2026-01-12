<?php

namespace App\Traits;

trait ExtractMatches
{
    public function extractMatchedWords(array $hit): array
    {
        $matchedWords = [];

        foreach ($hit['_matchesPosition'] as $attribute => $matches) {
            foreach ($matches as $match) {
                if (isset($hit[$attribute])) {
                    $text = is_string($hit[$attribute]) ? $hit[$attribute] : '';
                    $word = substr($text, $match['start'], $match['length']);

                    if (trim($word) !== '' && !in_array($word, $matchedWords, true)) {

                        $matchedWords[] = $word;
                    }
                }
            }
        }

        return $matchedWords;
    }
}
