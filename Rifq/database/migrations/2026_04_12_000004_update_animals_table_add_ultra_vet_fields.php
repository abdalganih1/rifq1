<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->string('uuid')->unique()->nullable()->after('id');
            $table->string('serial_number')->unique()->nullable()->after('uuid');
            $table->boolean('data_entered_status')->default(false)->after('serial_number');
            $table->string('animal_type')->nullable()->after('data_entered_status');
            $table->string('animal_type_en')->nullable()->after('animal_type');
            $table->string('custom_animal_type')->nullable()->after('animal_type_en');
            $table->string('breed_name')->nullable()->after('custom_animal_type');
            $table->string('breed_name_en')->nullable()->after('breed_name');
            $table->string('color')->nullable()->after('breed_name_en');
            $table->string('color_en')->nullable()->after('color');
            $table->text('distinguishing_marks')->nullable()->after('color_en');
            $table->text('distinguishing_marks_en')->nullable()->after('distinguishing_marks');
            $table->string('city_province')->nullable()->after('distinguishing_marks_en');
            $table->string('city_province_en')->nullable()->after('city_province');
            $table->string('relocation_place')->nullable()->after('city_province_en');
            $table->string('relocation_place_en')->nullable()->after('relocation_place');
            $table->string('image_path')->nullable()->after('relocation_place_en');
            $table->json('medical_procedures')->nullable()->after('image_path');
            $table->json('parasite_treatments')->nullable()->after('medical_procedures');
            $table->json('vaccinations_details')->nullable()->after('parasite_treatments');
            $table->json('medical_supervisor_info')->nullable()->after('vaccinations_details');
            $table->string('emergency_contact_phone')->nullable()->after('medical_supervisor_info');
            $table->foreignId('independent_team_id')->nullable()->after('emergency_contact_phone')->constrained('independent_teams')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->after('independent_team_id')->constrained('users')->nullOnDelete();
            $table->foreignId('last_updated_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropForeign(['independent_team_id']);
            $table->dropForeign(['created_by']);
            $table->dropForeign(['last_updated_by']);
            $table->dropColumn([
                'uuid', 'serial_number', 'data_entered_status',
                'animal_type', 'animal_type_en', 'custom_animal_type',
                'breed_name', 'breed_name_en', 'color', 'color_en',
                'distinguishing_marks', 'distinguishing_marks_en',
                'city_province', 'city_province_en',
                'relocation_place', 'relocation_place_en',
                'image_path', 'medical_procedures', 'parasite_treatments',
                'vaccinations_details', 'medical_supervisor_info',
                'emergency_contact_phone', 'independent_team_id',
                'created_by', 'last_updated_by',
            ]);
        });
    }
};
