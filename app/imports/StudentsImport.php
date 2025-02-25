<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Validators\Failure;
use Carbon\Carbon;

class StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts
{
    use SkipsFailures;

    protected $class_id;
    protected $section_id;
    protected $program_id;
    protected $rows = 0;

    public function __construct($class_id, $section_id, $program_id)
    {
        $this->class_id = $class_id;
        $this->section_id = $section_id;
        $this->program_id = $program_id;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $this->rows++;
        
        // Handle empty rows
        if (empty(array_filter($row))) {
            return null;
        }

        try {
            // Convert numeric fields to strings explicitly
            $row = $this->forceStringConversion($row);
            
            // Parse dates flexibly to handle different formats
            $dateOfBirth = $this->parseDate($row['date_of_birth'] ?? null);
            $dateOfAdmission = $this->parseDate($row['date_of_admission'] ?? null);
            
            return new Student([
                // Personal Information
                'first_name_np' => $row['first_name_np'] ?? null,
                'middle_name_np' => $row['middle_name_np'] ?? null,
                'last_name_np' => $row['last_name_np'] ?? null,
                'first_name_en' => $row['first_name_en'] ?? null,
                'middle_name_en' => $row['middle_name_en'] ?? null,
                'last_name_en' => $row['last_name_en'] ?? null,
                'mobile_number' => $row['mobile_number'] ?? null,
                'date_of_birth' => $dateOfBirth,
                'gender' => $row['gender'] ?? null,
                'caste' => $row['caste'] ?? null,
                'ethnicity' => $row['ethnicity'] ?? null,
                'edj' => $row['edj'] ?? null,
                'disability_status' => $row['disability_status'] ?? null,
                
                // Address Information
                'permanent_district' => $row['permanent_district'] ?? null,
                'permanent_province' => $row['permanent_province'] ?? null,
                'permanent_local_level' => $row['permanent_local_level'] ?? null,
                'permanent_ward_no' => $row['permanent_ward_no'] ?? null,
                'permanent_tole' => $row['permanent_tole'] ?? null,
                'permanent_house_no' => $row['permanent_house_no'] ?? null,
                
                'temporary_district' => $row['temporary_district'] ?? null,
                'temporary_province' => $row['temporary_province'] ?? null,
                'temporary_local_level' => $row['temporary_local_level'] ?? null,
                'temporary_ward_no' => $row['temporary_ward_no'] ?? null,
                'temporary_tole' => $row['temporary_tole'] ?? null,
                'temporary_house_no' => $row['temporary_house_no'] ?? null,
                
                // Guardian Information
                'father_name' => $row['father_name'] ?? null,
                'father_contact_no' => $row['father_contact_no'] ?? null,
                'father_occupation' => $row['father_occupation'] ?? null,
                'mother_name' => $row['mother_name'] ?? null,
                'mother_contact_no' => $row['mother_contact_no'] ?? null,
                'mother_occupation' => $row['mother_occupation'] ?? null,
                
                // Student Enrollment Academic Information
                'admission_year' => $row['admission_year'] ?? null,
                'date_of_admission' => $dateOfAdmission,
                'academic_program_duration' => $row['academic_program_duration'] ?? null,
                
                // Previous Academic Information
                'previous_level_of_study' => $row['previous_level_of_study'] ?? null,
                'previous_board_university_college' => $row['previous_board_university_college'] ?? null,
                'previous_registration_no' => $row['previous_registration_no'] ?? null,
                'previous_institution_name' => $row['previous_institution_name'] ?? null,
                
                // System Information
                'school_id' => session('school_id'),
                'class_id' => $this->class_id,
                'section_id' => $this->section_id,
                'program_id' => $this->program_id,
            ]);
        } catch (\Exception $e) {
            $this->failures[] = new Failure(
                $this->rows,
                'Error',
                [$e->getMessage()],
                $row
            );
            return null;
        }
    }

    /**
     * Force conversion of numeric-looking values to strings
     */
    private function forceStringConversion(array $row)
    {
        // List of fields that must be strings
        $stringFields = [
            'mobile_number', 
            'permanent_ward_no', 
            'temporary_ward_no',
            'academic_program_duration', 
            'previous_level_of_study', 
            'previous_registration_no',
            'father_contact_no',
            'mother_contact_no',
            'permanent_house_no',
            'temporary_house_no'
        ];
        
        foreach ($stringFields as $field) {
            if (isset($row[$field])) {
                // Always convert to string, even if already a string
                $row[$field] = (string) $row[$field];
            }
        }
        
        return $row;
    }

    /**
     * Parse date flexibly to handle different formats
     */
    private function parseDate($date)
    {
        if (!$date) return null;
        
        try {
            // Try to parse date in various formats
            return Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            // If parsing fails, return null
            return null;
        }
    }

    /**
     * Prepare data before validation to ensure string conversions
     */
    public function prepareForValidation($data, $index)
    {
        // Apply string conversion before validation
        return $this->forceStringConversion($data);
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'first_name_np' => ['required', 'string'],
            'last_name_np' => ['required', 'string'],
            'first_name_en' => ['required', 'string'],
            'last_name_en' => ['required', 'string'],
            'mobile_number' => ['required', 'string', 'regex:/^[0-9]{10}$/'],
            'date_of_birth' => ['required'],
            'gender' => ['required', 'in:Male,Female,Other'],
            'ethnicity' => ['required', 'string'],
            'permanent_district' => ['required', 'string'],
            'permanent_province' => ['required', 'string'],
            'permanent_local_level' => ['required', 'string'],
            'permanent_ward_no' => ['required', 'string'],
            'admission_year' => ['required'],
            'date_of_admission' => ['required'],
            'academic_program_duration' => ['required', 'string'],
            'previous_level_of_study' => ['required', 'string'],
            'previous_board_university_college' => ['required', 'string'],
            'previous_registration_no' => ['required', 'string'],
            'previous_institution_name' => ['required', 'string'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages()
    {
        return [
            'mobile_number.regex' => 'The mobile number must be exactly 10 digits.',
            'gender.in' => 'Gender must be either Male, Female, or Other.',
        ];
    }

    /**
     * Batch size for inserts
     */
    public function batchSize(): int
    {
        return 100;
    }
}