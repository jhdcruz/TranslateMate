@section('title', 'Translate')

{{-- Content --}}
<div class="min-w-full p-6 mx-auto md:max-w-8xl lg:p-8">

    <div class="flex justify-center">
        <h2 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100">TranslateMate</h2>
    </div>

    <form wire:submit="translate" class="mt-16">
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:gap-8">
            {{-- Translate from div box --}}
            <div
                class="min-w-[46%] scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none focus:outline focus:outline-2 focus:outline-indigo-500">
                <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Translate from
                </label>
                <select wire:model.lazy="from_lang" id="countries"
                    class="block w-full p-2 mb-4 text-sm text-gray-900 border border-gray-300 rounded-lg max-w-fit bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>Choose a language</option>

                    {{-- List available languages support by ACS --}}
                    @foreach ($languages as $language)
                        <option wire:key="{{ $language['code'] }}" value="{{ $language['code'] }}">
                            {{ $language['name'] }}</option>
                    @endforeach
                </select>

                <textarea wire:model="from_text" id="message" rows="10"
                    class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    maxlength="300" placeholder="Text to translate..."></textarea>

                <div class="flex justify-end mt-4">
                    <button wire:loading.remove wire:target="translate" type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <x-gmdi-translate class="h-4 mr-2 2-4" />
                        Translate
                    </button>

                    <button disabled wire:loading wire:target="translate" type="button"
                        class="py-2.5 px-5 me-2 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 inline-flex items-center">
                        <svg aria-hidden="true" role="status"
                            class="inline w-4 h-4 text-gray-200 me-3 animate-spin dark:text-gray-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="#1C64F2" />
                        </svg>
                        Translating...
                    </button>
                </div>
            </div>


            {{-- Translate to div box --}}
            <div
                class="p-6 scale-100 bg-white rounded-lg shadow-2xl dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 shadow-gray-500/20 dark:shadow-none focus:outline focus:outline-2 focus:outline-indigo-500">


                <div class="flex items-center justify-between min-w-full align-middle">
                    <div>
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Translate to
                        </label>
                        <select id="countries"
                            class="block w-full p-2 mb-4 text-sm text-gray-900 border border-gray-300 rounded-lg max-w-fit bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            wire:model.lazy="to_lang">
                            <option selected>Choose a language</option>

                            {{-- List available languages support by ACS --}}
                            @foreach ($languages as $language)
                                <option wire:key="{{ $language['code'] }}" value="{{ $language['code'] }}">
                                    {{ $language['name'] }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="flex flex-row items-center space-x-2">
                        <button type="button"
                            onclick="tts('{{ $to_text }}', '{{ $to_lang }}', '{{ $to_lang_name }}')"
                            class="p-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 {{ $to_text ? 'hover:bg-gray-100 hover:text-blue-700 dark:hover:text-white dark:hover:bg-gray-700' : '' }} "
                            {{ $to_text ? '' : 'disabled' }}>
                            <x-gmdi-record-voice-over-o />
                            <span class="sr-only">Dictate </span>
                        </button>

                        <button type="button" data-modal-target="ai-modal" data-modal-toggle="ai-modal"
                            wire:click="explain"
                            class="p-2.5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 {{ $to_text ? 'hover:bg-gray-100 hover:text-blue-700 dark:hover:text-white dark:hover:bg-gray-700' : '' }} "
                            {{ $to_text ? '' : 'disabled' }}>
                            <x-gmdi-question-mark />
                            <span class="sr-only">Explain translated text</span>
                        </button>

                    </div>

                </div>

                <textarea wire:model="to_text" id="message" rows="10"
                    class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-900 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    maxlength="300" placeholder="Translated text will show here." readonly></textarea>


                <p class="mt-3 text-sm font-semibold tracking-tight text-gray-400 dark:text-gray-500">* Dictation are
                    not
                    available for certain languages.</p>
            </div>
        </div>
    </form>

    <!-- Explanation modal -->
    <div wire:ignore.self id="ai-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden absolute top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Translation</h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="ai-modal">
                        <x-gmdi-close class="w-3 h-3" />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="min-w-full p-4 space-y-4 md:p-5">
                    <p id="explanation" wire:model="explanation_text"
                        class="text-gray-200 min-w-min dark:text-gray-100">
                        <span wire:loading.remove wire:target="translate">{{ $explanation_text }}</span>
                        <span wire:loading wire.target="translate">
                            <svg role="status" class="w-6 h-6 mx-auto my-5 text-center animate-spin"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="#1C64F2" />
                            </svg>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // text to speech by MDN docs
    function tts(text, code, langName) {
        if ('speechSynthesis' in window) {
            // Chrome loads voices asynchronously.
            window.speechSynthesis.onvoiceschanged = function(e) {
                speechSynthesis.getVoices();
            }
        }

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = code + '-' + langName;

        speechSynthesis.speak(utterance);

        utterance.onend = function() {
            console.log('Speech has finished');
            speechSynthesis.cancel()
        }

        utterance.onerror = function(event) {
            console.error('Speech error:', event.error);
        }
    }
</script>
