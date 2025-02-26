<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    protected $casts = [
        'previous_study_records_attachment' => 'array',
    ];

    protected $fillable = [
        // Personal Information
        'first_name_np', 'middle_name_np', 'last_name_np',
        'first_name_en', 'middle_name_en', 'last_name_en',
        'mobile_number', 'date_of_birth', 'gender',
        'caste', 'ethnicity', 'edj', 'disability_status',
        'citizenship_id', 'national_id', 'student_photo',
        'citizenship_front', 'citizenship_back',

        // Address Information
        'permanent_district', 'permanent_province', 'permanent_local_level',
        'permanent_ward_no', 'permanent_tole', 'permanent_house_no',
        'temporary_district', 'temporary_province', 'temporary_local_level',
        'temporary_ward_no', 'temporary_tole', 'temporary_house_no',

        // Guardian Information
        'father_name', 'father_contact_no', 'father_occupation',
        'mother_name', 'mother_contact_no', 'mother_occupation',

        // Academic Information
        'admission_year', 'date_of_admission', 'academic_program_duration',
        'class_id', 'section_id', 'program_id', 'school_id', 'user_id',

        // Previous Academic Information
        'previous_level_of_study', 'previous_board_university_college',
        'previous_registration_no', 'previous_institution_name',
        'previous_study_records_attachment'
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function idCard()
{
    return $this->hasOne(IdCardDesign::class);
}
}