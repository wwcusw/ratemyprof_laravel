@props(['logo' => null])

<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-900">
    <div class="mb-6 flex justify-center w-full">
        <img src="/images/pcu-logo.png" alt="PCU Logo" class="h-16 w-auto" />
    </div>
    <div class="w-full max-w-md px-8 py-6 bg-white dark:bg-gray-800 shadow-lg rounded-xl">
        {{ $slot }}
    </div>
</div> 