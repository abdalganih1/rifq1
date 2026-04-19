@extends('layouts.app')

@section('content')
<div class="py-6" dir="rtl">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.qr_preview') ?: 'معاينة رموز QR' }}</h1>
            @if($team)
            <span class="text-sm text-gray-600 bg-emerald-50 px-3 py-1 rounded-lg">{{ $team->name }}</span>
            @endif
        </div>

        <form id="printForm" method="POST" action="{{ route('qrcodes.print-pdf') }}">
            @csrf
            <div class="grid grid-cols-3 gap-6 mb-8">
                @foreach($qrLinks as $qr)
                <div class="bg-white rounded-lg shadow-md p-4 text-center hover:shadow-lg transition">
                    <input type="hidden" name="qr_identifiers[]" value="{{ $qr['qr_identifier'] }}">
                    <div class="mb-3">
                        @if(isset($qr['qr_image_url']))
                        <img src="{{ $qr['qr_image_url'] }}" alt="QR {{ $qr['serial_number'] }}" class="w-40 h-40 mx-auto">
                        @else
                        <div class="w-40 h-40 bg-gray-100 rounded-lg mx-auto flex items-center justify-center">
                            <span class="text-gray-400 text-xs">QR</span>
                        </div>
                        @endif
                    </div>
                    <p class="font-mono font-bold text-emerald-700 text-sm">{{ $qr['serial_number'] }}</p>
                    <p class="text-xs text-gray-400 mt-1" dir="ltr">{{ $qr['qr_identifier'] }}</p>
                </div>
                @endforeach
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('animals.generate-qrs') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-lg transition">
                    {{ __('messages.back') ?: 'رجوع' }}
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    {{ __('messages.print_pdf') ?: 'طباعة PDF' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
