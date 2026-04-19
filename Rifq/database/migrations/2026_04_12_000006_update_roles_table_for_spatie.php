<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('name')->after('id')->nullable();
            $table->string('guard_name')->default('web')->after('name');
        });

        DB::statement("UPDATE roles SET name = LOWER(REPLACE(role_name, '_', ' '))");
        DB::statement("UPDATE roles SET name = 'admin' WHERE role_name = 'Admin'");
        DB::statement("UPDATE roles SET name = 'vet' WHERE role_name = 'Vet'");
        DB::statement("UPDATE roles SET name = 'citizen' WHERE role_name = 'Citizen'");
        DB::statement("UPDATE roles SET name = 'organization_rep' WHERE role_name = 'Organization_Rep'");
        DB::statement("UPDATE roles SET guard_name = 'web'");
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['name', 'guard_name']);
        });
    }
};
