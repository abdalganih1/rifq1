@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <section class="bg-gradient-to-bl from-emerald-600 via-green-700 to-teal-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl lg:text-5xl font-bold mb-4">{{ __('messages.contact_us') ?: 'تواصل معنا' }}</h1>
            <p class="text-green-100 text-xl max-w-2xl mx-auto">{{ __('messages.contact_desc') ?: 'نسعد بتواصلكم معنا للاستفسار أو التطوع أو المساهمة' }}</p>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
                    <div class="w-14 h-14 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ __('messages.email') ?: 'البريد الإلكتروني' }}</h3>
                    <p class="text-gray-600 text-sm">info@rifq.org</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ __('messages.phone') ?: 'الهاتف' }}</h3>
                    <p class="text-gray-600 text-sm" dir="ltr">+964 7XX XXX XXXX</p>
                </div>
                <div class="bg-white rounded-2xl shadow-sm p-8 text-center">
                    <div class="w-14 h-14 bg-teal-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ __('messages.location') ?: 'الموقع' }}</h3>
                    <p class="text-gray-600 text-sm">{{ __('messages.iraq') ?: 'العراق - مختلف المحافظات' }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-8 lg:p-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __('messages.send_message') ?: 'أرسل لنا رسالة' }}</h2>
                <form method="POST" action="{{ route('contact.send') ?? '#' }}">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.name') ?: 'الاسم' }}</label>
                            <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all" placeholder="{{ __('messages.name_placeholder') ?: 'أدخل اسمك' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.email') ?: 'البريد الإلكتروني' }}</label>
                            <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all" placeholder="{{ __('messages.email_placeholder') ?: 'example@email.com' }}" dir="ltr">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.subject') ?: 'الموضوع' }}</label>
                        <input type="text" name="subject" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all" placeholder="{{ __('messages.subject_placeholder') ?: 'موضوع الرسالة' }}">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('messages.message') ?: 'الرسالة' }}</label>
                        <textarea name="message" rows="5" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition-all resize-none" placeholder="{{ __('messages.message_placeholder') ?: 'اكتب رسالتك هنا...' }}"></textarea>
                    </div>
                    <button type="submit" class="w-full md:w-auto px-8 py-3 bg-green-700 text-white font-semibold rounded-xl hover:bg-green-800 transition-colors">
                        {{ __('messages.send') ?: 'إرسال' }}
                    </button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
