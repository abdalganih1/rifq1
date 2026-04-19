@extends('layouts.app')

@section('content')
<div class="py-6" dir="rtl">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">
            {{ isset($animal) && $animal->exists ? (__('messages.edit_animal') ?: 'تعديل بيانات الحيوان') : (__('messages.new_animal') ?: 'تسجيل حيوان جديد') }}
        </h1>

        <form method="POST" action="{{ route('animals.store-or-update') }}" enctype="multipart/form-data" id="animalForm">
            @csrf
            @if(isset($animal) && $animal->exists)
                <input type="hidden" name="uuid" value="{{ $animal->uuid }}">
            @endif

            <div class="space-y-6">

                {{-- Basic Info --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-emerald-700 mb-4 border-b border-emerald-100 pb-2">
                        {{ __('messages.basic_info') ?: 'المعلومات الأساسية' }}
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.animal_type_ar') ?: 'نوع الحيوان (عربي)' }}</label>
                            <select name="animal_type" id="animal_type_select" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">{{ __('messages.select_type') ?: 'اختر النوع' }}</option>
                                <option value="كلب" {{ old('animal_type', $animal->animal_type ?? '') === 'كلب' ? 'selected' : '' }}>كلب</option>
                                <option value="قطة" {{ old('animal_type', $animal->animal_type ?? '') === 'قطة' ? 'selected' : '' }}>قطة</option>
                                <option value="أخرى" {{ old('animal_type', $animal->animal_type ?? '') === 'أخرى' ? 'selected' : '' }}>أخرى</option>
                                <option value="custom">{{ __('messages.custom') ?: 'مخصص' }}</option>
                            </select>
                            <input type="text" name="animal_type" id="animal_type_custom" class="hidden mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="{{ __('messages.enter_custom_type') ?: 'أدخل نوع مخصص' }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.animal_type_en') ?: 'Animal Type (EN)' }}</label>
                            <select name="animal_type_en" id="animal_type_en_select" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">{{ __('messages.select_type') ?: 'Select Type' }}</option>
                                <option value="Dog" {{ old('animal_type_en', $animal->animal_type_en ?? '') === 'Dog' ? 'selected' : '' }}>Dog</option>
                                <option value="Cat" {{ old('animal_type_en', $animal->animal_type_en ?? '') === 'Cat' ? 'selected' : '' }}>Cat</option>
                                <option value="Other" {{ old('animal_type_en', $animal->animal_type_en ?? '') === 'Other' ? 'selected' : '' }}>Other</option>
                                <option value="custom">{{ __('messages.custom') ?: 'Custom' }}</option>
                            </select>
                            <input type="text" name="animal_type_en" id="animal_type_en_custom" class="hidden mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="Enter custom type">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.breed_name_ar') ?: 'اسم السلالة (عربي)' }}</label>
                            <input type="text" name="breed_name" value="{{ old('breed_name', $animal->breed_name ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.breed_name_en') ?: 'Breed Name (EN)' }}</label>
                            <input type="text" name="breed_name_en" value="{{ old('breed_name_en', $animal->breed_name_en ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.gender') ?: 'الجنس' }}</label>
                            <select name="gender" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">{{ __('messages.select_gender') ?: 'اختر الجنس' }}</option>
                                <option value="Male" {{ old('gender', $animal->gender ?? '') === 'Male' ? 'selected' : '' }}>{{ __('messages.male') ?: 'ذكر' }}</option>
                                <option value="Female" {{ old('gender', $animal->gender ?? '') === 'Female' ? 'selected' : '' }}>{{ __('messages.female') ?: 'أنثى' }}</option>
                                <option value="Unknown" {{ old('gender', $animal->gender ?? '') === 'Unknown' ? 'selected' : '' }}>{{ __('messages.unknown') ?: 'غير معروف' }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.estimated_age') ?: 'العمر التقديري' }}</label>
                            <input type="text" name="estimated_age" value="{{ old('estimated_age', $animal->estimated_age ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="{{ __('messages.age_placeholder') ?: 'مثال: سنتان' }}">
                        </div>
                    </div>
                </div>

                {{-- Appearance --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-emerald-700 mb-4 border-b border-emerald-100 pb-2">
                        {{ __('messages.appearance') ?: 'المظهر الخارجي' }}
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.color_ar') ?: 'اللون (عربي)' }}</label>
                            <input type="text" name="color" value="{{ old('color', $animal->color ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.color_en') ?: 'Color (EN)' }}</label>
                            <input type="text" name="color_en" value="{{ old('color_en', $animal->color_en ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.distinguishing_marks') ?: 'العلامات المميزة' }}</label>
                            <textarea name="distinguishing_marks" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('distinguishing_marks', $animal->distinguishing_marks ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Location --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-emerald-700 mb-4 border-b border-emerald-100 pb-2">
                        {{ __('messages.location_info') ?: 'معلومات الموقع' }}
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.city_province') ?: 'المدينة / المحافظة' }}</label>
                            <input type="text" name="city_province" value="{{ old('city_province', $animal->city_province ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.relocation_place') ?: 'مكان النقل' }}</label>
                            <input type="text" name="relocation_place" value="{{ old('relocation_place', $animal->relocation_place ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                </div>

                {{-- Image Upload --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-emerald-700 mb-4 border-b border-emerald-100 pb-2">
                        {{ __('messages.animal_image') ?: 'صورة الحيوان' }}
                    </h2>
                    <div>
                        @if(isset($animal) && $animal->image_path)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $animal->image_path) }}" alt="{{ $animal->serial_number }}" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                {{-- Team Selection --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-emerald-700 mb-4 border-b border-emerald-100 pb-2">
                        {{ __('messages.team_assignment') ?: 'تعيين الفريق' }}
                    </h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.select_team') ?: 'اختر الفريق' }}</label>
                        <select name="independent_team_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">{{ __('messages.select_team') ?: 'اختر الفريق' }}</option>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}" {{ old('independent_team_id', $animal->independent_team_id ?? '') == $team->id ? 'selected' : '' }}>{{ $team->name }} - {{ $team->governorate?->name ?? '' }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Emergency Contact --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-lg font-semibold text-emerald-700 mb-4 border-b border-emerald-100 pb-2">
                        {{ __('messages.emergency_contact') ?: 'جهة اتصال الطوارئ' }}
                    </h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('messages.emergency_phone') ?: 'رقم هاتف الطوارئ' }}</label>
                        <input type="tel" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $animal->emergency_contact_phone ?? '') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="05XXXXXXXX">
                    </div>
                </div>

                {{-- Medical Records --}}
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <button type="button" onclick="toggleSection('medicalSection')" class="w-full flex justify-between items-center p-6 bg-emerald-50 hover:bg-emerald-100 transition">
                        <h2 class="text-lg font-semibold text-emerald-700">{{ __('messages.medical_records') ?: 'السجلات الطبية' }}</h2>
                        <svg id="medicalSectionIcon" class="w-5 h-5 text-emerald-600 transform transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <div id="medicalSection" class="hidden p-6 space-y-6 border-t border-emerald-100">

                        {{-- Medical Procedures --}}
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-medium text-gray-800">{{ __('messages.medical_procedures') ?: 'الإجراءات الطبية' }}</h3>
                                <button type="button" onclick="addProcedure()" class="text-sm bg-emerald-100 text-emerald-700 px-3 py-1 rounded hover:bg-emerald-200 transition">+ {{ __('messages.add') ?: 'إضافة' }}</button>
                            </div>
                            <div id="proceduresContainer">
                                @php $procedures = old('medical_procedures', json_decode($animal->medical_records['procedures'] ?? '[]', true) ?? []) @endphp
                                @if(is_array($procedures) && count($procedures) > 0)
                                    @foreach($procedures as $i => $proc)
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2 procedure-row border border-gray-200 rounded-lg p-3">
                                        <input type="text" name="medical_procedures[{{ $i }}][procedure_name]" value="{{ $proc['procedure_name'] ?? '' }}" placeholder="{{ __('messages.procedure_name') ?: 'اسم الإجراء' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <input type="date" name="medical_procedures[{{ $i }}][procedure_date]" value="{{ $proc['procedure_date'] ?? '' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <input type="text" name="medical_procedures[{{ $i }}][notes]" value="{{ $proc['notes'] ?? '' }}" placeholder="{{ __('messages.notes') ?: 'ملاحظات' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <button type="button" onclick="this.closest('.procedure-row').remove()" class="text-red-600 hover:text-red-800 text-sm">{{ __('messages.remove') ?: 'حذف' }}</button>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Parasite Treatments --}}
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-medium text-gray-800">{{ __('messages.parasite_treatments') ?: 'علاجات الطفيليات' }}</h3>
                                <button type="button" onclick="addParasiteTreatment()" class="text-sm bg-emerald-100 text-emerald-700 px-3 py-1 rounded hover:bg-emerald-200 transition">+ {{ __('messages.add') ?: 'إضافة' }}</button>
                            </div>
                            <div id="parasiteContainer">
                                @php $parasiteTreatments = old('parasite_treatments', json_decode($animal->medical_records['parasite_treatments'] ?? '[]', true) ?? []) @endphp
                                @if(is_array($parasiteTreatments) && count($parasiteTreatments) > 0)
                                    @foreach($parasiteTreatments as $i => $pt)
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2 parasite-row border border-gray-200 rounded-lg p-3">
                                        <input type="text" name="parasite_treatments[{{ $i }}][treatment_type]" value="{{ $pt['treatment_type'] ?? '' }}" placeholder="{{ __('messages.treatment_type') ?: 'نوع العلاج' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <input type="date" name="parasite_treatments[{{ $i }}][treatment_date]" value="{{ $pt['treatment_date'] ?? '' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <input type="text" name="parasite_treatments[{{ $i }}][notes]" value="{{ $pt['notes'] ?? '' }}" placeholder="{{ __('messages.notes') ?: 'ملاحظات' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <button type="button" onclick="this.closest('.parasite-row').remove()" class="text-red-600 hover:text-red-800 text-sm">{{ __('messages.remove') ?: 'حذف' }}</button>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Vaccinations --}}
                        <div>
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="font-medium text-gray-800">{{ __('messages.vaccinations') ?: 'التطعيمات' }}</h3>
                                <button type="button" onclick="addVaccination()" class="text-sm bg-emerald-100 text-emerald-700 px-3 py-1 rounded hover:bg-emerald-200 transition">+ {{ __('messages.add') ?: 'إضافة' }}</button>
                            </div>
                            <div id="vaccinationsContainer">
                                @php $vaccinations = old('vaccinations', json_decode($animal->medical_records['vaccinations'] ?? '[]', true) ?? []) @endphp
                                @if(is_array($vaccinations) && count($vaccinations) > 0)
                                    @foreach($vaccinations as $i => $vac)
                                    <div class="grid grid-cols-1 md:grid-cols-5 gap-2 mb-2 vaccination-row border border-gray-200 rounded-lg p-3">
                                        <input type="text" name="vaccinations[{{ $i }}][vaccine_name]" value="{{ $vac['vaccine_name'] ?? '' }}" placeholder="{{ __('messages.vaccine_name') ?: 'اسم اللقاح' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <input type="date" name="vaccinations[{{ $i }}][vaccination_date]" value="{{ $vac['vaccination_date'] ?? '' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <input type="date" name="vaccinations[{{ $i }}][next_due_date]" value="{{ $vac['next_due_date'] ?? '' }}" placeholder="{{ __('messages.next_due') ?: 'الجرعة القادمة' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <input type="text" name="vaccinations[{{ $i }}][notes]" value="{{ $vac['notes'] ?? '' }}" placeholder="{{ __('messages.notes') ?: 'ملاحظات' }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                        <button type="button" onclick="this.closest('.vaccination-row').remove()" class="text-red-600 hover:text-red-800 text-sm">{{ __('messages.remove') ?: 'حذف' }}</button>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Medical Supervisor --}}
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-medium text-gray-800 mb-3">{{ __('messages.medical_supervisor') ?: 'المشرف الطبي' }}</h3>
                            @php $supervisor = old('medical_supervisor', json_decode($animal->medical_records['supervisor'] ?? '[]', true) ?? []) @endphp
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">{{ __('messages.supervisor_name') ?: 'الاسم' }}</label>
                                    <input type="text" name="medical_supervisor[name]" value="{{ is_array($supervisor) ? ($supervisor['name'] ?? '') : '' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">{{ __('messages.supervisor_phone') ?: 'الهاتف' }}</label>
                                    <input type="tel" name="medical_supervisor[phone]" value="{{ is_array($supervisor) ? ($supervisor['phone'] ?? '') : '' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">{{ __('messages.license_number') ?: 'رقم الترخيص' }}</label>
                                    <input type="text" name="medical_supervisor[license_number]" value="{{ is_array($supervisor) ? ($supervisor['license_number'] ?? '') : '' }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end gap-3">
                    <a href="{{ route('animals.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2.5 rounded-lg transition">
                        {{ __('messages.cancel') ?: 'إلغاء' }}
                    </a>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg transition">
                        {{ isset($animal) && $animal->exists ? (__('messages.update') ?: 'تحديث') : (__('messages.save') ?: 'حفظ') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSection(id) {
    const el = document.getElementById(id);
    const icon = document.getElementById(id + 'Icon');
    el.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}

document.getElementById('animal_type_select').addEventListener('change', function() {
    document.getElementById('animal_type_custom').classList.toggle('hidden', this.value !== 'custom');
    if (this.value !== 'custom') document.getElementById('animal_type_custom').value = '';
});

document.getElementById('animal_type_en_select').addEventListener('change', function() {
    document.getElementById('animal_type_en_custom').classList.toggle('hidden', this.value !== 'custom');
    if (this.value !== 'custom') document.getElementById('animal_type_en_custom').value = '';
});

let procIdx = document.querySelectorAll('.procedure-row').length;
function addProcedure() {
    const html = `<div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2 procedure-row border border-gray-200 rounded-lg p-3">
        <input type="text" name="medical_procedures[${procIdx}][procedure_name]" placeholder="{{ __("messages.procedure_name") ?: "اسم الإجراء" }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <input type="date" name="medical_procedures[${procIdx}][procedure_date]" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <input type="text" name="medical_procedures[${procIdx}][notes]" placeholder="{{ __("messages.notes") ?: "ملاحظات" }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <button type="button" onclick="this.closest(\'.procedure-row\').remove()" class="text-red-600 hover:text-red-800 text-sm">{{ __("messages.remove") ?: "حذف" }}</button>
    </div>`;
    document.getElementById('proceduresContainer').insertAdjacentHTML('beforeend', html);
    procIdx++;
}

let paraIdx = document.querySelectorAll('.parasite-row').length;
function addParasiteTreatment() {
    const html = `<div class="grid grid-cols-1 md:grid-cols-4 gap-2 mb-2 parasite-row border border-gray-200 rounded-lg p-3">
        <input type="text" name="parasite_treatments[${paraIdx}][treatment_type]" placeholder="{{ __("messages.treatment_type") ?: "نوع العلاج" }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <input type="date" name="parasite_treatments[${paraIdx}][treatment_date]" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <input type="text" name="parasite_treatments[${paraIdx}][notes]" placeholder="{{ __("messages.notes") ?: "ملاحظات" }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <button type="button" onclick="this.closest(\'.parasite-row\').remove()" class="text-red-600 hover:text-red-800 text-sm">{{ __("messages.remove") ?: "حذف" }}</button>
    </div>`;
    document.getElementById('parasiteContainer').insertAdjacentHTML('beforeend', html);
    paraIdx++;
}

let vacIdx = document.querySelectorAll('.vaccination-row').length;
function addVaccination() {
    const html = `<div class="grid grid-cols-1 md:grid-cols-5 gap-2 mb-2 vaccination-row border border-gray-200 rounded-lg p-3">
        <input type="text" name="vaccinations[${vacIdx}][vaccine_name]" placeholder="{{ __("messages.vaccine_name") ?: "اسم اللقاح" }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <input type="date" name="vaccinations[${vacIdx}][vaccination_date]" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <input type="date" name="vaccinations[${vacIdx}][next_due_date]" placeholder="{{ __("messages.next_due") ?: "الجرعة القادمة" }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <input type="text" name="vaccinations[${vacIdx}][notes]" placeholder="{{ __("messages.notes") ?: "ملاحظات" }}" class="border-gray-300 rounded-lg shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm">
        <button type="button" onclick="this.closest(\'.vaccination-row\').remove()" class="text-red-600 hover:text-red-800 text-sm">{{ __("messages.remove") ?: "حذف" }}</button>
    </div>`;
    document.getElementById('vaccinationsContainer').insertAdjacentHTML('beforeend', html);
    vacIdx++;
}
</script>
@endsection
