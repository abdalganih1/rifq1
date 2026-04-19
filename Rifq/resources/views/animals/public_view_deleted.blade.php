<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900" dir="rtl">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 text-center">
            <div class="w-20 h-20 mx-auto bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">
                {{ __('messages.deleted_animal_message') ?: 'تم حذف هذا السجل' }}
            </h2>
            <p class="text-gray-500 dark:text-gray-400 mb-6">
                @if(isset($animal) && $animal->serial_number)
                    {{ $animal->serial_number }}
                @endif
            </p>
            <a href="{{ route('landing') }}" class="inline-block bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition">
                {{ __('messages.home') ?: 'الرئيسية' }}
            </a>
        </div>
    </div>
</x-guest-layout>
