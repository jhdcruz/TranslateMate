@section('title', 'Translate History')

<section class="p-6 mx-auto min-w-full md:max-w-8xl lg:p-8">
    <h2 class="text-3xl text-gray-900 dark:text-white font-extrabold mb-6">History</h2>

    <div class="overflow-x-auto grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-4 min-w-full">
        @foreach($history as $item)
            <button
                type="button"
                data-modal-target="ai-modal"
                data-modal-toggle="ai-modal"
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
                wire:click="explain('{{ $item["to_text"] }}', '{{ $item["from_lang_name"] }}', '{{ $item["to_lang_name"] }}')"
            >

                <h4 class="text-sm font-bold text-gray-500 dark:text-gray-400">
                    {{ $item["from_text"] }}
                </h4>

                <h5 class="mb-3 mt-1 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $item["to_text"] }}</h5>

                <h6 class="text-sm text-gray-400 dark:text-gray-500">
                    <span class="font-semibold">{{ $item["from_lang_name"] }}</span>
                    to
                    <span class="font-semibold">{{ $item["to_lang_name"] }}</span>
                </h6>

            </button>
        @endforeach
    </div>


    {{-- Explanation Modal --}}
    <div wire:ignore.self id="ai-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden absolute top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Translation</h3>
                    <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="ai-modal">
                        <x-gmdi-close class="w-3 h-3"/>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="min-w-full p-4 md:p-5 space-y-4">
                    <p id="explanation"
                       wire:model="explanation_text"
                       class="min-w-min text-gray-200 dark:text-gray-100">
                        @if ($explanation_text)
                            {{ $explanation_text }}
                        @else
                            <svg role="status"
                                 class="mx-auto text-center my-5 w-6 h-6 animate-spin"
                                 viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor"/>
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="#1C64F2"/>
                            </svg>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

</section>
