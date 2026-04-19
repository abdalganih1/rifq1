@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.team_dashboard') ?: 'لوحة تحكم الفريق' }}</h1>
            @isset($team)
            <p class="text-gray-600 mt-2">{{ $team->name }} - {{ $team->governorate }}</p>
            @endisset
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 border-r-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.total_animals') ?: 'إجمالي الحيوانات' }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalAnimals ?? 0 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-6 border-r-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.entered_animals') ?: 'بيانات مدخلة' }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $enteredAnimals ?? 0 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm p-6 border-r-4 border-amber-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">{{ __('messages.pending_animals') ?: 'بانتظار الإدخال' }}</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $pendingAnimals ?? 0 }}</p>
                    </div>
                    <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('animals.qr') ?? '#' }}" class="inline-flex items-center px-5 py-3 bg-green-700 text-white rounded-xl font-semibold hover:bg-green-800 transition-colors">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                {{ __('messages.generate_qr') ?: 'إنشاء QR' }}
            </a>
            <a href="{{ route('animals.enter-data') ?? '#' }}" class="inline-flex items-center px-5 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                {{ __('messages.enter_data') ?: 'إدخال بيانات' }}
            </a>
            <a href="{{ route('animals.index') ?? '#' }}" class="inline-flex items-center px-5 py-3 bg-gray-700 text-white rounded-xl font-semibold hover:bg-gray-800 transition-colors">
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                {{ __('messages.view_registry') ?: 'عرض السجل' }}
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">{{ __('messages.recent_animals') ?: 'أحدث الحيوانات' }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('messages.serial_number') ?: 'الرقم التسلسلي' }}</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('messages.animal_type') ?: 'نوع الحيوان' }}</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('messages.data_status') ?: 'حالة البيانات' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @isset($recentAnimals)
                            @foreach($recentAnimals as $animal)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-green-700">#{{ $animal->serial_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $animal->animal_type }}</td>
                                <td class="px-6 py-4">
                                    @if($animal->data_entered_status ?? false)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        {{ __('messages.completed') ?: 'مكتمل' }}
                                    </span>
                                    @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                        {{ __('messages.pending') ?: 'قيد الانتظار' }}
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500">{{ __('messages.no_animals') ?: 'لا توجد حيوانات مسجلة' }}</td>
                            </tr>
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
