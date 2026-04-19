@extends('layouts.app')

@section('content')
<div class="py-6" dir="rtl">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.animal_registry') ?: 'سجل الحيوانات' }}</h1>
            <a href="{{ route('animals.data-entry') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition">
                {{ __('messages.add_animal') ?: 'إضافة حيوان' }}
            </a>
        </div>

        <form method="GET" action="{{ route('animals.index') }}" class="bg-white rounded-lg shadow p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.search') ?: 'بحث' }}</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="{{ __('messages.search_placeholder') ?: 'رقم التسلسل، النوع، السلالة...' }}"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.status') ?: 'الحالة' }}</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">{{ __('messages.all_statuses') ?: 'جميع الحالات' }}</option>
                        <option value="entered" {{ request('status') === 'entered' ? 'selected' : '' }}>{{ __('messages.entered') ?: 'مُدخل' }}</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('messages.pending') ?: 'قيد الانتظار' }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.team') ?: 'الفريق' }}</label>
                    <select name="team_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">{{ __('messages.all_teams') ?: 'جميع الفرق' }}</option>
                        @foreach($teams as $team)
                            <option value="{{ $team->id }}" {{ request('team_id') == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition">
                        {{ __('messages.filter') ?: 'تصفية' }}
                    </button>
                </div>
            </div>
        </form>

        <form id="bulkDeleteForm" method="POST" action="{{ route('animals.bulk-destroy') }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-emerald-50">
                        <tr>
                            <th class="px-4 py-3 text-right">
                                <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">{{ __('messages.serial_number') ?: 'الرقم التسلسلي' }}</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">{{ __('messages.animal_type') ?: 'نوع الحيوان' }}</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">{{ __('messages.breed_name') ?: 'السلالة' }}</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">{{ __('messages.gender') ?: 'الجنس' }}</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">{{ __('messages.color') ?: 'اللون' }}</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">{{ __('messages.team') ?: 'الفريق' }}</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">{{ __('messages.status') ?: 'الحالة' }}</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase">{{ __('messages.actions') ?: 'الإجراءات' }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($animals as $animal)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">
                                <input type="checkbox" name="selected_animals[]" value="{{ $animal->uuid }}" form="bulkDeleteForm" class="row-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            </td>
                            <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $animal->serial_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $animal->animal_type }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $animal->breed_name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $animal->gender }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $animal->color }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $animal->independentTeam?->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if($animal->status === 'entered')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ __('messages.entered') ?: 'مُدخل' }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ __('messages.pending') ?: 'قيد الانتظار' }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2">
                                    <a href="{{ route('animals.data-entry', ['animal' => $animal->uuid]) }}" class="text-emerald-600 hover:text-emerald-900" title="{{ __('messages.edit') ?: 'تعديل' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('animals.destroy', $animal->uuid) }}" class="inline" onsubmit="return confirm('{{ __('messages.confirm_delete') ?: 'هل أنت متأكد من الحذف؟' }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="{{ __('messages.delete') ?: 'حذف' }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                                {{ __('messages.no_animals_found') ?: 'لم يتم العثور على حيوانات' }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($animals->count() > 0)
            <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-t border-gray-200">
                <button type="button" onclick="submitBulkDelete()" id="bulkDeleteBtn" disabled class="bg-red-600 hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed text-white px-4 py-2 rounded-lg text-sm transition">
                    {{ __('messages.bulk_delete') ?: 'حذف المحدد' }}
                </button>
                <div class="text-sm text-gray-700">
                    {{ $animals->appends(request()->query())->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = this.checked);
    updateBulkBtn();
});

document.querySelectorAll('.row-checkbox').forEach(cb => {
    cb.addEventListener('change', updateBulkBtn);
});

function updateBulkBtn() {
    const checked = document.querySelectorAll('.row-checkbox:checked').length;
    document.getElementById('bulkDeleteBtn').disabled = checked === 0;
    document.getElementById('bulkDeleteBtn').textContent = checked > 0
        ? '{{ __("messages.bulk_delete") ?: "حذف المحدد" }} (' + checked + ')'
        : '{{ __("messages.bulk_delete") ?: "حذف المحدد" }}';
}

function submitBulkDelete() {
    if (confirm('{{ __("messages.confirm_bulk_delete") ?: "هل أنت متأكد من حذف العناصر المحددة؟" }}')) {
        document.getElementById('bulkDeleteForm').submit();
    }
}
</script>
@endsection
