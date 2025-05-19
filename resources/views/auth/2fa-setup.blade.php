<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Two-Factor Authentication Setup') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto">
        <p>Scan this QR code with your Google Authenticator app:</p>
        <div class="flex justify-center my-4 bg-gray-800 p-4 rounded">
            {!! $QR_Image !!}
        </div>
        <p>Or enter this code manually: <strong>{{ $secret }}</strong></p>
    </div>
</x-app-layout>
