<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'first_name_np',
        'middle_name_np',
        'last_name_np',
        'first_name_en',
        'middle_name_en',
        'last_name_en',
        'mobile_number',
        'date_of_birth',
        'gender',
        'caste',
        'ethnicity',
        'edj',
        'disability_status',
        'citizenship_id',
        'national_id',
        'student_photo',
        'citizenship_front',
        'citizenship_back',
        'permanent_district',
        'permanent_province',
        'permanent_local_level',
        'permanent_ward_no',
        'permanent_tole',
        'permanent_house_no',
        'temporary_district',
        'temporary_province',
        'temporary_local_level',
        'temporary_ward_no',
        'temporary_tole',
        'temporary_house_no',
        'father_name',
        'father_contact_no',
        'father_occupation',
        'mother_name',
        'mother_contact_no',
        'mother_occupation',
        'level_of_study',
        'faculty',
        'program',
        'admission_year',
        'date_of_admission',
        'academic_program_duration',
        'previous_level_of_study',
        'previous_board_university_college',
        'previous_registration_no',
        'previous_institution_name',
        'previous_study_records_attachment',
        'school_id',
        'class_id',
        'section_id',
        'program_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function schoolHouse()
    {
        return $this->belongsTo(SchoolHouse::class, 'school_house_id');
    }

    public function classes()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }

    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function studentLeaves()
    {
        return $this->hasMany(StudentLeave::class, 'student_id');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'student_id');
    }

    public function session()
    {
        return $this->belongsTo(StudentSession::class);
    }

    public function feeCollections()
    {
        return $this->hasMany(FeeCollection::class);
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function studentSessions()
    {
        return $this->hasMany(StudentSession::class, 'user_id');
    }
    public function studentSession()
    {
        return $this->belongsTo(StudentSession::class, 'student_session_id');
    }
    public function feeGroups()
{
    return $this->belongsToMany(FeeGroup::class, 'fee_group_student', 'student_session_id', 'fee_group_id');
}

    public function class()
    {
        return $this->belongsTo(Classg::class, 'class_id');
    }

    public function section()
{
    return $this->belongsTo(Section::class, 'section_id');
}
}
