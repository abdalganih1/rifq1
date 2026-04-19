<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code_hash')->unique();
            $table->string('name')->nullable();
            $table->string('species');
            $table->string('breed');
            $table->enum('gender', ['Male', 'Female']);
            $table->integer('estimated_age');
            $table->enum('status', ['Stray', 'In_Shelter', 'Adopted', 'Available', 'Deceased']);
            $table->text('location_found')->nullable();
            $table->foreignId('organization_id')->nullable()->constrained('organizations')->onDelete('set null');
            $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
