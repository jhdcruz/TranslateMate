<?php

namespace App\Livewire;

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

    /**
     * @throws ConnectionException
     */
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

        Log::debug('ACS response: ', $response ?? []);

        $tlText = $response[0]['translations'][0]['text'];
        // Save the translation to the database if there is a logged-in user
        $user = auth()->user();
        if ($user && $response) {
            Translation::create([
                'from_lang' => $this->from_lang,
                'to_lang' => $this->to_lang,
                'from_text' => $this->from_text,
                'to_text' => $tlText,
                'created_at' => now(),
                'user_id' => $user->id,
            ]);
        }

        // this gets updated in the view wire:model `to_text`
        $this->to_text = $tlText ?? 'Something went wrong, please try again later.';
    }

    public function render(): View
    {
        return view('livewire.translate');
    }
}
