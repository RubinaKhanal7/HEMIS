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
        Schema::create('students', function (Blueprint $table) {
            $table->id();


            // Personal Information
            $table->string('first_name_np');
            $table->string('middle_name_np')->nullable();
            $table->string('last_name_np');
            $table->string('first_name_en');
            $table->string('middle_name_en')->nullable();
            $table->string('last_name_en');
            $table->string('mobile_number');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('caste')->nullable();
            $table->string('ethnicity');
            $table->string('edj')->nullable();
            $table->string('disability_status')->nullable();
            $table->string('citizenship_id')->nullable();
            $table->string('national_id')->nullable();
            $table->string('student_photo')->nullable();
            $table->string('citizenship_front')->nullable();
            $table->string('citizenship_back')->nullable();


            // Address Information
            $table->string('permanent_district');
            $table->string('permanent_province');
            $table->string('permanent_local_level');
            $table->string('permanent_ward_no');
            $table->string('permanent_tole')->nullable();
            $table->string('permanent_house_no')->nullable();
           
            $table->string('temporary_district')->nullable();
            $table->string('temporary_province')->nullable();
            $table->string('temporary_local_level')->nullable();
            $table->string('temporary_ward_no')->nullable();
            $table->string('temporary_tole')->nullable();
            $table->string('temporary_house_no')->nullable();


            // Guardian Information
            $table->string('father_name')->nullable();
            $table->string('father_contact_no')->nullable();
            $table->string('father_occupation')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_contact_no')->nullable();
            $table->string('mother_occupation')->nullable();


            // Student Enrollment Academic Information
            $table->string('level_of_study');
            $table->string('faculty');
            $table->string('program');
            $table->year('admission_year');
            $table->date('date_of_admission');
            $table->string('academic_program_duration');


            // Previous Academic Information
            $table->string('previous_level_of_study');
            $table->string('previous_board_university_college');
            $table->string('previous_registration_no');
            $table->string('previous_institution_name');
            $table->string('previous_study_records_attachment')->nullable();
           
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

