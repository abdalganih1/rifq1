@extends('layouts.app')

@section('content')
<div class="py-6" dir="rtl">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            {{ __('messages.generate_qr_codes') ?: 'توليد رموز QR' }}
        </h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form method="POST" action="{{ route('qrcodes.generate.submit') }}">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.select_team') ?: 'اختر الفريق' }}
                        </label>
                        <select name="team_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">{{ __('messages.select_team') ?: 'اختر الفريق' }}</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}{{ $team->governorate ? ' - ' . $team->governorate->name : '' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('messages.number_of_qr_codes') ?: 'عدد رموز QR' }}
                        </label>
                        <input type="number" name="quantity" min="1" max="100" value="10" required
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="{{ __('messages.quantity_placeholder') ?: 'أدخل العدد (1-100)' }}">
                        <p class="mt-1 text-sm text-gray-500">{{ __('messages.quantity_hint') ?: 'الحد الأقصى 100 رمز لكل طلب' }}</p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('animals.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-lg transition">
                            {{ __('messages.cancel') ?: 'إلغاء' }}
                        </a>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg transition">
                            {{ __('messages.generate') ?: 'توليد' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
