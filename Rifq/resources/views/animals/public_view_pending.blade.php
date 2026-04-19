@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center" dir="rtl">
    <div class="max-w-md mx-auto px-4">
        <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
            <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-6">
                <p class="text-lg font-semibold text-amber-800 mb-1">
                    {{ __('messages.data_entry_in_progress') ?: 'إدخال البيانات قيد التنفيذ' }}
                </p>
                <p class="text-sm text-amber-600">
                    Data entry is in progress
                </p>
            </div>

            <div class="mb-6">
                <span class="text-sm text-gray-500">{{ __('messages.serial_number') ?: 'الرقم التسلسلي' }}</span>
                <p class="text-2xl font-mono font-bold text-emerald-700 mt-1">{{ $animal->serial_number }}</p>
            </div>

            <p class="text-sm text-gray-500">
                {{ __('messages.pending_message') ?: 'بيانات هذا الحيوان لم يتم إدخالها بعد. يرجى التحقق لاحقاً.' }}
            </p>
            <p class="text-sm text-gray-400 mt-1">
                This animal's data has not been entered yet. Please check back later.
            </p>

            <div class="mt-8 text-xs text-gray-400">
                {{ __('messages.rifq_system') ?: 'نظام رفق' }} &copy; {{ date('Y') }}
            </div>
        </div>
    </div>
</div>
@endsection
