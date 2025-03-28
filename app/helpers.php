<?php

if (!function_exists('getLetterClass')) {
    function getLetterClass($letter, $position, $guess, $word, $letterStates)
    {
        if ($guess === null) {
            return isset($letterStates[$letter]) ? $letterStates[$letter] : '';
        }

        $word = str_split($word);
        if ($letter === $word[$position]) {
            return 'correct';
        } elseif (in_array($letter, $word)) {
            return 'present';
        }
        return 'absent';
    }
}
