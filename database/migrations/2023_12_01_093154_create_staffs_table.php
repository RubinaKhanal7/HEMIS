<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
           
            // Personal Information
            $table->string('first_name_nepali');
            $table->string('middle_name_nepali')->nullable();
            $table->string('last_name_nepali');
            $table->string('first_name_english');
            $table->string('middle_name_english')->nullable();
            $table->string('last_name_english');
            $table->string('mobile_number');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('caste')->nullable();
            $table->enum('ethnicity', ['Dalit', 'Janajati', 'Madhesi', 'Muslim', 'Tharu', 'Brahmin', 'Chhetri']);
            $table->boolean('edj')->default(false)->nullable();
            $table->boolean('disability_status')->default(false)->nullable();
            $table->string('citizenship_id')->unique();
            $table->string('national_id')->nullable()->unique();
            $table->string('photo')->nullable();
            $table->string('citizenship_front')->nullable();
            $table->string('citizenship_back')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_occupation')->nullable();


            // Permanent Address
            $table->string('permanent_province');
            $table->string('permanent_district');
            $table->string('permanent_local_level');
            $table->string('permanent_ward_no');
            $table->string('permanent_tole')->nullable();
            $table->string('permanent_house_no')->nullable();
           
            // Temporary Address
            $table->string('temporary_province')->nullable();
            $table->string('temporary_district')->nullable();
            $table->string('temporary_local_level')->nullable();
            $table->string('temporary_ward_no')->nullable();
            $table->string('temporary_tole')->nullable();
            $table->string('temporary_house_no')->nullable();
           
            // Academic Information
            $table->json('level_of_study')->nullable();
            $table->json('board_university_college')->nullable();
            $table->json('registration')->nullable();
            $table->json('institution_name')->nullable();
            $table->json('academic_documents')->nullable();
           
            // Job information
            $table->string('role');
            $table->string('level');
            $table->enum('job_type', ['Temporary', 'Permanent', 'Contract', 'Daily Basis']);
            $table->enum('category', ['Technical', 'Non-Technical']);
            $table->date('appointment_date');
            $table->string('resume')->nullable();
            $table->json('other_documents')->nullable();


            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
           
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};

