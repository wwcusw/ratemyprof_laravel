<x-guest-layout>
    <h2 class="text-xl font-bold mb-6 text-center text-white">Two-Factor Authentication</h2>
    <form method="POST" action="{{ route('2fa.verify') }}" class="w-full space-y-4">
        @csrf
        <div>
            <x-input-label for="otp" value="Authentication Code" />
            <x-text-input id="otp" name="otp" type="text" required autofocus class="w-full" />
            @error('otp')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>
        <x-primary-button class="w-full">Verify</x-primary-button>
    </form>
</x-guest-layout>