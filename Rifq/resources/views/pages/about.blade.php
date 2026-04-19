@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <section class="bg-gradient-to-bl from-emerald-600 via-green-700 to-teal-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">{{ __('messages.about_title') ?: 'عن مشروع رِفْق' }}</h1>
            <p class="text-green-100 text-xl max-w-2xl mx-auto">{{ __('messages.about_hero_desc') ?: 'رحلة compassion نحو عالم أكثر رحمة للحيوانات' }}</p>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm p-8 lg:p-12 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.our_mission') ?: 'مهمتنا' }}</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    {{ __('messages.mission_desc') ?: 'مشروع رِفْق هو مبادرة إنسانية طوعية تأسست بهدف رعاية الحيوانات المشردة في العراق وتحسين ظروف حياتها. نؤمن بأن كل كائن حي يستحق الحياة بكرامة ورعاية.' }}
                </p>
                <p class="text-gray-600 text-lg leading-relaxed">
                    {{ __('messages.mission_desc2') ?: 'نعمل من خلال شبكة من الفرق المستقلة في مختلف المحافظات العراقية لإنقاذ الحيوانات المشردة والمصابة، وتوفير الرعاية البيطرية اللازمة، وإعادة تأهيلها للتبني.' }}
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ __('messages.rescue') ?: 'الإنقاذ' }}</h3>
                    <p class="text-gray-600">{{ __('messages.rescue_desc') ?: 'إنقاذ الحيوانات المشردة والمصابة وتوفير مأمن آمن لها' }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
                    <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ __('messages.protection') ?: 'الحماية' }}</h3>
                    <p class="text-gray-600">{{ __('messages.protection_desc') ?: 'حماية الحيوانات من الإيذاء والإهمال وتوفير الرعاية البيطرية' }}</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
                    <div class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ __('messages.adoption') ?: 'التبني' }}</h3>
                    <p class="text-gray-600">{{ __('messages.adoption_desc') ?: 'إعادة تأهيل الحيوانات وربطها بأسر جديدة دائمة' }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-8 lg:p-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.our_values') ?: 'قيمنا' }}</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 ml-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ __('messages.value_compassion') ?: 'الرحمة' }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ __('messages.value_compassion_desc') ?: 'التعامل مع جميع الكائنات الحية بالرحمة واللطف' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 ml-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ __('messages.value_transparency') ?: 'الشفافية' }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ __('messages.value_transparency_desc') ?: 'العمل بشفافية تامة وموثوقية في جميع أنشطتنا' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 ml-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ __('messages.value_volunteerism') ?: 'التطوع' }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ __('messages.value_volunteerism_desc') ?: 'بناء مجتمع تطوعي نشط ومتفانٍ في خدمة الحيوانات' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 ml-3 mt-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ __('messages.value_cooperation') ?: 'التعاون' }}</h4>
                            <p class="text-gray-600 text-sm mt-1">{{ __('messages.value_cooperation_desc') ?: 'التعاون بين الفرق والمحافظات لتحقيق أهداف المشروع' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
