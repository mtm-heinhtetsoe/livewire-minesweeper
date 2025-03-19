<div class="minesweeper-container">
    <div class="minesweeper-wrapper">
        <div class="minesweeper-board">
            <div class="minesweeper-content">
                <div class="controls-container">
                    <button wire:click="initializeBoard" class="btn btn-primary">
                        New Game
                    </button>
                    <button wire:click="toggleFlagMode" class="btn btn-flag {{ $flagMode ? 'active' : '' }}">
                        {{ $flagMode ? 'Flag Mode (On)' : 'Flag Mode (Off)' }}
                    </button>
                    <div class="flag-counter">
                        🚩 {{ $flaggedCells }} / {{ $mines }}
                    </div>
                </div>

                @if($gameOver)
                    <div class="game-status game-over">Game Over!</div>
                @endif

                @if($gameWon)
                    <div class="game-status game-won">You Won!</div>
                @endif

                <div class="game-grid" style="grid-template-columns: repeat({{ $cols }}, minmax(0, 1fr));">
                    @foreach($board as $rowIndex => $row)
                        @foreach($row as $colIndex => $cell)
                            <button
                                wire:click="cellClick({{ $rowIndex }}, {{ $colIndex }})"
                                class="cell {{ $cell['revealed'] ? ($cell['hasMine'] ? 'cell-mine' : 'cell-revealed') : 'cell-unrevealed' }}
                                    {{ ($gameOver || $gameWon) ? 'cell-disabled' : '' }}"
                                {{ ($gameOver || $gameWon) ? 'disabled' : '' }}
                            >
                                @if($cell['flagged'])
                                    🚩
                                @elseif($cell['revealed'])
                                    @if($cell['hasMine'])
                                        💣
                                    @elseif($cell['adjacentMines'] > 0)
                                        {{ $cell['adjacentMines'] }}
                                    @endif
                                @endif
                            </button>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>