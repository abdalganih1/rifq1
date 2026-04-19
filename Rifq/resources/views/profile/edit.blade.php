<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ __('messages.profile') ?: 'الملف الشخصي' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @auth
                @if(!auth()->user()->isDataEntry() && !auth()->user()->isAdmin())
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                                طلب الانضمام لفريق
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                يمكنك طلب الانضمام لفريق مستقل للحصول على صلاحية إدخال بيانات الحيوانات.
                            </p>
                            <form method="POST" action="{{ route('profile.request-team-upgrade') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="independent_team_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اختر الفريق</label>
                                    <select name="independent_team_id" id="independent_team_id" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500" required>
                                        <option value="">-- اختر فريق --</option>
                                        @foreach(\App\Models\IndependentTeam::with('governorate')->get() as $team)
                                            <option value="{{ $team->id }}">{{ $team->name }} ({{ $team->governorate?->name }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">السبب (اختياري)</label>
                                    <textarea name="reason" id="reason" rows="3" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                                </div>
                                <x-primary-button>
                                    طلب الانضمام
                                </x-primary-button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
