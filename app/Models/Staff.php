<?php




namespace App\Models;




use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Staff extends Model
{
    use HasFactory;




    protected $table = 'staffs';




    protected $fillable = [
        'school_id',
        'user_id',
       
        // Personal Information
        'first_name_nepali', 'middle_name_nepali', 'last_name_nepali',
        'first_name_english', 'middle_name_english', 'last_name_english',
        'mobile_number', 'date_of_birth', 'gender', 'caste', 'ethnicity',
        'edj', 'disability_status', 'citizenship_id', 'national_id',
        'photo', 'citizenship_front', 'citizenship_back',
        'spouse_name', 'spouse_occupation',
       
        // Permanent Address
        'permanent_province', 'permanent_district', 'permanent_local_level',
        'permanent_ward_no', 'permanent_tole', 'permanent_house_no',
       
        // Temporary Address
        'temporary_province', 'temporary_district', 'temporary_local_level',
        'temporary_ward_no', 'temporary_tole', 'temporary_house_no',
       
        // Academic Information as separate arrays
        'level_of_study', 'board_university_college', 'registration',
        'institution_name', 'academic_documents',
       
        // Job Information
        'role', 'level', 'job_type', 'category', 'appointment_date',
        'resume', 'other_documents',
    ];




    protected $casts = [
        'date_of_birth' => 'date',
        'appointment_date' => 'date',
        'edj' => 'boolean',
        'level_of_study' => 'array',
        'board_university_college' => 'array',
        'registration' => 'array',
        'institution_name' => 'array',
        'academic_documents' => 'array',
        'other_documents' => 'array',
    ];




    public function school()
    {
        return $this->belongsTo(School::class);
    }




    public function user()
    {
        return $this->belongsTo(User::class);
    }
}









