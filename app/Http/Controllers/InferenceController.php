<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class InferenceController extends Controller
{
    public function remove_instruction_string(string $string)
    {
        // The pattern matches <s> any characters </s>
        $pattern = "/\[INST](.*?)\[\/INST] /s";

        // Replace the matched pattern with an empty string
        return preg_replace($pattern, '', $string);
    }

    public function explain_translated(
        string $to_text,
        string $from_lang_name,
        string $to_lang_name,
    ): string {
        // use openai to explain the translated message concisely
        $key = config('services.ai.key');
        $endpoint = config('services.ai.endpoint');

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$key,
                'Content-Type' => 'application/json',
            ])->post($endpoint, [
                'inputs' => '[INST] You are a tour guide-like translator, explain and elaborate the translated '.$from_lang_name.' to '.$to_lang_name.' message: '.$to_text.' [/INST]',
            ])->json();

            Log::debug('HF Inference API response: ', $response);

            // remove the instruction text wrapped in [INST] and [/INST]
            return $this->remove_instruction_string($response[0]['generated_text']);

        } catch (ConnectionException $e) {
            Log::error('HF Inference API connection error: '.$e->getMessage());

            return 'Something went wrong...\n\nDetails:\n'.$e->getMessage();
        }
    }
}
