@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ __('messages.trash_management') ?: 'إدارة المحذوفات' }}</h1>
                <p class="text-gray-600 mt-2">{{ __('messages.trash_desc') ?: 'الحيوانات المحذوفة مؤقتاً - يمكن استعادتها أو حذفها نهائياً' }}</p>
            </div>
            <a href="{{ route('admin.animals.index') ?? '#' }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors text-sm font-semibold">
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                {{ __('messages.back') ?: 'رجوع' }}
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('messages.serial_number') ?: 'الرقم التسلسلي' }}</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('messages.animal_type') ?: 'نوع الحيوان' }}</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('messages.team') ?: 'الفريق' }}</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">{{ __('messages.deleted_at') ?: 'تاريخ الحذف' }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase">{{ __('messages.actions') ?: 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($animals ?? [] as $animal)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-mono text-sm text-green-700">#{{ $animal->serial_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $animal->animal_type }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $animal->independentTeam->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $animal->deleted_at ? $animal->deleted_at->format('Y/m/d H:i') : '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <form method="POST" action="{{ route('admin.trash.restore', $animal->id ?? $animal->serial_number) }}" class="inline">
                                        @csrf
                                        @method('POST')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold hover:bg-blue-200 transition-colors" onclick="return confirm('{{ __('messages.confirm_restore') ?: 'هل تريد استعادة هذا الحيوان؟' }}')">
                                            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            {{ __('messages.restore') ?: 'استعادة' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.trash.destroy', $animal->id ?? $animal->serial_number) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 rounded-lg text-xs font-semibold hover:bg-red-200 transition-colors" onclick="return confirm('{{ __('messages.confirm_force_delete') ?: 'هل تريد الحذف النهائي؟ لا يمكن التراجع عن هذا الإجراء.' }}')">
                                            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            {{ __('messages.force_delete') ?: 'حذف نهائي' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                <p class="text-gray-500 text-lg">{{ __('messages.no_deleted_animals') ?: 'لا توجد حيوانات محذوفة' }}</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @isset($animals)
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $animals->withQueryString()->links() }}
                </div>
            @endisset
        </div>

    </div>
</div>
@endsection
