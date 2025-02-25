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
        Schema::create('id_card_designs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('set null');
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('set null');
            $table->string('college_name');
            $table->string('sign');
            $table->string('background_img');
            $table->string('content_footer');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('id_card_designs');
    }
};
