<?php

namespace App\Livewire;

use Livewire\Component;

class Wordoftheday extends Component
{
    public $word = 'ELEPHANT';
    public $try_count = 6;
    public $guesses = [];
    public $currentGuess = '';
    public $gameOver = false;
    public $message = '';
    public $answer_length = 0;
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
        $this->answer_length = strlen($this->word);
    }

    public function pressKey($key)
    {
        if ($this->gameOver) return;

        if ($key === 'Enter') {
            $this->submitGuess();
        } elseif ($key === '⌫') {
            $this->backspace();
        } elseif (strlen($this->currentGuess) < $this->answer_length) {
            $this->currentGuess .= $key;
        }
    }

    public function backspace()
    {
        $this->currentGuess = substr($this->currentGuess, 0, -1);
    }

    public function submitGuess()
    {
        // Check if the guess is the correct length before proceeding with the validation
        if (strlen($this->currentGuess) !== $this->answer_length) {
            $this->message = "Word must be $this->answer_length letters long";
            return;
        }

        $this->guesses[] = $this->currentGuess;
        $this->updateLetterStates();

        if ($this->currentGuess === $this->word) {
            $this->gameOver = true;
            $this->message = 'Congratulations! You won!';
        } elseif (count($this->guesses) >= $this->try_count) {
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

    public function render()
    {
        return view('livewire.wordoftheday');
    }
}
