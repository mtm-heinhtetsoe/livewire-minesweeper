<?php

namespace App\Livewire;

use Livewire\Component;

class Wordoftheday extends Component
{
    public $word = 'CRYPTO';
    public $guesses = [];
    public $currentGuess = '';
    public $gameOver = false;
    public $message = '';
    public $keyboard = [
        ['Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P'],
        ['A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L'],
        ['Z', 'X', 'C', 'V', 'B', 'N', 'M']
    ];
    public $letterStates = [];

    public function mount()
    {
        $this->initializeGame();
    }

    public function initializeGame()
    {
        $this->guesses = [];
        $this->currentGuess = '';
        $this->gameOver = false;
        $this->message = '';
        $this->letterStates = [];
    }

    public function pressKey($key)
    {
        if ($this->gameOver) return;

        if ($key === 'Enter') {
            $this->submitGuess();
        } elseif ($key === '⌫') {
            $this->backspace();
        } elseif (strlen($this->currentGuess) < 6) {
            $this->currentGuess .= $key;
        }
    }

    public function backspace()
    {
        $this->currentGuess = substr($this->currentGuess, 0, -1);
    }

    public function submitGuess()
    {
        if (strlen($this->currentGuess) !== 6) {
            $this->message = 'Word must be 6 letters long';
            return;
        }

        $this->guesses[] = $this->currentGuess;
        $this->updateLetterStates();

        if ($this->currentGuess === $this->word) {
            $this->gameOver = true;
            $this->message = 'Congratulations! You won!';
        } elseif (count($this->guesses) >= 6) {
            $this->gameOver = true;
            $this->message = 'Game Over! The word was ' . $this->word;
        }

        $this->currentGuess = '';
    }

    public function updateLetterStates()
    {
        $guess = $this->guesses[count($this->guesses) - 1];
        $word = str_split($this->word);
        $guessLetters = str_split($guess);

        foreach ($guessLetters as $index => $letter) {
            if ($letter === $word[$index]) {
                $this->letterStates[$letter] = 'correct';
            } elseif (in_array($letter, $word)) {
                if (!isset($this->letterStates[$letter]) || $this->letterStates[$letter] !== 'correct') {
                    $this->letterStates[$letter] = 'present';
                }
            } else {
                if (!isset($this->letterStates[$letter])) {
                    $this->letterStates[$letter] = 'absent';
                }
            }
        }
    }

    public function getLetterClass($letter, $position = null, $guess = null)
    {
        if ($guess === null) {
            return isset($this->letterStates[$letter]) ? $this->letterStates[$letter] : '';
        }

        $word = str_split($this->word);
        if ($letter === $word[$position]) {
            return 'correct';
        } elseif (in_array($letter, $word)) {
            return 'present';
        }
        return 'absent';
    }

    public function render()
    {
        return view('livewire.wordoftheday');
    }
}
