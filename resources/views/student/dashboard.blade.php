<x-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Student Dashboard
            </h2>
        </div>
    </x-slot>

    @if(auth()->check() && auth()->user()->role === 'student')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl">
                <div class="p-8 text-gray-900 dark:text-gray-100 flex flex-col items-start">
                    <span class="text-lg mb-4">Welcome, {{ auth()->user()->name ?? 'student' }}!</span>
                    <a href="{{ route('evaluation.form') }}"
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
                        Fill Out Evaluation Form
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-red-500 text-center mt-10 text-lg">
        Unauthorized access.
    </div>
    @endif
</x-layout>
