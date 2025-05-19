<x-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Evaluation Results') }}
            </h2>
            @if(!empty($currentSemester))
                <span class="text-base text-gray-600 dark:text-gray-300">(Semester: {{ $currentSemester }})</span>
            @endif
        </div>
    </x-slot>

    @if(auth()->check() && auth()->user()->role === 'faculty')
        <div class="py-6 max-w-5xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow p-6 rounded-lg space-y-6">

                @if ($published && !empty($averageScores) && count($averageScores))
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-white">Average Scores</h3>
                        <table class="min-w-full text-sm border dark:border-gray-700 text-left">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <tr>
                                    @foreach ($averageScores as $question => $score)
                                        <th class="px-4 py-2 text-center">{{ strtoupper($question) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                                <tr>
                                    @foreach ($averageScores as $score)
                                        <td class="px-4 py-2 text-center">{{ $score }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    @if (isset($evaluations) && count($evaluations))
                        <div>
                            <h3 class="text-lg font-semibold mt-8 mb-4 text-white">Individual Evaluations</h3>
                            <table class="min-w-full text-sm border dark:border-gray-700 text-left mb-8">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <tr>
                                        <th class="px-4 py-2">Total Score</th>
                                        <th class="px-4 py-2">Grade</th>
                                        <th class="px-4 py-2">Comment</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                                    @foreach ($evaluations as $evaluation)
                                        @php
                                            $total = 0;
                                            for ($i = 1; $i <= 10; $i++) {
                                                $total += (int) $evaluation->{'q'.$i};
                                            }
                                            if ($total >= 46) {
                                                $grade = 'Excellent';
                                            } elseif ($total >= 41) {
                                                $grade = 'Very Good';
                                            } elseif ($total >= 36) {
                                                $grade = 'Good';
                                            } elseif ($total >= 26) {
                                                $grade = 'Needs Improvement';
                                            } else {
                                                $grade = 'Poor';
                                            }
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-2 font-bold">{{ $total }}</td>
                                            <td class="px-4 py-2">{{ $grade }}</td>
                                            <td class="px-4 py-2 italic">{{ $evaluation->comment ?? '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                @elseif (!$published)
                    <p class="text-gray-600 dark:text-gray-300">Results are currently hidden by the admin.</p>
                @else
                    <p class="text-gray-600 dark:text-gray-300">No evaluation results available yet.</p>
                @endif

            </div>
        </div>
    @else
        <div class="text-red-500 text-center mt-10 text-lg">
            Unauthorized access.
        </div>
    @endif
</x-layout>
