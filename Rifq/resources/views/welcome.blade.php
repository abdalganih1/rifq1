<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>رِفْق - نظام رعاية وحماية الحيوانات</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { font-family: 'Cairo', sans-serif; }
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
    </style>
</head>
<body class="font-cairo antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2 space-x-reverse">
                        <svg class="h-10 w-10 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="text-2xl font-bold text-purple-600">رِفْق</span>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4 space-x-reverse">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-purple-600 px-3 py-2">لوحة التحكم</a>
                        <a href="{{ route('adoptions.index') }}" class="text-gray-700 hover:text-purple-600 px-3 py-2">التبني</a>
                        <a href="{{ route('logout') }}" method="POST" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                            تسجيل الخروج
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600 px-3 py-2">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                            إنشاء حساب
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">نظام رعاية وحماية الحيوانات</h1>
                <p class="text-xl mb-8 opacity-90">منصة متكاملة لإدارة ورعاية الحيوانات الضالة والمأوى باستخدام تقنية رموز QR والذكاء الاصطناعي</p>
                <div class="flex justify-center space-x-4 space-x-reverse">
                    @auth
                        <a href="{{ route('adoptions.index') }}" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                            تصفح الحيوانات
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                            ابدأ الآن
                        </a>
                    @endauth
                    <a href="#features" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-purple-600">
                        اكتشف المزيد
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">مميزات النظام</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">رموز QR للحيوانات</h3>
                    <p class="text-gray-600">كل حيوان يحمل رمز QR فريد يتيح الوصول السريع لملفه الكامل وتاريخه الطبي</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">السجلات الطبية</h3>
                    <p class="text-gray-600">تتبع كامل للسجلات الطبية بما في ذلك التطعيمات والعمليات الجراحية والعلاجات</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">فحص AI الذكي</h3>
                    <p class="text-gray-600">استخدام الذكاء الاصطناعي لتحليل الصور والفيديوهات لتقييم صحة وسلوك الحيوانات</p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">طلبات التبني</h3>
                    <p class="text-gray-600">نظام متكامل لطلب تبني الحيوانات مع متابعة حالة الطلب</p>
                </div>
                
                <!-- Feature 5 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">إدارة المنظمات</h3>
                    <p class="text-gray-600">إدارة كاملة للملاجئ والمنظمات العاملة في مجال رعاية الحيوانات</p>
                </div>
                
                <!-- Feature 6 -->
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">تقارير وإحصائيات</h3>
                    <p class="text-gray-600">لوحة تحكم متقدمة مع تقارير وإحصائيات شاملة عن الحيوانات والتبني</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-purple-600 mb-2">+100</div>
                    <div class="text-gray-600">حيوان مسجل</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-green-600 mb-2">+50</div>
                    <div class="text-gray-600">حيوان تم تبنيه</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-blue-600 mb-2">+20</div>
                    <div class="text-gray-600">منظمة شريكة</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-pink-600 mb-2">+200</div>
                    <div class="text-gray-600">مستخدم نشط</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 hero-gradient text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">هل لديك حيوان ضال يحتاج مساعدة؟</h2>
            <p class="text-xl opacity-90 mb-8">انضم إلينا في مهمة حماية ورعاية الحيوانات</p>
            @auth
                <a href="{{ route('adoptions.index') }}" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                    تصفح الحيوانات المتاحة
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                    انضم الآن
                </a>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 space-x-reverse mb-4 md:mb-0">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span class="text-xl font-bold">رِفْق</span>
                </div>
                <div class="text-gray-400 text-sm">
                    © {{ date('Y') }} جميع الحقوق محفوظة - مشروع تخرج
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
