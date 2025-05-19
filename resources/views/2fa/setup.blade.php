<x-guest-layout>
    <h2 class="text-xl font-bold mb-6 text-center text-white">Enable Two-Factor Authentication</h2>
    <div class="flex flex-col items-center">
        <div class="mb-6">{!! $QR_Image !!}</div>
        <form method="POST" action="{{ route('2fa.enable') }}" class="w-full max-w-xs space-y-4">
            @csrf
            <input type="hidden" name="secret" value="{{ $secret }}">
            <x-input-label for="otp" value="One-Time Password" />
            <x-text-input id="otp" name="otp" type="text" required autofocus class="w-full" />
            @error('otp')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
            <x-primary-button class="w-full">Enable 2FA</x-primary-button>
        </form>
    </div>
</x-guest-layout>
