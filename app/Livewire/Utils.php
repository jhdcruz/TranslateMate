<?php

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

function explain_translated(string $to_text): ArrayObject|string
{
    // use openai to explain the translated message concisely
    $key = config('services.ai.key');
    $endpoint = config('services.ai.endpoint');

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$key,
            'Content-Type' => 'application/json',
        ])->post($endpoint.'/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Behave like a multilingual tour guide, explain the translated texts in a politely concise manner.',
                ],
                [
                    'role' => 'user',
                    'content' => $to_text,
                ],
            ],
        ])->json();

        Log::debug('OpenAI response: ', $response);

        return $response['choices'][0]['message']['content'] ?? 'Something went wrong, please try again later.';
    } catch (ConnectionException $e) {
        Log::error('OpenAI connection error: '.$e->getMessage());

        return 'Something went wrong...\n\nDetails:\n'.$e->getMessage();
    }
}
