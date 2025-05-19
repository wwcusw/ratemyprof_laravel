<x-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                All Evaluations
            </h2>
        </div>
    </x-slot>

    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="py-6 flex flex-col items-center">
        <div class="w-full max-w-4xl">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-8">
                <div class="flex flex-wrap items-center justify-center mb-6 gap-x-10 gap-y-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    {{-- Filter Evaluations --}}
                    <form method="GET" action="{{ route('admin.evaluations') }}" class="flex items-center gap-6">
                        <label for="semester" class="text-sm font-medium text-gray-800 dark:text-gray-200">Filter by Semester:</label>
                        <select name="semester" id="semester" class="rounded-md border-gray-300 dark:bg-gray-800 dark:text-gray-100">
                            <option value="">All</option>
                            <option value="2024-2025_2nd" {{ request('semester') == '2024-2025_2nd' ? 'selected' : '' }}>2024-2025 2nd</option>
                            <option value="2024-2025_1st" {{ request('semester') == '2024-2025_1st' ? 'selected' : '' }}>2024-2025 1st</option>
                            <option value="2025-2026_1st" {{ request('semester') == '2025-2026_1st' ? 'selected' : '' }}>2025-2026 1st</option>
                        </select>
                        <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm">Apply</button>
                    </form>

                    {{-- Set Semester (Dropdown) --}}
                    <form method="POST" action="{{ route('admin.setSemester') }}" class="flex items-center gap-6">
                        @csrf
                        <label for="set_semester" class="text-sm font-medium text-gray-800 dark:text-gray-200">Set Current Semester:</label>
                        <select name="semester" id="set_semester"
                            class="rounded-md border border-gray-300 px-2 py-1 dark:bg-gray-800 dark:text-gray-100 text-sm"
                            required>
                            @php
                                $semesters = ['2024-2025_2nd', '2024-2025_1st', '2025-2026_1st'];
                                $current = \Illuminate\Support\Facades\DB::table('settings')->where('key', 'current_semester')->value('value');
                            @endphp

                            @foreach ($semesters as $semester)
                                <option value="{{ $semester }}" {{ $current === $semester ? 'selected' : '' }}>{{ str_replace('_', ' ', $semester) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded-md text-sm">Save</button>
                    </form>

                    {{-- Publish Toggle --}}
                    <form method="POST" action="{{ route('admin.toggleResults') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm rounded-md {{ $published ? 'bg-green-600' : 'bg-gray-500' }} text-white">
                            {{ $published ? 'Hide Results from Faculty' : 'Publish Results to Faculty' }}
                        </button>
                    </form>
                </div>

                {{-- Add separation space --}}
                <div class="my-6"></div>

                {{-- Evaluations Table --}}
                @if($evaluations->isEmpty())
                    <p class="text-gray-400">No evaluations submitted yet.</p>
                @else
                <div class="overflow-auto mt-6 flex justify-center">
                    <table class="min-w-full border dark:border-gray-700 text-sm text-left w-auto mx-auto">
                        <thead class="bg-gray-200 dark:bg-gray-900 dark:text-gray-100">
                            <tr>
                                <th class="px-4 py-2">Student</th>
                                <th class="px-4 py-2">Professor</th>
                                <th class="px-4 py-2">Semester</th>
                                <th class="px-4 py-2">Scores</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Grade</th>
                                <th class="px-4 py-2">Comment</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                            @foreach($evaluations as $evaluation)
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
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-4 py-2">{{ $evaluation->student->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $evaluation->professor->name ?? $evaluation->professor }}</td>
                                <td class="px-4 py-2">{{ $evaluation->semester }}</td>
                                <td class="px-4 py-2 whitespace-pre">@for($i = 1; $i <= 10; $i++) Q{{ $i }}: {{ $evaluation->{'q'.$i} }}{{ $i < 10 ? "\n" : '' }} @endfor</td>
                                <td class="px-4 py-2 font-bold">{{ $total }}</td>
                                <td class="px-4 py-2">{{ $grade }}</td>
                                <td class="px-4 py-2 italic">{{ $evaluation->comment ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="text-red-500 text-center mt-10 text-lg">
        Unauthorized access.
    </div>
    @endif
</x-layout>
