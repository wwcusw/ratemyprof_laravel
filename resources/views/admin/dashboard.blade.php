<x-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Admin Dashboard
            </h2>
        </div>
    </x-slot>

    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="py-12 flex flex-col items-center h-full">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8 h-full w-full flex flex-col items-center">
            <h3 class="text-lg font-semibold mb-2 text-center text-gray-800 dark:text-gray-200">Welcome, {{ Auth::user()->name }}!</h3>
            <div class="flex flex-col items-center gap-4">
                <a href="{{ route('admin.evaluations') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow mx-auto text-base text-center min-w-[180px]">
                    Go to Evaluations
                </a>
                <a href="{{ route('admin.accounts') }}"
                   class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg shadow mx-auto text-base text-center min-w-[180px]">Manage Accounts</a>
            </div>
        </div>
    </div>
    @else
    <div class="text-red-500 text-center mt-10 text-lg">
        Unauthorized access.
    </div>
    @endif
</x-layout> 