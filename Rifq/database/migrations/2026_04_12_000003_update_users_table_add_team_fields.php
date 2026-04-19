<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('email');
            $table->foreignId('governorate_id')->nullable()->after('organization_id')->constrained('governorates')->nullOnDelete();
            $table->foreignId('independent_team_id')->nullable()->after('governorate_id')->constrained('independent_teams')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['governorate_id']);
            $table->dropForeign(['independent_team_id']);
            $table->dropColumn(['username', 'governorate_id', 'independent_team_id']);
        });
    }
};
