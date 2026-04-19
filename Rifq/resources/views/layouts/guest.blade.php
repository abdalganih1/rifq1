<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'رِفْق') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { font-family: 'Cairo', sans-serif; }
        </style>
    </head>
    <body class="antialiased bg-gray-50">
        <div class="min-h-screen flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8 relative">
            <div class="absolute inset-0 bg-gradient-to-bl from-emerald-600 via-green-700 to-teal-800"></div>
            <div class="absolute inset-0 bg-black/20"></div>

            <div class="relative z-10 w-full max-w-md">
                <div class="text-center mb-8">
                    <a href="/" class="inline-block">
                        <h1 class="text-5xl font-bold text-white mb-2">رِفْق</h1>
                    </a>
                    <p class="text-green-100 text-sm">{{ __('messages.auth_subtitle') ?: 'مشروع إنساني لرعاية الحيوانات' }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-2xl p-8">
                    {{ $slot }}
                </div>

                <div class="text-center mt-6">
                    <a href="/" class="text-green-200 hover:text-white text-sm transition-colors">
                        &larr; {{ __('messages.back_to_home') ?: 'العودة للرئيسية' }}
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
