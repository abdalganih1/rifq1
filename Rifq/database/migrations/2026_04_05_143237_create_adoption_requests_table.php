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
        Schema::create('adoption_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('animal_id')->constrained('animals')->onDelete('cascade');
            $table->foreignId('adopter_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->text('request_message');
            $table->text('rejection_reason')->nullable();
            $table->datetime('request_date');
            $table->datetime('decision_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adoption_requests');
    }
};
