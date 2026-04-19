@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 py-8" dir="rtl">
    <div class="max-w-3xl mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            {{-- Header with image --}}
            <div class="bg-emerald-600 p-6 text-center">
                @if($animal->image_path)
                    <img src="{{ asset('storage/' . $animal->image_path) }}" alt="{{ $animal->serial_number }}" class="w-40 h-40 object-cover rounded-full border-4 border-white mx-auto shadow-lg">
                @else
                    <div class="w-40 h-40 bg-emerald-500 rounded-full border-4 border-white mx-auto flex items-center justify-center shadow-lg">
                        <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif
            </div>

            {{-- Serial Number Badge --}}
            <div class="text-center -mt-6">
                <span class="inline-block bg-emerald-600 text-white px-6 py-2 rounded-full text-lg font-mono font-bold shadow-md">
                    {{ $animal->serial_number }}
                </span>
            </div>

            <div class="p-6 space-y-6">
                {{-- Basic Info --}}
                <div>
                    <h2 class="text-lg font-semibold text-emerald-700 mb-3 border-b border-emerald-100 pb-2">
                        {{ __('messages.basic_info') ?: 'المعلومات الأساسية' }}
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        @if($animal->animal_type)
                        <div>
                            <span class="text-sm text-gray-500">{{ __('messages.animal_type') ?: 'نوع الحيوان' }}</span>
                            <p class="font-medium text-gray-900">{{ $animal->animal_type }}{{ $animal->animal_type_en ? ' / ' . $animal->animal_type_en : '' }}</p>
                        </div>
                        @endif
                        @if($animal->breed_name)
                        <div>
                            <span class="text-sm text-gray-500">{{ __('messages.breed_name') ?: 'السلالة' }}</span>
                            <p class="font-medium text-gray-900">{{ $animal->breed_name }}{{ $animal->breed_name_en ? ' / ' . $animal->breed_name_en : '' }}</p>
                        </div>
                        @endif
                        @if($animal->gender)
                        <div>
                            <span class="text-sm text-gray-500">{{ __('messages.gender') ?: 'الجنس' }}</span>
                            <p class="font-medium text-gray-900">{{ $animal->gender === 'Male' ? (__('messages.male') ?: 'ذكر') : ($animal->gender === 'Female' ? (__('messages.female') ?: 'أنثى') : (__('messages.unknown') ?: 'غير معروف')) }}</p>
                        </div>
                        @endif
                        @if($animal->estimated_age)
                        <div>
                            <span class="text-sm text-gray-500">{{ __('messages.age') ?: 'العمر' }}</span>
                            <p class="font-medium text-gray-900">{{ $animal->estimated_age }}</p>
                        </div>
                        @endif
                        @if($animal->color)
                        <div>
                            <span class="text-sm text-gray-500">{{ __('messages.color') ?: 'اللون' }}</span>
                            <p class="font-medium text-gray-900">{{ $animal->color }}{{ $animal->color_en ? ' / ' . $animal->color_en : '' }}</p>
                        </div>
                        @endif
                        @if($animal->distinguishing_marks)
                        <div class="col-span-2">
                            <span class="text-sm text-gray-500">{{ __('messages.distinguishing_marks') ?: 'العلامات المميزة' }}</span>
                            <p class="font-medium text-gray-900">{{ $animal->distinguishing_marks }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Location --}}
                @if($animal->city_province || $animal->relocation_place)
                <div>
                    <h2 class="text-lg font-semibold text-emerald-700 mb-3 border-b border-emerald-100 pb-2">
                        {{ __('messages.location_info') ?: 'معلومات الموقع' }}
                    </h2>
                    <div class="grid grid-cols-2 gap-4">
                        @if($animal->city_province)
                        <div>
                            <span class="text-sm text-gray-500">{{ __('messages.city_province') ?: 'المدينة / المحافظة' }}</span>
                            <p class="font-medium text-gray-900">{{ $animal->city_province }}</p>
                        </div>
                        @endif
                        @if($animal->relocation_place)
                        <div>
                            <span class="text-sm text-gray-500">{{ __('messages.relocation_place') ?: 'مكان النقل' }}</span>
                            <p class="font-medium text-gray-900">{{ $animal->relocation_place }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Team --}}
                @if($animal->independentTeam)
                <div>
                    <h2 class="text-lg font-semibold text-emerald-700 mb-3 border-b border-emerald-100 pb-2">
                        {{ __('messages.registering_team') ?: 'الفريق المسجل' }}
                    </h2>
                    <div class="bg-emerald-50 rounded-lg p-4">
                        <p class="font-semibold text-emerald-800">{{ $animal->independentTeam->name }}</p>
                        @if($animal->independentTeam->governorate)
                        <p class="text-sm text-emerald-600 mt-1">{{ $animal->independentTeam->governorate->name }}</p>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Emergency Contact --}}
                @if($animal->emergency_contact_phone)
                <div>
                    <h2 class="text-lg font-semibold text-emerald-700 mb-3 border-b border-emerald-100 pb-2">
                        {{ __('messages.emergency_contact') ?: 'جهة اتصال الطوارئ' }}
                    </h2>
                    <div class="bg-red-50 rounded-lg p-4 flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:{{ $animal->emergency_contact_phone }}" class="text-red-700 font-semibold text-lg" dir="ltr">{{ $animal->emergency_contact_phone }}</a>
                    </div>
                </div>
                @endif

                {{-- Medical Records --}}
                @if($animal->medicalRecords && $animal->medicalRecords->count() > 0)
                <div>
                    <h2 class="text-lg font-semibold text-emerald-700 mb-3 border-b border-emerald-100 pb-2">
                        {{ __('messages.medical_records') ?: 'السجلات الطبية' }}
                    </h2>
                    @foreach($animal->medicalRecords as $record)
                    <div class="border border-gray-200 rounded-lg p-4 mb-3">
                        @if($record->vaccine_name)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">{{ __('messages.vaccine') ?: 'اللقاح' }}</span>
                            <span class="font-medium">{{ $record->vaccine_name }}</span>
                        </div>
                        @endif
                        @if($record->procedure_name)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">{{ __('messages.procedure') ?: 'الإجراء' }}</span>
                            <span class="font-medium">{{ $record->procedure_name }}</span>
                        </div>
                        @endif
                        @if($record->date)
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">{{ __('messages.date') ?: 'التاريخ' }}</span>
                            <span class="font-medium">{{ $record->date }}</span>
                        </div>
                        @endif
                        @if($record->notes)
                        <div class="mt-2 text-sm text-gray-600">{{ $record->notes }}</div>
                        @endif
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 px-6 py-4 text-center text-xs text-gray-400">
                {{ __('messages.rifq_system') ?: 'نظام رفق' }} &copy; {{ date('Y') }}
            </div>
        </div>
    </div>
</div>
@endsection
