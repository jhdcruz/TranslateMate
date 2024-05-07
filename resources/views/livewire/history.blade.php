@section('title', 'Translate History')

<section class="min-w-full p-6 mx-auto md:max-w-8xl lg:p-8">
    <h2 class="mb-6 text-3xl font-extrabold text-gray-900 dark:text-white">History</h2>

    <div class="grid min-w-full grid-cols-1 gap-4 overflow-x-auto md:grid-cols-3 xl:grid-cols-5">
        @foreach ($history as $item)
            <button type="button" data-modal-target="ai-modal" data-modal-toggle="ai-modal"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
                wire:key="{{ $item['id'] }}"
                wire:click="explain('{{ $item['to_text'] }}', '{{ $item['from_lang_name'] }}', '{{ $item['to_lang_name'] }}', '{{ $item['to_lang'] }}')">

                <h4 class="text-sm font-bold text-gray-500 dark:text-gray-400">
                    {{ $item['from_text'] }}
                </h4>

                <h5 class="mt-1 mb-3 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $item['to_text'] }}</h5>

                <h6 class="text-sm text-gray-400 dark:text-gray-500">
                    <span class="font-semibold">{{ $item['from_lang_name'] }}</span>
                    to
                    <span class="font-semibold">{{ $item['to_lang_name'] }}</span>
                </h6>

            </button>
        @endforeach
    </div>


    {{-- Explanation Modal --}}
    <div wire:ignore.self id="ai-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden absolute top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">

                    <span class="flex items-center">
                        <h3 class="mr-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $selected_text }}</h3>

                        @if ($selected_lang)
                            <button type="button"
                                onclick="tts('{{ $selected_text }}', '{{ $selected_code }}', '{{ $selected_lang }}')">
                                <span class="sr-only">Dictate</span>
                                <x-gmdi-record-voice-over-o class="w-6 h-6 text-gray-400 dark:text-gray-300" />
                            </button>
                        @endif

                    </span>

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
                        @if ($explanation_text)
                            {{ $explanation_text }}
                        @else
                            <svg role="status" class="w-6 h-6 mx-auto my-5 text-center animate-spin"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="#1C64F2" />
                            </svg>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

</section>

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
