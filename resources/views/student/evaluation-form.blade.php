<style>
    input[type="radio"].simple-radio {
        accent-color: #000;
        box-shadow: none !important;
        transition: none !important;
    }
</style>

<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Evaluation Form') }}
        </h2>
    </x-slot>

    <div class="py-6 flex justify-center bg-gray-100 dark:bg-gray-900 min-h-screen">
        <form action="{{ route('evaluation.submit') }}" method="POST" class="bg-white dark:bg-gray-800 shadow p-8 rounded-xl flex flex-col items-center w-full max-w-2xl">
            @csrf

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-4 text-green-600 font-semibold">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 text-red-600 font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Professor Dropdown --}}
            <div class="mb-16 w-full flex justify-center">
                <div class="w-full max-w-xl bg-gray-50 dark:bg-gray-700 rounded-lg shadow p-6 flex flex-col items-center">
                    <label for="faculty_user_id" class="block font-semibold text-gray-700 dark:text-gray-200 mb-4 text-center">
                        Select Professor
                    </label>
                    @if (isset($professors) && $professors->count())
                        <select name="faculty_user_id" id="faculty_user_id" required class="w-full max-w-md border rounded px-3 py-2 text-center">
                            <option disabled selected>-- Choose a professor --</option>
                            @foreach ($professors as $prof)
                                <option value="{{ $prof->user_id }}">{{ $prof->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-red-500">You have already evaluated all professors this semester.</p>
                    @endif
                </div>
            </div>

            {{-- Evaluation Questions --}}
            @php
                $questions = [
                    "How would you rate the professor's communication skills?",
                    "How clearly did the professor explain the lessons?",
                    "Was the professor approachable for questions or help?",
                    "How punctual was the professor for classes?",
                    "How organized were the lectures and materials?",
                    "Was the professor knowledgeable about the subject?",
                    "Did the professor encourage class participation?",
                    "How effective were the assessments and grading?",
                    "How engaging were the teaching methods used?",
                    "Overall, how satisfied are you with the professor's teaching?"
                ];
            @endphp

            @foreach ($questions as $index => $question)
                <div class="mb-6 w-full flex justify-center @if($index === 0) mt-8 @endif">
                    <div class="w-full max-w-xl bg-gray-50 dark:bg-gray-700 rounded-lg shadow p-6">
                        <label class="block font-medium text-gray-700 dark:text-gray-200 mb-4">
                            {{ $question }}
                        </label>
                        @php
                            $labels = ['Very Dissatisfied', 'Dissatisfied', 'Neutral', 'Satisfied', 'Very Satisfied'];
                        @endphp
                        <div class="flex flex-col gap-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="q{{ $index + 1 }}" value="{{ $i }}" class="simple-radio h-5 w-5 mr-2" required>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $labels[$i-1] }}</span>
                                </label>
                            @endfor
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Anonymous Comment Field --}}
            <div class="mb-6 w-full flex justify-center">
                <div class="w-full max-w-xl bg-gray-50 dark:bg-gray-700 rounded-lg shadow p-6 flex flex-col items-center">
                    <label for="comment" class="block font-medium text-gray-700 dark:text-gray-200 mb-2 text-center">
                        Optional Anonymous Comment or Suggestion
                    </label>
                    <textarea name="comment" id="comment" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                </div>
            </div>

            {{-- Semester --}}
            <input type="hidden" name="semester" value="{{ $currentSemester }}">

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-10 rounded-lg mt-8 shadow-lg transition-all duration-150 cursor-pointer text-lg">
                Submit Evaluation
            </button>
        </form>
    </div>
</x-layout>
