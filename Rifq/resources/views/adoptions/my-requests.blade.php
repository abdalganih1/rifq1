<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('طلبات التبني الخاصة بي') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($requests->count() > 0)
                <div class="space-y-6">
                    @foreach($requests as $request)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <!-- Animal Info -->
                                <div class="md:w-1/3 bg-gradient-to-br from-purple-400 to-pink-400 p-6 flex items-center justify-center">
                                    <div class="text-center text-white">
                                        <svg class="w-16 h-16 mx-auto mb-2 opacity-80" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M18 4c-1 0-2 .5-3 1-.5-.5-1-1-2-1s-2 .5-3 1c-.5-.5-1-1-2-1s-2 .5-3 1c-1-.5-2-1-3-1v2c1 0 1.5.5 2 1 .5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1s1.5.5 2 1c.5-.5 1-1 2-1v-2zM6 9v11h3v-5c0-1.1.9-2 2-2s2 .9 2 2v5h3V9H6z"/>
                                        </svg>
                                        <h3 class="text-xl font-bold">{{ $request->animal->name ?? 'حيوان' }}</h3>
                                        <p class="text-sm opacity-90">{{ $request->animal->breed }}</p>
                                    </div>
                                </div>
                                
                                <!-- Request Details -->
                                <div class="flex-1 p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <span class="text-sm text-gray-500">طلب #{{ $request->id }}</span>
                                            <p class="text-sm text-gray-500">
                                                {{ $request->request_date->format('Y-m-d H:i') }}
                                            </p>
                                        </div>
                                        @if($request->status === 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                                قيد المراجعة
                                            </span>
                                        @elseif($request->status === 'approved')
                                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                                تم القبول ✓
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm">
                                                مرفوض ✗
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="mb-4">
                                        <h4 class="font-semibold text-gray-700 mb-2">رسالتك:</h4>
                                        <p class="text-gray-600 bg-gray-50 p-3 rounded-lg">
                                            {{ $request->request_message }}
                                        </p>
                                    </div>
                                    
                                    @if($request->status === 'approved')
                                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                            <p class="text-green-800 font-semibold">🎉 تهانينا! تم قبول طلبك</p>
                                            <p class="text-sm text-green-600 mt-1">
                                                سيتم التواصل معك قريباً لإتمام عملية التبني
                                            </p>
                                        </div>
                                    @endif
                                    
                                    @if($request->status === 'rejected' && $request->rejection_reason)
                                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                            <h4 class="font-semibold text-red-800 mb-1">سبب الرفض:</h4>
                                            <p class="text-red-600">{{ $request->rejection_reason }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($request->animal->organization)
                                        <div class="mt-4 pt-4 border-t">
                                            <p class="text-sm text-gray-500">
                                                <span class="font-medium">المأوى:</span> 
                                                {{ $request->animal->organization->name }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $requests->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-600 mb-2">لا توجد طلبات تبني</h3>
                    <p class="text-gray-500 mb-6">لم تقم بتقديم أي طلبات تبني بعد</p>
                    <a href="{{ route('adoptions.index') }}" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700">
                        تصفح الحيوانات المتاحة
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
