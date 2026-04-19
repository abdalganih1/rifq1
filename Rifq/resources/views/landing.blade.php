@extends('layouts.guest')

@section('content')
<div class="min-h-screen" dir="rtl">

    <section class="relative bg-gradient-to-bl from-emerald-600 via-green-700 to-teal-800 text-white overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28 lg:py-40">
            <div class="text-center">
                <h1 class="text-6xl lg:text-8xl font-bold mb-6 tracking-tight">رِفْق</h1>
                <p class="text-xl lg:text-2xl text-green-100 max-w-3xl mx-auto mb-4">
                    {{ __('messages.landing_tagline') ?: 'مشروع إنساني لرعاية الحيوانات المشردة وحمايتها في العراق' }}
                </p>
                <p class="text-lg text-green-200 max-w-2xl mx-auto mb-10">
                    {{ __('messages.landing_subtitle') ?: 'نسعى لبناء مجتمع أكثر رحمة تجاه الحيوانات من خلال فرق مستقلة في جميع المحافظات' }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('animals.index') ?? '#' }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-green-700 font-bold rounded-xl hover:bg-green-50 transition-all shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        {{ __('messages.view_registry') ?: 'عرض السجل' }}
                    </a>
                    <a href="{{ route('about') ?? '#' }}" class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition-all">
                        {{ __('messages.learn_more') ?: 'اعرف المزيد' }}
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 120L1440 120L1440 60C1440 60 1200 0 720 0C240 0 0 60 0 60L0 120Z" fill="white"/></svg>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="text-center p-6 bg-green-50 rounded-2xl">
                    <div class="text-4xl font-bold text-green-700 mb-2">{{ $totalAnimals ?? 0 }}</div>
                    <div class="text-gray-600">{{ __('messages.total_animals') ?: 'إجمالي الحيوانات' }}</div>
                </div>
                <div class="text-center p-6 bg-emerald-50 rounded-2xl">
                    <div class="text-4xl font-bold text-emerald-700 mb-2">{{ $adoptedAnimals ?? 0 }}</div>
                    <div class="text-gray-600">{{ __('messages.adopted_animals') ?: 'حيوانات متبناة' }}</div>
                </div>
                <div class="text-center p-6 bg-teal-50 rounded-2xl">
                    <div class="text-4xl font-bold text-teal-700 mb-2">{{ $totalTeams ?? 0 }}</div>
                    <div class="text-gray-600">{{ __('messages.total_teams') ?: 'فرق مستقلة' }}</div>
                </div>
                <div class="text-center p-6 bg-cyan-50 rounded-2xl">
                    <div class="text-4xl font-bold text-cyan-700 mb-2">{{ $totalGovernorates ?? 0 }}</div>
                    <div class="text-gray-600">{{ __('messages.total_governorates') ?: 'محافظة' }}</div>
                </div>
            </div>
        </div>
    </section>

    @isset($recentAnimals)
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __('messages.recent_animals') ?: 'أحدث الحيوانات المسجلة' }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ __('messages.recent_animals_desc') ?: 'الحيوانات التي تم تسجيلها مؤخراً في المشروع' }}</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($recentAnimals as $animal)
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all overflow-hidden group">
                    <div class="aspect-square bg-gray-200 overflow-hidden">
                        @isset($animal->image_url)
                        <img src="{{ $animal->image_url }}" alt="{{ $animal->animal_type }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        @endisset
                    </div>
                    <div class="p-4">
                        <div class="text-xs text-green-600 font-mono mb-1"># {{ $animal->serial_number }}</div>
                        <div class="font-semibold text-gray-900">{{ $animal->animal_type }}</div>
                        <div class="text-sm text-gray-500 mt-1">{{ $animal->breed_name ?? '-' }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endisset

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __('messages.about_project') ?: 'عن مشروع رِفْق' }}</h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-6">
                        {{ __('messages.about_desc') ?: 'مشروع رِفْق هو مبادرة إنسانية تهدف إلى رعاية الحيوانات المشردة في العراق وتوفير الرعاية البيطرية اللازمة لها. نعمل من خلال فرق مستقلة في مختلف المحافظات لتقديم المساعدة والرعاية للحيوانات المحتاجة.' }}
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 ml-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ __('messages.feat_rescue') ?: 'إنقاذ الحيوانات المشردة والمصابة' }}
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 ml-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ __('messages.feat_vet') ?: 'توفير الرعاية البيطرية' }}
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 ml-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ __('messages.feat_adopt') ?: 'برنامج التبني وإعادة التأهيل' }}
                        </li>
                        <li class="flex items-center text-gray-700">
                            <svg class="w-5 h-5 text-green-500 ml-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            {{ __('messages.feat_awareness') ?: 'نشر الوعي بحقوق الحيوان' }}
                        </li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-green-100 to-emerald-100 rounded-3xl p-12 text-center">
                    <div class="text-7xl mb-6">🐾</div>
                    <h3 class="text-2xl font-bold text-green-800 mb-4">{{ __('messages.join_us') ?: 'انضم إلينا' }}</h3>
                    <p class="text-green-700 mb-6">{{ __('messages.join_desc') ?: 'كن جزءاً من التغيير الإيجابي في مجتمعنا' }}</p>
                    <a href="{{ route('contact') ?? '#' }}" class="inline-flex items-center px-6 py-3 bg-green-700 text-white rounded-xl font-semibold hover:bg-green-800 transition-colors">
                        {{ __('messages.contact_us') ?: 'تواصل معنا' }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gradient-to-bl from-emerald-600 to-green-700 text-white">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-3xl font-bold mb-4">{{ __('messages.cta_title') ?: 'ساهم في صنع الفرق' }}</h2>
            <p class="text-green-100 text-lg mb-8">{{ __('messages.cta_desc') ?: 'كل مساهمة تساعد في إنقاذ حياة حيوان مشرد وتوفير رعاية أفضل له' }}</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') ?? '#' }}" class="px-8 py-4 bg-white text-green-700 font-bold rounded-xl hover:bg-green-50 transition-all shadow-lg">
                    {{ __('messages.volunteer') ?: 'تطوع معنا' }}
                </a>
                <a href="{{ route('about') ?? '#' }}" class="px-8 py-4 border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition-all">
                    {{ __('messages.about_project') ?: 'عن المشروع' }}
                </a>
            </div>
        </div>
    </section>

</div>
@endsection
