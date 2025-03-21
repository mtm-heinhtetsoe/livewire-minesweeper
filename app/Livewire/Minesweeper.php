<?php

namespace App\Livewire;

use Livewire\Component;

class Minesweeper extends Component
{
    public $board = [];
    public $rows = 8;
    public $cols = 8;
    public $mines = 10;
    public $gameOver = false;
    public $gameWon = false;
    public $flagMode = false;
    public $flaggedCells = 0;
    public $revealedCells = 0;

    public function mount()
    {
        $this->initializeBoard();
    }

    public $firstClick = true;

    public function initializeBoard()
    {
        $this->board = [];
        $this->gameOver = false;
        $this->gameWon = false;
        $this->flaggedCells = 0;
        $this->revealedCells = 0;
        $this->firstClick = true;

        // Initialize empty board
        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                $this->board[$i][$j] = [
                    'hasMine' => false,
                    'revealed' => false,
                    'flagged' => false,
                    'adjacentMines' => 0
                ];
            }
        }
    }

    public function placeMines($excludeRow, $excludeCol)
    {
        $minesPlaced = 0;
        while ($minesPlaced < $this->mines) {
            $row = rand(0, $this->rows - 1);
            $col = rand(0, $this->cols - 1);

            // Skip if the cell is within the safe zone around the first click
            if (abs($row - $excludeRow) <= 1 && abs($col - $excludeCol) <= 1) {
                continue;
            }

            if (!$this->board[$row][$col]['hasMine']) {
                $this->board[$row][$col]['hasMine'] = true;
                $minesPlaced++;

                // Update adjacent mine counts
                for ($i = max(0, $row - 1); $i <= min($this->rows - 1, $row + 1); $i++) {
                    for ($j = max(0, $col - 1); $j <= min($this->cols - 1, $col + 1); $j++) {
                        if (!$this->board[$i][$j]['hasMine']) {
                            $this->board[$i][$j]['adjacentMines']++;
                        }
                    }
                }
            }
        }
    }

    public function toggleFlagMode()
    {
        $this->flagMode = !$this->flagMode;
    }

    public function cellClick($row, $col)
    {
        if ($this->gameOver || $this->gameWon) {
            return;
        }

        if ($this->flagMode) {
            $this->toggleFlag($row, $col);
            return;
        }

        if ($this->firstClick) {
            $this->firstClick = false;
            $this->placeMines($row, $col);
        }

        $this->revealCell($row, $col);
        $this->checkWinCondition();
    }

    public function toggleFlag($row, $col)
    {
        if (!$this->board[$row][$col]['revealed']) {
            $this->board[$row][$col]['flagged'] = !$this->board[$row][$col]['flagged'];
            $this->flaggedCells += $this->board[$row][$col]['flagged'] ? 1 : -1;
        }
    }

    public function revealCell($row, $col)
    {
        if ($this->board[$row][$col]['flagged'] || $this->board[$row][$col]['revealed']) {
            return;
        }

        $this->board[$row][$col]['revealed'] = true;
        $this->revealedCells++;

        if ($this->board[$row][$col]['hasMine']) {
            $this->gameOver = true;
            return;
        }

        if ($this->board[$row][$col]['adjacentMines'] === 0) {
            $this->revealAdjacentCells($row, $col);
        }
    }

    public function revealAdjacentCells($row, $col)
    {
        for ($i = max(0, $row - 1); $i <= min($this->rows - 1, $row + 1); $i++) {
            for ($j = max(0, $col - 1); $j <= min($this->cols - 1, $col + 1); $j++) {
                if (!$this->board[$i][$j]['revealed'] && !$this->board[$i][$j]['flagged']) {
                    $this->revealCell($i, $j);
                }
            }
        }
    }

    public function checkWinCondition()
    {
        $totalCells = $this->rows * $this->cols;
        if ($this->revealedCells === $totalCells - $this->mines) {
            $this->gameWon = true;
        }
    }

    public function render()
    {
        return view('livewire.minesweeper');
    }
}