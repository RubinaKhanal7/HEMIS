<?php


namespace App\Imports;


use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;


class StaffsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new \Exception('The uploaded file is empty or could not be read correctly.');
        }
       
        foreach ($rows as $index => $row) {
            // Convert row to array and ensure all values are strings
            $rowArray = [];
            foreach ($row->toArray() as $key => $value) {
                // Convert all values to strings, including numbers and dates
                $rowArray[$key] = $value !== null ? (string)$value : null;
            }
           
            // Validate each row individually
            $validator = Validator::make($rowArray, [
                'first_name_nepali' => 'required|string',
                'last_name_nepali' => 'required|string',
                'first_name_english' => 'required|string',
                'last_name_english' => 'required|string',
                'mobile_number' => 'required|string',
                'date_of_birth' => 'required|string',
                'gender' => ['required', Rule::in(['male', 'female', 'other'])],
                'ethnicity' => ['required', Rule::in(['Dalit', 'Janajati', 'Madhesi', 'Muslim', 'Tharu', 'Brahmin', 'Chhetri'])],
                'citizenship_id' => 'required|string|unique:staffs,citizenship_id',
                'permanent_province' => 'required|string',
                'permanent_district' => 'required|string',
                'permanent_local_level' => 'required|string',
                'permanent_ward_no' => 'required|string',
                'role' => 'required|string',
                'level' => 'required|string',
                'job_type' => ['required', Rule::in(['Temporary', 'Permanent', 'Contract', 'Daily Basis'])],
                'category' => ['required', Rule::in(['Technical', 'Non-Technical'])],
                'appointment_date' => 'required|string',
                'email' => 'nullable|email|unique:users,email',
                // Optional fields validation
                'middle_name_nepali' => 'nullable|string',
                'middle_name_english' => 'nullable|string',
                'caste' => 'nullable|string',
                'edj' => 'nullable|in:0,1,true,false',
                'disability_status' => 'nullable|in:0,1,true,false',
                'national_id' => 'nullable|string|unique:staffs,national_id',
                'spouse_name' => 'nullable|string',
                'spouse_occupation' => 'nullable|string',
                'permanent_tole' => 'nullable|string',
                'permanent_house_no' => 'nullable|string',
                'temporary_province' => 'nullable|string',
                'temporary_district' => 'nullable|string',
                'temporary_local_level' => 'nullable|string',
                'temporary_ward_no' => 'nullable|string',
                'temporary_tole' => 'nullable|string',
                'temporary_house_no' => 'nullable|string',
                'level_of_study' => 'nullable|string',
                'board_university_college' => 'nullable|string',
                'registration' => 'nullable|string',
                'institution_name' => 'nullable|string',
            ]);


            // If validation fails, throw an exception with specific row information
            if ($validator->fails()) {
                $rowNum = $index + 2; // +2 because index starts at 0 and we have a header row
                $errors = $validator->errors()->all();
                $errorMsg = "Error in row $rowNum: " . implode(', ', $errors);
                throw new \Exception($errorMsg);
            }


   


            // Create the staff record
            Staff::create([
                'school_id' => session('school_id'),
               
                // Personal Information
                'first_name_nepali' => $rowArray['first_name_nepali'],
                'middle_name_nepali' => $rowArray['middle_name_nepali'] ?? null,
                'last_name_nepali' => $rowArray['last_name_nepali'],
                'first_name_english' => $rowArray['first_name_english'],
                'middle_name_english' => $rowArray['middle_name_english'] ?? null,
                'last_name_english' => $rowArray['last_name_english'],
                'mobile_number' => $rowArray['mobile_number'],
                'date_of_birth' => $rowArray['date_of_birth'],
                'gender' => strtolower($rowArray['gender']),
                'caste' => $rowArray['caste'] ?? null,
                'ethnicity' => $rowArray['ethnicity'],
                'edj' => isset($rowArray['edj']) ? (string)$rowArray['edj'] === '1' || strtolower((string)$rowArray['edj']) === 'true' : false,
                'disability_status' => isset($rowArray['disability_status']) ? (string)$rowArray['disability_status'] === '1' || strtolower((string)$rowArray['disability_status']) === 'true' : false,
                'citizenship_id' => $rowArray['citizenship_id'],
                'national_id' => $rowArray['national_id'] ?? null,
                'spouse_name' => $rowArray['spouse_name'] ?? null,
                'spouse_occupation' => $rowArray['spouse_occupation'] ?? null,
               
                // Permanent Address
                'permanent_province' => $rowArray['permanent_province'],
                'permanent_district' => $rowArray['permanent_district'],
                'permanent_local_level' => $rowArray['permanent_local_level'],
                'permanent_ward_no' => $rowArray['permanent_ward_no'],
                'permanent_tole' => $rowArray['permanent_tole'] ?? null,
                'permanent_house_no' => $rowArray['permanent_house_no'] ?? null,
               
                // Temporary Address
                'temporary_province' => $rowArray['temporary_province'] ?? null,
                'temporary_district' => $rowArray['temporary_district'] ?? null,
                'temporary_local_level' => $rowArray['temporary_local_level'] ?? null,
                'temporary_ward_no' => $rowArray['temporary_ward_no'] ?? null,
                'temporary_tole' => $rowArray['temporary_tole'] ?? null,
                'temporary_house_no' => $rowArray['temporary_house_no'] ?? null,
               
                // Job information
                'role' => $rowArray['role'],
                'level' => $rowArray['level'],
                'job_type' => $rowArray['job_type'],
                'category' => $rowArray['category'],
                'appointment_date' => $rowArray['appointment_date'],
               
                // Handle JSON fields (converting arrays to JSON)
                'level_of_study' => isset($rowArray['level_of_study']) ? json_encode(explode(',', $rowArray['level_of_study'])) : null,
                'board_university_college' => isset($rowArray['board_university_college']) ? json_encode(explode(',', $rowArray['board_university_college'])) : null,
                'registration' => isset($rowArray['registration']) ? json_encode(explode(',', $rowArray['registration'])) : null,
                'institution_name' => isset($rowArray['institution_name']) ? json_encode(explode(',', $rowArray['institution_name'])) : null,
            ]);
        }
    }


    /**
     * Generate an email if not provided
     */
    private function generateEmail($firstName, $lastName)
    {
        $baseName = strtolower($firstName . '.' . $lastName);
        $email = $baseName . '@example.com';
       
        $count = 1;
        while (User::where('email', $email)->exists()) {
            $email = $baseName . $count . '@example.com';
            $count++;
        }
       
        return $email;
    }
}

