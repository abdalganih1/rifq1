<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الحيوانات المتاحة للتبني') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow mb-6 p-6">
                <div class="flex flex-wrap gap-4">
                    <select class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">كل الأنواع</option>
                        <option value="dog">كلاب</option>
                        <option value="cat">قطط</option>
                    </select>
                    <select class="border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">كل الحالات</option>
                        <option value="available_for_adoption">متاح للتبني</option>
                        <option value="in_shelter">في المأوى</option>
                    </select>
                </div>
            </div>

            <!-- Animals Grid -->
            @if($animals->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($animals as $animal)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                            <!-- Animal Image Placeholder -->
                            <div class="h-48 bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                                <svg class="w-20 h-20 text-white opacity-80" fill="currentColor" viewBox="0 0 24 24">
                                    @if($animal->species === 'dog')
                                        <path d="M18 4c-1 0-2 .5-3 1-.5-.5-1-1-2-1s-2 .5-3 1c-.5-.5-1-1-2-1s-2 .5-3 1c-1-.5-2-1-3-1v2c1 0 1.5.5 2 1 .5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1v-2zM6 9v11h3v-5c0-1.1.9-2 2-2s2 .9 2 2v5h3V9H6z"/>
                                    @else
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                                    @endif
                                </svg>
                            </div>
                            
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-gray-800">{{ $animal->name ?? 'بدون اسم' }}</h3>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                        متاح للتبني
                                    </span>
                                </div>
                                
                                <div class="text-gray-600 text-sm space-y-1 mb-4">
                                    <p><span class="font-medium">النوع:</span> {{ $animal->species === 'dog' ? 'كلب' : 'قطة' }}</p>
                                    <p><span class="font-medium">السلالة:</span> {{ $animal->breed }}</p>
                                    <p><span class="font-medium">العمر:</span> {{ $animal->estimated_age }} سنوات</p>
                                    <p><span class="font-medium">الجنس:</span> {{ $animal->gender === 'Male' ? 'ذكر' : 'أنثى' }}</p>
                                </div>
                                
                                @if($animal->organization)
                                    <p class="text-xs text-gray-500 mb-4">
                                        <span class="font-medium">المأوى:</span> {{ $animal->organization->name }}
                                    </p>
                                @endif
                                
                                <a href="{{ route('adoptions.show', $animal) }}" 
                                   class="block w-full bg-purple-600 text-white text-center py-2 rounded-lg hover:bg-purple-700 transition">
                                    عرض التفاصيل
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $animals->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">لا توجد حيوانات متاحة حالياً</h3>
                    <p class="text-gray-500">يرجى التحقق لاحقاً من توفر حيوانات جديدة للتبني</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
