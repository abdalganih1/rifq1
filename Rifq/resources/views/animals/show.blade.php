<x-app-layout>
    <div class="py-8 max-w-5xl mx-auto" dir="rtl">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
                {{ $animal->serial_number ?? $animal->uuid }}
            </h1>
            <div class="flex gap-2">
                <a href="{{ route('animals.data-entry', $animal->id) }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 text-sm">
                    {{ __('messages.edit') ?: 'تعديل' }}
                </a>
                <a href="{{ route('animals.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 text-sm">
                    {{ __('messages.animal_registry') ?: 'سجل الحيوانات' }}
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                @if($animal->image_path)
                    <img src="{{ asset('storage/' . $animal->image_path) }}" alt="{{ $animal->animal_type }}" class="w-full rounded-xl shadow-lg object-cover h-64">
                @else
                    <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 rounded-xl flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                <div class="mt-4 p-4 bg-white dark:bg-gray-800 rounded-xl shadow">
                    <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">{{ __('messages.status') ?: 'الحالة' }}</h3>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $animal->data_entered_status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $animal->data_entered_status ? __('messages.data_entered') : __('messages.data_pending') }}
                    </span>
                </div>
            </div>

            <div class="md:col-span-2 space-y-4">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-4 border-b pb-2">
                        {{ __('messages.animal_type') ?: 'معلومات أساسية' }}
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        @if($animal->animal_type)
                            <div><span class="text-gray-500 text-sm">{{ __('messages.animal_type') ?: 'النوع' }}</span><p class="font-medium">{{ $animal->animal_type }}</p></div>
                        @endif
                        @if($animal->breed_name)
                            <div><span class="text-gray-500 text-sm">{{ __('messages.breed') ?: 'السلالة' }}</span><p class="font-medium">{{ $animal->breed_name }}</p></div>
                        @endif
                        @if($animal->gender)
                            <div><span class="text-gray-500 text-sm">{{ __('messages.gender') ?: 'الجنس' }}</span><p class="font-medium">{{ $animal->gender }}</p></div>
                        @endif
                        @if($animal->estimated_age)
                            <div><span class="text-gray-500 text-sm">{{ __('messages.age') ?: 'العمر' }}</span><p class="font-medium">{{ $animal->estimated_age }}</p></div>
                        @endif
                        @if($animal->color)
                            <div><span class="text-gray-500 text-sm">{{ __('messages.color') ?: 'اللون' }}</span><p class="font-medium">{{ $animal->color }}</p></div>
                        @endif
                        @if($animal->serial_number)
                            <div><span class="text-gray-500 text-sm">{{ __('messages.serial_number') ?: 'الرقم التسلسلي' }}</span><p class="font-medium font-mono">{{ $animal->serial_number }}</p></div>
                        @endif
                    </div>
                </div>

                @if($animal->distinguishing_marks)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-2">{{ __('messages.distinguishing_marks') ?: 'العلامات المميزة' }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ $animal->distinguishing_marks }}</p>
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-4 border-b pb-2">{{ __('messages.location') ?: 'الموقع' }}</h3>
                    <div class="grid grid-cols-2 gap-4">
                        @if($animal->city_province)
                            <div><span class="text-gray-500 text-sm">{{ __('messages.city_province') ?: 'المدينة/المحافظة' }}</span><p class="font-medium">{{ $animal->city_province }}</p></div>
                        @endif
                        @if($animal->relocation_place)
                            <div><span class="text-gray-500 text-sm">{{ __('messages.relocation_place') ?: 'مكان الترحيل' }}</span><p class="font-medium">{{ $animal->relocation_place }}</p></div>
                        @endif
                    </div>
                </div>

                @if($animal->independentTeam)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-2">{{ __('messages.teams') ?: 'الفريق' }}</h3>
                        <p class="text-gray-600 dark:text-gray-300">{{ $animal->independentTeam->name }}</p>
                        @if($animal->independentTeam->governorate)
                            <p class="text-sm text-gray-500">{{ $animal->independentTeam->governorate->name }}</p>
                        @endif
                    </div>
                @endif

                @if($animal->emergency_contact_phone)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                        <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-2">{{ __('messages.emergency_phone') ?: 'هاتف الطوارئ' }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 font-mono">{{ $animal->emergency_contact_phone }}</p>
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                    <h3 class="font-semibold text-lg text-gray-700 dark:text-gray-200 mb-2 text-sm text-gray-400">
                        {{ __('messages.serial_number') ?: 'UUID' }}: {{ $animal->uuid }}
                    </h3>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
