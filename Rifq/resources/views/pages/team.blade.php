@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <section class="bg-gradient-to-bl from-emerald-600 via-green-700 to-teal-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">{{ __('messages.our_teams') ?: 'فرقنا المستقلة' }}</h1>
            <p class="text-green-100 text-xl max-w-2xl mx-auto">{{ __('messages.teams_desc') ?: 'فرق تطوعية مستقلة تعمل في مختلف المحافظات لرعاية الحيوانات' }}</p>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @isset($teams)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($teams as $team)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center ml-4">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">{{ $team->name }}</h3>
                            <p class="text-gray-500 text-sm">{{ $team->governorate }}</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-100 pt-4">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-sm">{{ __('messages.members_count') ?: 'عدد الأعضاء' }}</span>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $team->users_count ?? $team->users->count() ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <p class="text-gray-500">{{ __('messages.no_teams') ?: 'لا توجد فرق حالياً' }}</p>
            </div>
            @endisset
        </div>
    </section>
</div>
@endsection
