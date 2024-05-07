<?php

namespace App\Livewire;

use App\Http\Controllers\InferenceController;
use App\Models\Translation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Translate extends Component
{
    public $languages = [];

    public $from_lang = '';

    public $to_lang = '';

    public $from_text = '';

    public $to_text = '';

    public $to_lang_name = '';

    public $explanation_text = '';

    /**
     * @throws ConnectionException
     */
    public function mount(): void
    {
        // Load the languages from the Azure Cognitive Services API
        $response = Http::withQueryParameters([
            'api-version' => '3.0',
            'scope' => 'translation',
        ])->get('https://api.cognitive.microsofttranslator.com/languages')->json();

        // get name and code
        $this->languages = collect($response['translation'])->map(function ($value, $key) {
            return [
                'name' => $value['name'],
                'code' => $key,
            ];
        })->toArray();

        Log::debug('ACS parsed languages: ', $this->languages);
    }

    public function translate(): void
    {
        // Get the Azure Cognitive Services key and endpoint from the config
        $key = config('services.az.tr1');
        $endpoint = config('services.az.endpoint');
        $region = config('services.az.region');

        $this->validate([
            'from_lang' => 'required',
            'to_lang' => 'required',
            'from_text' => 'required',
        ]);

        // Make the API call to Azure Cognitive Services
        try {
            $response = Http::withHeaders([
                'Ocp-Apim-Subscription-Key' => $key,
                'Ocp-Apim-Subscription-Region' => $region,
                'Content-Type' => 'application/json; charset=UTF-8',
            ])->withQueryParameters([
                'api-version' => '3.0',
                'from' => $this->from_lang,
                'to' => $this->to_lang,
                'allowFallback' => 'true',
            ])->post($endpoint.'/translate', [
                [
                    'Text' => $this->from_text,
                ],
            ])->json();
        } catch (ConnectionException $e) {
            Log::error('Azure connection error: '.$e->getMessage());
            $response = null;
        }

        Log::debug('ACS response: ', $response ?? []);

        $tlText = $response[0]['translations'][0]['text'];
        // Save the translation to the database if there is a logged-in user
        if (auth()->user() && $response) {
            // get from lang name
            $fromLangName = collect($this->languages)->firstWhere('code', $this->from_lang)['name'];
            // get to lang name
            $this->to_lang_name = collect($this->languages)->firstWhere('code', $this->to_lang)['name'];

            Translation::create([
                'from_lang' => $this->from_lang,
                'from_lang_name' => $fromLangName,
                'to_lang' => $this->to_lang,
                'to_lang_name' => $this->to_lang_name,
                'from_text' => $this->from_text,
                'to_text' => $tlText,
                'created_at' => now(),
                'user_id' => auth()->id(),
            ]);
        }

        // this gets updated in the view wire:model `to_text`
        $this->to_text = $tlText ?? 'Something went wrong, please try again later.';
    }

    public function explain(): void
    {
        $utils = new InferenceController();
        $this->explanation_text = $utils->explain_translated(
            $this->to_text,
            collect($this->languages)->firstWhere('code', $this->from_lang)['name'],
            collect($this->languages)->firstWhere('code', $this->to_lang)['name'],
        );
    }

    public function render(): View
    {
        return view('livewire.translate');
    }
}
