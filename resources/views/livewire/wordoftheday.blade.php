<div class="word-game-container">
    <link rel="stylesheet" type="text/css" href="{{ asset('wordoftheday.css') }}">
    <h2 class="word-game-title">Word of the Day</h2>
    @if($answer_length === 0)
        <div class="word-form">
            <input type="text" class="word-input" name="word" id="word" placeholder="word" wire:model="tmp_word">
            <button wire:click="start()" class="word-button keyboard-action">Start</button>
        </div>
    @else
    <div class="word-game-board">
        @if($message)
            <div class="game-message {{ str_contains($message, 'Congratulations') ? 'message-success' : 'message-error' }}">
                {{ $message }}
            </div>
        @endif

        <!-- Game Grid -->
        <div class="game-grid" style="grid-template-columns: repeat({{ $answer_length }}, 1fr);">
            @for ($row = 0; $row < $try_count; $row++)
                @for ($col = 0; $col < strlen($word); $col++)
                    <div class="grid-cell {{ 
                        isset($guesses[$row]) 
                            ? (getLetterClass(substr($guesses[$row], $col, 1), $col, $guesses[$row], $word, $letterStates) === 'correct' 
                                ? 'cell-correct' 
                                : (getLetterClass(substr($guesses[$row], $col, 1), $col, $guesses[$row], $word, $letterStates) === 'present' 
                                    ? 'cell-present'
                                    : 'cell-absent'))
                            : ($row === count($guesses) && strlen($currentGuess) > $col 
                                ? 'cell-active' 
                                : 'cell-empty')
                    }}">
                        {{ isset($guesses[$row]) ? substr($guesses[$row], $col, 1) : ($row === count($guesses) && strlen($currentGuess) > $col ? substr($currentGuess, $col, 1) : '') }}
                    </div>
                @endfor
            @endfor
        </div>

        <!-- Custom Keyboard -->
        <div class="keyboard-container">
            @foreach ($keyboard as $i => $row)
                <div class="keyboard-row">
                    @foreach ($row as $key)
                        <button 
                            wire:click="pressKey('{{ $key }}')" 
                            class="keyboard-key {{ 
                                isset($letterStates[$key]) 
                                    ? ($letterStates[$key] === 'correct' 
                                        ? 'key-correct' 
                                        : ($letterStates[$key] === 'present' 
                                            ? 'key-present' 
                                            : 'key-absent'))
                                    : ''
                            }}"
                        >
                            {{ $key }}
                        </button>
                    @endforeach
                    @if ($i === 1)
                        <button 
                            wire:click="pressKey('⌫')" 
                            class="keyboard-key keyboard-action"
                        >
                            ⌫
                        </button>
                    @endif
                    @if ($i === 2)
                        <button 
                            wire:click="pressKey('Enter')" 
                            class="keyboard-key keyboard-key-enter keyboard-action"
                        >
                            Enter
                        </button>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
