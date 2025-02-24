<?php

namespace App\Http\Controllers\SchoolAdmin;

// use Validator;
use Image, View;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Classg;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\School;
use App\Models\SchoolUser;
use App\Models\SchoolHouse;
use Illuminate\Http\Request;
use App\Models\BloodGroupType;
use App\Models\StudentSession;
use App\imports\CombinedImport;
use App\Models\AcademicSession;
use App\Models\StudentAttendance;
use Yajra\Datatables\Datatables;
use App\Http\Services\FormService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Services\StudentUserService;
use App\Models\Municipality;
use App\Models\District;
use App\Models\State;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Exports\StudentsExport;


class StudentController extends Controller
{
    protected $formService;
    protected $studentUserService;

    protected $imageSavePath = '/uploads/students/profile_images';

    public function __construct(FormService $formService, StudentUserService $studentUserService)
    {
        $this->formService = $formService;
        $this->studentUserService = $studentUserService;
    }

    public function loadFormData(Request $request) 
{
    $classes = Classg::select('id', 'class')
                     ->where('is_active', 1)
                     ->get();
    return view('backend.school_admin.student.index', compact('classes'));
}


    public function getDistrict($province_id)
    {

        $districts = $this->formService->getDistricts($province_id);
        return response()->json($districts);
    }

    public function index(Request $request)
    {
        $page_title = 'Student List';
        $classes = Classg::where('school_id', session('school_id'))->get();
        
        // Get the search parameters from the URL
        $selectedClass = $request->query('class_id');
        $selectedSection = $request->query('section_id');
        $selectedProgram = $request->query('program_id');
        $shouldSearch = $request->query('search');
        
        return view('backend.school_admin.student.index', compact(
            'page_title', 
            'classes',
            'selectedClass',
            'selectedSection',
            'selectedProgram',
            'shouldSearch'
        ));
    }
    public function getData(Request $request)
    {
        try {
            $query = Student::with(['class', 'section', 'program'])
                ->when(session('school_id'), function($q) {
                    return $q->where('school_id', session('school_id'));
                })
                ->when($request->filled('class_id'), function($q) use ($request) {
                    return $q->where('class_id', $request->class_id);
                })
                ->when($request->filled('section_id'), function($q) use ($request) {
                    return $q->where('section_id', $request->section_id);
                })
                ->when($request->filled('program_id'), function($q) use ($request) {
                    return $q->where('program_id', $request->program_id);
                });
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function($row) {
                    return '<input type="checkbox" class="student-checkbox" data-student-id="'.$row->id.'">';
                })
                ->addColumn('action', function($row) {
                    return view('backend.school_admin.student.partials.controller_action', compact('row'))->render();
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Student DataTable Error: ' . $e->getMessage());
            return response()->json(['error' => 'Error fetching student data'], 500);
        }
    }

public function getProgramsByClass($classId)
{
    $programs = Program::where('class_id', $classId)->pluck('title', 'id');
    return response()->json($programs);
}


// Add these new methods for dependent dropdowns
public function getFaculties($classId)
{
    $sections = Section::where('class_id', $classId)
        ->orderBy('section_name')
        ->get();
    
    return response()->json($sections);
}

public function getPrograms($sectionId)
{
    $programs = Program::where('section_id', $sectionId)
        ->orderBy('title')
        ->get();
    
    return response()->json($programs);
}
    public function create()
    {
        $page_title = 'Create Student';
        $states = $this->formService->getProvinces();
        $schoolId = session('school_id');
        
        $classes = Classg::where('school_id', $schoolId)
        ->orderBy('created_at', 'desc')
        ->get();
        
    
        $school_houses = SchoolHouse::all();
        $bloodGroups = BloodGroupType::pluck('type', 'id');
        
        $adminStateId = Auth::user()->state_id;
        $adminDistrictId = Auth::user()->district_id;
        $adminMunicipalityId = Auth::user()->municipality_id;
        $adminSchoolId = Auth::user()->school_id;

    
        return view(
            'backend.school_admin.student.create',
            compact(
                'page_title',
                'states',
                'classes',
                'school_houses',
                'adminStateId',
                'adminDistrictId',
                'adminMunicipalityId',
                'adminSchoolId',
                'bloodGroups',
            )
        );
    }
    
    

    public function additionalInformationStudents($student_id, Request $request)
    {
        // dd($request);
        $page_title = 'Create Additional Student Information';
        $student = Student::findOrFail($student_id);
        // You can pass $student to your view for use in the form
        return view('backend.school_admin.student.additional_information_create', compact('student', 'page_title'));
    }

    public function updateAdditionalInformation(Request $request, $student_id)
    {
        try {
            // Find the student's associated user
            $user = Student::findOrFail($student_id)->user;

            // Validate the submitted data
            $validatedData = $request->validate([
                'bank_name' => 'required',
                'bank_account_no' => 'nullable',
                'bank_branch' => 'nullable',
                'username' => 'nullable',
                'facebook' => 'nullable',
                'twitter' => 'nullable',
                'linkedin' => 'nullable',
                'instagram' => 'nullable',
            ]);

            // Update the user's additional information
            $user->update($validatedData);

            return redirect()->back()->withToastSuccess('Additional information updated successfully');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }







    // RETRIVING SECTIONS OF THE RESPECTIVE CLASS
//     public function getSections($classId)
//     {

//         $sections = DB::table('sections')
//                     ->where('class_id', $classId)
//                     ->pluck('section_name', 'id');
//         return response()->json($sections);
//     }
//     public function getPrograms($sectionId)
// {

//     $programs = DB::table('programs')
//                 ->where('section_id', $sectionId)
//                 ->pluck('title', 'id');
//     return response()->json($programs);
// }

// public function getClasses()
// {
//     $schoolId = session('school_id');
//     $classes = Classg::where('school_id', $schoolId)
//         ->orderBy('created_at', 'desc')
//         ->pluck('class', 'id'); 
    
//     return response()->json($classes);
// }

    // CREATE STUDENT
    protected function saveStudent(array $studentInput)
    {
        try {
            $newStudent = Student::create($studentInput);
        } catch (\Exception $e) {
            // Handle any specific exception related to student creation
            throw $e;
        }
    }

    // SAVING IMAGE FOR USER
    protected function saveUserImage($croppedImage)
    {
        if (!File::exists($this->imageSavePath)) {
            File::makeDirectory($this->imageSavePath, 0775, true, true);
        }

        $destinationPath = $this->imageSavePath . $this->getDateFormatFileName('jpg');
        Image::make($croppedImage)
            ->encode('jpg')
            ->save(public_path($destinationPath));

        return $destinationPath;
    }

    protected function createUser(array $userData)
    {
        $userData['user_type_id'] = 8;  //students
        $userData['role_id'] = 11;  // student
        $userData['school_id'] = session('school_id');

        return User::create($userData);
    }


    protected function saveTransferCertificate(Request $request)
    {
        if ($request->hasFile('transfer_certificate')) {
            $postPath = time() . '.' . $request->file('transfer_certificate')->getClientOriginalExtension();
            $destinationPath = public_path('uploads/students/certificates');
            $request->file('transfer_certificate')->move($destinationPath, $postPath);;

            return $destinationPath . '/' . $postPath;
        }

        return null; // Return null only if no file is present
    }

    // SAVING ENTRY FOR SCHOOL_USER PIVOT TABLE
    protected function createSchoolUserEntry($schoolId, $userId)
    {
        try {
            SchoolUser::create([
                'school_id' => $schoolId,
                'user_id' => $userId,
            ]);
        } catch (\Exception $e) {
            // Handle any specific exception related to SchoolUser creation
            throw $e;
        }
    }

    // VALIDATION FOR USERS
    protected function validateUserData(Request $request, $isStudent = false)
    {
        $rules = [
            'state_id' => 'required',
            'district_id' => 'required',
            'municipality_id' => 'required',
            'ward_id' => 'required',
            'local_address' => 'nullable',
            'permanent_address' => 'nullable',
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'nullable|email|unique:users,email',
            'religion' => 'nullable',
            'mobile_number' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'blood_group' => 'nullable',
            // 'image' => 'required',
            'father_name' => 'nullable',
            'father_phone' => 'nullable',
            'father_occupation' => 'nullable',
            'mother_name' => 'nullable',
            'mother_phone' => 'nullable',
            'mother_occupation' => 'nullable',
            'emergency_contact_person' => 'nullable',
            'emergency_contact_phone' => 'nullable',
            'username' => 'nullable',
            // 'password' => 'required',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'linkedin' => 'nullable',
            'instagram' => 'nullable',
            'bank_name' => 'nullable',
            'bank_account_no' => 'nullable',
            'bank_branch' => 'nullable',
            'note' => 'nullable',
            'is_active' => 'boolean',
            'guardian_is' => 'nullable',
        ];

        // Add conditional validation for guardian-related fields in student data
        if ($isStudent && $request->input('guardian_is') == 'other') {
            $rules += [
                'guardian_name' => 'nullable',
                'guardian_relation' => 'nullable',
                'guardian_phone' => 'nullable',
            ];
        }

        return $request->validate($rules);
    }


    // CREATING STUDENT SESSION
    private function createStudentSession($userId, $classId, $sectionId)
    {
        $latestAcademicSession = AcademicSession::latest()->first();
        if ($latestAcademicSession) {
            StudentSession::create([
                'user_id' => $userId,
                'academic_session_id' => $latestAcademicSession->id,
                'school_id' => session('school_id'),
                'class_id' => $classId,
                'section_id' => $sectionId,
                'is_active' => true,
            ]);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            // Personal Information
            'first_name_np' => 'required|string',
            'last_name_np' => 'required|string',
            'first_name_en' => 'required|string',
            'last_name_en' => 'required|string',
            'mobile_number' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'ethnicity' => 'required|string',
            'student_photo' => 'nullable|image|mimes:jpeg,png,jpg',
            'citizenship_front' => 'nullable|image|mimes:jpeg,png,jpg',
            'citizenship_back' => 'nullable|image|mimes:jpeg,png,jpg',
    
            // Address Information
            'permanent_province' => 'required|string',
            'permanent_district' => 'required|string',
            'permanent_local_level' => 'required|string',
            'permanent_ward_no' => 'required|string',
    
            // Academic Information
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'program_id' => 'required|exists:programs,id',
            'admission_year' => 'required|digits:4',
            'date_of_admission' => 'required|date',
            'academic_program_duration' => 'required|string',
    
            // Previous Academic Information
            'previous_level_of_study' => 'required|string',
            'previous_board_university_college' => 'required|string',
            'previous_registration_no' => 'required|string',
            'previous_institution_name' => 'required|string',
            'previous_study_records_attachment' => 'nullable|file',
        ]);
    
        // Handle file uploads
        if ($request->hasFile('student_photo')) {
            $photoPath = $request->file('student_photo')->store('student_photos', 'public');
        }
    
        if ($request->hasFile('citizenship_front')) {
            $citizenshipFrontPath = $request->file('citizenship_front')->store('citizenship', 'public');
        }
    
        if ($request->hasFile('citizenship_back')) {
            $citizenshipBackPath = $request->file('citizenship_back')->store('citizenship', 'public');
        }
    
        if ($request->hasFile('previous_study_records_attachment')) {
            $recordsPath = $request->file('previous_study_records_attachment')->store('previous_records', 'public');
        }
    
        $student = Student::create([
            // Personal Information
            'first_name_np' => $request->first_name_np,
            'middle_name_np' => $request->middle_name_np,
            'last_name_np' => $request->last_name_np,
            'first_name_en' => $request->first_name_en,
            'middle_name_en' => $request->middle_name_en,
            'last_name_en' => $request->last_name_en,
            'mobile_number' => $request->mobile_number,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'caste' => $request->caste,
            'ethnicity' => $request->ethnicity,
            'edj' => $request->edj,
            'disability_status' => $request->disability_status,
            'citizenship_id' => $request->citizenship_id,
            'national_id' => $request->national_id,
            'student_photo' => $photoPath ?? null,
            'citizenship_front' => $citizenshipFrontPath ?? null,
            'citizenship_back' => $citizenshipBackPath ?? null,
    
            // Address Information
            'permanent_province' => $request->permanent_province,
            'permanent_district' => $request->permanent_district,
            'permanent_local_level' => $request->permanent_local_level,
            'permanent_ward_no' => $request->permanent_ward_no,
            'permanent_tole' => $request->tole,
            'permanent_house_no' => $request->house_number,
            
            'temporary_province' => $request->temp_state_id,
            'temporary_district' => $request->temp_district_id,
            'temporary_local_level' => $request->temp_municipality_id,
            'temporary_ward_no' => $request->temp_ward_id,
            'temporary_tole' => $request->temp_tole,
            'temporary_house_no' => $request->temp_house_number,
    
            // Guardian Information
            'father_name' => $request->father_name,
            'father_contact_no' => $request->father_contact_no,
            'father_occupation' => $request->father_occupation,
            'mother_name' => $request->mother_name,
            'mother_contact_no' => $request->mother_contact_no,
            'mother_occupation' => $request->mother_occupation,
    
            // Academic Information
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'program_id' => $request->program_id,
            'admission_year' => $request->admission_year,
            'date_of_admission' => $request->date_of_admission,
            'academic_program_duration' => $request->academic_program_duration,
    
            // Previous Academic Information
            'previous_level_of_study' => $request->previous_level_of_study,
            'previous_board_university_college' => $request->previous_board_university_college,
            'previous_registration_no' => $request->previous_registration_no,
            'previous_institution_name' => $request->previous_institution_name,
            'previous_study_records_attachment' => $recordsPath ?? null,
    
            // Additional fields
            'school_id' => auth()->user()->school_id,
            'user_id' => auth()->id(),
        ]);
    
        return redirect()->route('admin.students.index')
            ->with('success', 'Student registered successfully');
    }  

    public function show(Request $request)
    {
    }

    public function edit(Student $student)
    {
        // Load necessary relationships and data for dropdowns
        $page_title = 'Edit Student Data';
        $schools = School::all();
        $sections = Section::all();
        $classes = Classg::all();
        $programs = Program::all();
        $municipalities = Municipality::all();
        $districts = District::all();
        $states = State::all();
        $wards = User::getWards($student->municipality_id);
        $adminStateId = Auth::user()->state_id;
        $adminDistrictId = Auth::user()->district_id;
        $adminMunicipalityId = Auth::user()->municipality_id;
        $adminSchoolId = Auth::user()->school_id;
        
        return view('backend.school_admin.student.update', compact('page_title','student', 'schools', 'sections', 'classes', 'programs',
    'adminStateId','adminDistrictId','adminMunicipalityId','adminSchoolId','municipalities','districts','states','wards'
    ));
    }

    public function update(Request $request, Student $student)
    {
        // Validate the request
        $validated = $request->validate([
            'first_name_np' => 'required|string|max:255',
            'last_name_np' => 'required|string|max:255',
            'first_name_en' => 'required|string|max:255',
            'last_name_en' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'ethnicity' => 'required|string',
            'permanent_district' => 'required|string',
            'permanent_province' => 'required|string',
            'permanent_local_level' => 'required|string',
            'permanent_ward_no' => 'required|string',
            'admission_year' => 'required|digits:4',
            'date_of_admission' => 'required|date',
            'academic_program_duration' => 'required|string',
            'previous_level_of_study' => 'required|string',
            'previous_board_university_college' => 'required|string',
            'previous_registration_no' => 'required|string',
            'previous_institution_name' => 'required|string',
            'section_id' => 'required|exists:sections,id',
            'class_id' => 'required|exists:classes,id',
            'program_id' => 'required|exists:programs,id',
            
            // Optional fields
            'middle_name_np' => 'nullable|string|max:255',
            'middle_name_en' => 'nullable|string|max:255',
            'caste' => 'nullable|string|max:255',
            'edj' => 'nullable|string|max:255',
            'disability_status' => 'nullable|string|max:255',
            'citizenship_id' => 'nullable|string|max:255',
            'national_id' => 'nullable|string|max:255',
            'permanent_tole' => 'nullable|string|max:255',
            'permanent_house_no' => 'nullable|string|max:255',
            'school_id' => 'nullable|exists:schools,id',
            
            // File uploads
            'student_photo' => 'nullable|image|max:2048',
            'citizenship_front' => 'nullable|image|max:2048',
            'citizenship_back' => 'nullable|image|max:2048',
            'previous_study_records_attachment' => 'nullable|file|max:2048',
            
            // Temporary address fields
            'temporary_district' => 'nullable|string|max:255',
            'temporary_province' => 'nullable|string|max:255',
            'temporary_local_level' => 'nullable|string|max:255',
            'temporary_ward_no' => 'nullable|string|max:255',
            'temporary_tole' => 'nullable|string|max:255',
            'temporary_house_no' => 'nullable|string|max:255',
            
            // Guardian information
            'father_name' => 'nullable|string|max:255',
            'father_contact_no' => 'nullable|string|max:15',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_contact_no' => 'nullable|string|max:15',
            'mother_occupation' => 'nullable|string|max:255',
        ]);

        // Handle file uploads
        if ($request->hasFile('student_photo')) {
            // Delete old photo if exists
            if ($student->student_photo) {
                Storage::delete($student->student_photo);
            }
            $validated['student_photo'] = $request->file('student_photo')->store('student-photos');
        }

        if ($request->hasFile('citizenship_front')) {
            if ($student->citizenship_front) {
                Storage::delete($student->citizenship_front);
            }
            $validated['citizenship_front'] = $request->file('citizenship_front')->store('citizenship-documents');
        }

        if ($request->hasFile('citizenship_back')) {
            if ($student->citizenship_back) {
                Storage::delete($student->citizenship_back);
            }
            $validated['citizenship_back'] = $request->file('citizenship_back')->store('citizenship-documents');
        }

        if ($request->hasFile('previous_study_records_attachment')) {
            if ($student->previous_study_records_attachment) {
                Storage::delete($student->previous_study_records_attachment);
            }
            $validated['previous_study_records_attachment'] = $request->file('previous_study_records_attachment')->store('study-records');
        }

        // Update the student record
        $student->update($validated);

        return redirect()->route('admin.students.index', $student)
            ->with('success', 'Student information updated successfully');
    }


    public function destroy($id)
{
    try {
        // Find the student record
        $student = Student::findOrFail($id);

        // Start a database transaction
        DB::beginTransaction();

        // Delete related records first to avoid foreign key constraint violation

        $student->delete();

        // Commit the transaction if all actions succeed
        DB::commit();

        return redirect()->back()->withToastSuccess('Student Successfully Deleted');
    } catch (\Exception $e) {
        // Rollback the transaction if there's any error
        DB::rollBack();
        return back()->withToastError($e->getMessage());
    }
}



public function destroyMultiple(Request $request)
{
    $studentIds = $request->input('studentIds');

    if (!is_array($studentIds) || empty($studentIds)) {
        return response()->json(['error' => 'No students selected for deletion.'], 400);
    }

    try {
        DB::beginTransaction();

        foreach ($studentIds as $id) {
            $student = Student::findOrFail($id);

            $studentSessions = $student->studentSessions()->pluck('id');
            StudentAttendance::whereIn('student_session_id', $studentSessions)->delete();

            $user = User::find($student->user_id);
            if ($user) {
                $user->delete();
            }

            $student->delete();
        }

        DB::commit();

        return response()->json(['success' => 'Students Successfully Deleted']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function saveRollNumber(Request $request)
{
    $rollNumbers = $request->input('rollNumbers');

    foreach ($rollNumbers as $rollNumberData) {
        $student = Student::find($rollNumberData['student_id']);
        if ($student) {
            $student->roll_no = $rollNumberData['roll_number'];
            $student->save();
        }
    }

    return response()->json(['success' => 'Roll numbers saved successfully.']);
}

    public function importAllStudentIndex()
    {
        $page_title = "Import Student";
        $schoolId = session('school_id');
        $classes = Classg::where('school_id', $schoolId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('backend.school_admin.student.importindex', compact('page_title', 'classes'));
    }

    public function downloadSampleFile()
    {
        $filePath = public_path('sample-files/sample.csv');

        // Check if the file exists
        if (file_exists($filePath)) {
            return response()->download($filePath, 'sample.csv');
        } else {
            abort(404, 'Sample file not found');
        }
    }

    public function import(Request $request)
    {
        try {
            // Begin a database transaction
            DB::beginTransaction();
            $array1 = Excel::toCollection(new CombinedImport, $request->file('file'));
            // Access the outer collection
            foreach ($array1 as $outerCollection) {
                // Iterate through the inner collections
                foreach ($outerCollection as $row) {



                    $email = strtolower($row['f_name'] . '.' . $row['l_name'] . '.' . $row['admission_no'] . '@gmail.com');


                    // Check if the generated email already exists
                    $count = User::where('email', $email)->count();
                    if ($count > 0) {
                        // If the email already exists, append a number to make it unique
                        $email = strtolower($row['f_name'] . '.' . $row['l_name'] . '.' . $row['admission_no'] . $count . '@gmail.com');
                    }


                    $validator = Validator::make($row->toArray(), [

                        'state_id' => 'required',
                        'district_id' => 'required',
                        'municipality_id' => 'required',
                        'ward_id' => 'required',
                        'local_address' => 'nullable',
                        'permanent_address' => 'nullable',
                        'f_name' => 'required',
                        'l_name' => 'required',

                        'religion' => 'nullable',
                        'mobile_number' => 'nullable',
                        'gender' => 'required',
                        'dob' => 'required',
                        'blood_group' => 'nullable',
                        // 'image' => 'required',
                        'father_name' => 'nullable',
                        'father_phone' => 'nullable',
                        'father_occupation' => 'nullable',
                        'mother_name' => 'nullable',
                        'mother_phone' => 'nullable',
                        'mother_occupation' => 'nullable',
                        'emergency_contact_person' => 'nullable',
                        'emergency_contact_phone' => 'nullable',
                        'username' => 'nullable',
                        // 'password' => 'required',
                        'is_active' => 'boolean',
                        'guardian_is' => 'nullable',
                        'guardian_name' => 'nullable',
                        'guardian_phone' => 'nullable',
                        'guardian_relation' => 'nullable',
                        'guardian_email' => 'nullable',


                    ]);

                    if ($validator->fails()) {
                        // Redirect back with validation errors
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
                    // Validate user data
                    // $this->validateUserData($request);
                    $password = strtok($email, '@');
                    $username = strtok($email, '@');


                    $user_type_id = 8;
                    $role_id = 11;
                    $school_id = session('school_id');
                    $state_id = $row['state_id'];
                    $district_id = $row['district_id'];
                    $municipality_id = $row['municipality_id'];
                    $ward_id = $row['ward_id'];
                    $f_name = $row['f_name'];
                    $m_name = $row['m_name'];
                    $l_name = $row['l_name'];
                    // $email = 'email';
                    // 'email' => $email;
                    $local_address = $row['local_address'];
                    $permanent_address = $row['permanent_address'];
                    $gender = $row['gender'];
                    $religion = $row['religion'];
                    // $mobile_number = $row['mobile_number'];
                    $dob = $row['dob'];
                    $blood_group = $row['blood_group'];
                    $father_name = $row['father_name'];
                    $father_phone = $row['father_phone'];
                    $father_occupation = $row['father_occupation'];
                    $mother_name = $row['mother_name'];
                    $mother_phone = $row['mother_phone'];
                    $mother_occupation = $row['mother_occupation'];
                    $emergency_contact_person = $row['emergency_contact_person'];
                    $emergency_contact_phone = $row['emergency_contact_phone'];


                    $studentUser = User::create([
                        'user_type_id' => $user_type_id,
                        'role_id' => $role_id,
                        'school_id' => $school_id,
                        'state_id' => $state_id,
                        'district_id' => $district_id,
                        'municipality_id' => $municipality_id,
                        'ward_id' => $ward_id,
                        'f_name' => $f_name,
                        'm_name' => $m_name,
                        'l_name' => $l_name,
                        'email' => $email,
                        'local_address' => $local_address,
                        'permanent_address' => $permanent_address,
                        'password' => bcrypt($password),
                        'username' => $username,
                        'gender' => $gender,
                        'religion' => $religion,
                        'dob' => $dob,
                        'blood_group' => $blood_group,
                        'father_name' => $father_name,
                        'father_phone' => $father_phone,
                        'father_occupation' => $father_occupation,
                        'mother_name' => $mother_name,
                        'mother_phone' => $mother_phone,
                        'mother_occupation' => $mother_occupation,
                        'emergency_contact_person' => $emergency_contact_person,
                        'emergency_contact_phone' => $emergency_contact_phone,

                    ]);

                    $classId = $request->input('selected_class_id');
                    $sectionId = $request->input('selected_section_id');

                    // dd($sectionId);

                  // Use the method to create a student session
                  $this->createStudentSession($studentUser->id, $classId, $sectionId);

             
                    // CREATE STUDENT
                    // $reservation_quota_id = 1;
                    $admission_no = $row['admission_no'];
                    $roll_no = $row['roll_no'];
                    $admission_date = $row['admission_date'];
                    $school_house_id = $row['school_house_id'];
                    // $student_photo = $row['student_photo'];
                    $guardian_is = $row['guardian_is'];
                    $guardian_name = $row['guardian_name'];
                    $guardian_phone = $row['guardian_phone'];
                    $guardian_relation = $row['guardian_relation'];
                    $guardian_email = $row['guardian_email'];
                    // $transfer_certificate = $row['transfer_certificate'];

                    $studentCreate = Student::create([
                        'user_id' => $studentUser->id,
                        'school_id' => session('school_id'),
                        'class_id' => $classId,
                        'section_id' => $sectionId,
                        // 'reservation_quota_id' => $reservation_quota_id,
                        'admission_no' => $admission_no,
                        'roll_no' => $roll_no,
                        'admission_date' => $admission_date,
                        'school_house_id' => $school_house_id,
                        // 'student_photo' => $student_photo,
                        'guardian_is' => $guardian_is,
                        'guardian_name' => $guardian_name,
                        'guardian_phone' => $guardian_phone,
                        'guardian_relation' => $guardian_relation,
                        'guardian_email' => $guardian_email,
                        // 'transfer_certificate' => $transfer_certificate,
                    ]);
                }
            }
            DB::commit();
            return back()->with('success', 'Data has been uploaded');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function exportSelected(Request $request)
    {
        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');

        return Excel::download(new StudentsExport($classId, $sectionId), 'students.xlsx');
    }

    public function exportAll()
    {
        return Excel::download(new StudentsExport(), 'all_students.xlsx');
    }

}