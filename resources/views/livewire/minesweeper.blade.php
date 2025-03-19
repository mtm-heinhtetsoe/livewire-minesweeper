<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
            <div class="max-w-md mx-auto">
                <div class="divide-y divide-gray-200">
                    <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        <div class="flex justify-between items-center mb-4">
                            <button wire:click="initializeBoard" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                New Game
                            </button>
                            <button wire:click="toggleFlagMode" class="{{ $flagMode ? 'bg-red-500' : 'bg-gray-500' }} hover:opacity-75 text-white font-bold py-2 px-4 rounded">
                                {{ $flagMode ? 'Flag Mode (On)' : 'Flag Mode (Off)' }}
                            </button>
                            <div class="text-lg font-semibold">
                                Flags: {{ $flaggedCells }} / {{ $mines }}
                            </div>
                        </div>

                        @if($gameOver)
                            <div class="text-red-500 text-center text-xl font-bold mb-4">Game Over!</div>
                        @endif

                        @if($gameWon)
                            <div class="text-green-500 text-center text-xl font-bold mb-4">You Won!</div>
                        @endif

                        <div class="grid grid-cols-{{ $cols }} gap-1 bg-gray-200 p-2 rounded">
                            @foreach($board as $rowIndex => $row)
                                @foreach($row as $colIndex => $cell)
                                    <button
                                        wire:click="cellClick({{ $rowIndex }}, {{ $colIndex }})"
                                        class="w-8 h-8 flex items-center justify-center text-sm font-bold
                                            {{ $cell['revealed'] ? ($cell['hasMine'] ? 'bg-red-500' : 'bg-gray-100') : 'bg-gray-300 hover:bg-gray-400' }}
                                            {{ !$cell['revealed'] && !$cell['flagged'] ? 'cursor-pointer' : '' }}"
                                        {{ ($gameOver || $gameWon) ? 'disabled' : '' }}
                                    >
                                        @if($cell['flagged'])
                                            🚩
                                        @elseif($cell['revealed'])
                                            @if($cell['hasMine'])
                                                💣
                                            @elseif($cell['adjacentMines'] > 0)
                                                <span class="
                                                    {{ $cell['adjacentMines'] == 1 ? 'text-blue-500' : '' }}
                                                    {{ $cell['adjacentMines'] == 2 ? 'text-green-500' : '' }}
                                                    {{ $cell['adjacentMines'] == 3 ? 'text-red-500' : '' }}
                                                    {{ $cell['adjacentMines'] >= 4 ? 'text-purple-500' : '' }}
                                                ">
                                                    {{ $cell['adjacentMines'] }}
                                                </span>
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
    </div>
</div>