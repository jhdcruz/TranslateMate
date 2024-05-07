<?php

namespace App\Livewire;

use App\Http\Controllers\InferenceController;
use App\Models\Translation;
use Illuminate\View\View;
use Livewire\Component;

class History extends Component
{
    public $history = [];

    public $explanation_text = '';

    public function mount(): void
    {
        // get user's translation history
        $user = auth()->id();
        $this->history = Translation::where('user_id', $user)->latest()->get();
    }

    public function explain(
        string $to_text,
        string $from_lang_name,
        string $to_lang_name,
    ): void {
        // use openai to explain the translated message concisely
        $utils = new InferenceController();
        $this->explanation_text = $utils->explain_translated(
            $to_text,
            $from_lang_name,
            $to_lang_name,
        );
    }

    public function render(): View
    {
        return view('livewire.history');
    }
}
