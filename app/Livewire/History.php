<?php

namespace App\Livewire;

use App\Models\Translation;
use Illuminate\View\View;
use Livewire\Component;

class History extends Component
{
    public $history = [];

    public $to_text = '';
    public $explanation_text = '';

    public function mount(): void
    {
        // get user's translation history
        $user = auth()->id();
        $this->history = Translation::where('user_id', $user)->latest()->get();
    }

    public function explain(): void
    {
        // use openai to explain the translated message concisely
        $this->explanation_text = explain_translated($this->to_text);
    }

    public function render(): View
    {
        return view('livewire.history');
    }
}
