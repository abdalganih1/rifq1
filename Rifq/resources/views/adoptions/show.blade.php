<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4 space-x-reverse">
            <a href="{{ route('adoptions.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $animal->name ?? 'تفاصيل الحيوان' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Animal Image & Basic Info -->
                <div>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <!-- Image Placeholder -->
                        <div class="h-80 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                            <svg class="w-32 h-32 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18 4c-1 0-2 .5-3 1-.5-.5-1-1-2-1s-2 .5-3 1c-.5-.5-1-1-2-1s-2 .5-3 1c-1-.5-2-1-3-1v2c1 0 1.5.5 2 1 .5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1v-2zM6 9v11h3v-5c0-1.1.9-2 2-2s2 .9 2 2v5h3V9H6z"/>
                            </svg>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h1 class="text-3xl font-bold text-gray-800">{{ $animal->name ?? 'بدون اسم' }}</h1>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">
                                    متاح للتبني
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 text-gray-600">
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-sm text-gray-500">النوع</span>
                                    <p class="font-semibold">{{ $animal->species === 'dog' ? 'كلب' : 'قطة' }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-sm text-gray-500">السلالة</span>
                                    <p class="font-semibold">{{ $animal->breed }}</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-sm text-gray-500">العمر</span>
                                    <p class="font-semibold">{{ $animal->estimated_age }} سنوات</p>
                                </div>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <span class="text-sm text-gray-500">الجنس</span>
                                    <p class="font-semibold">{{ $animal->gender === 'Male' ? 'ذكر' : 'أنثى' }}</p>
                                </div>
                            </div>
                            
                            @if($animal->location_found)
                                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                                    <span class="text-sm text-blue-600">تم العثور عليه في:</span>
                                    <p class="text-blue-800">{{ $animal->location_found }}</p>
                                </div>
                            @endif
                            
                            @if($animal->organization)
                                <div class="mt-4 p-4 border rounded-lg">
                                    <h3 class="font-semibold text-gray-800 mb-2">المأوى المسؤول</h3>
                                    <p class="text-gray-600">{{ $animal->organization->name }}</p>
                                    @if($animal->organization->phone)
                                        <p class="text-sm text-gray-500">📞 {{ $animal->organization->phone }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Medical Records & Adoption Form -->
                <div class="space-y-6">
                    <!-- Medical Records -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 ml-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            السجلات الطبية
                        </h3>
                        
                        @if($animal->medicalRecords->count() > 0)
                            <div class="space-y-3">
                                @foreach($animal->medicalRecords as $record)
                                    <div class="border-r-4 border-purple-500 pr-4 py-2">
                                        <div class="flex justify-between items-start">
                                            <span class="font-semibold text-gray-700">
                                                {{ $record->record_type === 'Vaccination' ? 'تطعيم' : 
                                                   ($record->record_type === 'Neutering' ? 'تعقيم' : 
                                                   ($record->record_type === 'Treatment' ? 'علاج' : 'جراحة')) }}
                                            </span>
                                            <span class="text-sm text-gray-500">{{ $record->visit_date->format('Y-m-d') }}</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">{{ $record->diagnosis }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">لا توجد سجلات طبية مسجلة</p>
                        @endif
                    </div>
                    
                    <!-- Adoption Request Form -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-6 h-6 ml-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            طلب التبني
                        </h3>
                        
                        @if($existingRequest)
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <p class="text-yellow-800">
                                    @if($existingRequest->status === 'pending')
                                        لديك طلب تبني قيد المراجعة لهذا الحيوان.
                                    @elseif($existingRequest->status === 'approved')
                                        تم قبول طلب التبني الخاص بك! 🎉
                                    @endif
                                </p>
                                <a href="{{ route('adoptions.my-requests') }}" class="text-purple-600 hover:underline mt-2 inline-block">
                                    عرض طلباتي
                                </a>
                            </div>
                        @else
                            <form action="{{ route('adoptions.submit', $animal) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="request_message" class="block text-sm font-medium text-gray-700 mb-2">
                                        رسالة الطلب
                                    </label>
                                    <textarea 
                                        name="request_message" 
                                        id="request_message"
                                        rows="4"
                                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        placeholder="أخبرنا لماذا تريد تبني هذا الحيوان..."
                                        required
                                    ></textarea>
                                </div>
                                
                                <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                                    تقديم طلب التبني
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <!-- QR Code Section -->
                    @if($animal->qr_code_hash)
                        <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">رمز QR</h3>
                            <p class="text-sm text-gray-500 mb-4">امسح الرمز للوصول السريع لصفحة الحيوان</p>
                            <div class="bg-white p-4 inline-block rounded-lg border">
                                {{-- QR code will be generated here --}}
                                <div class="text-gray-400 text-xs">
                                    QR Code: {{ $animal->qr_code_hash }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
