<?php

namespace App\Http\Controllers\Shared;



use App\Models\Staff;
use App\Models\Classg;
use App\Models\School;

use App\Models\Student;
use App\Models\User;
use App\Models\Municipality;
use App\Models\District;
use App\Models\State;
use App\Models\Department;
use App\Models\SchoolUser;

use Illuminate\Http\Request;
use App\Models\StudentSession;
use App\Models\AcademicSession;

use App\imports\CombinedImport;
use Yajra\Datatables\Datatables;
use App\Http\Services\FormService;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;
use App\Http\Services\StaffUserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    protected $formService;
    protected $staffUserService;
    protected $imageSavePath = '/uploads/staffs/';
    public function __construct(FormService $formService, StaffUserService $staffUserService)
    {
        $this->formService = $formService;
        $this->staffUserService = $staffUserService;
    }

    public function getDistrict($province_id)
    {

        $districts = $this->formService->getDistricts($province_id);
        return response()->json($districts);
    }
    public function index()
    {

        $staffs = Staff::latest()->get();
        $page_title = 'Staff List';
        return view('backend.shared.staffs.index', compact('staffs', 'page_title'));
    }

    public function create()
{
    $page_title = 'Staff Create Form';
    $departments = Department::all();
    $roles = Role::whereIn('name', ['Teacher', 'Accountant', 'Librarian', 'Principal', 'Receptionist','Helper'])->get();
    $states = $this->formService->getProvinces();
    $adminStateId = Auth::user()->state_id;
    $adminDistrictId = Auth::user()->district_id;
    $adminMunicipalityId = Auth::user()->municipality_id;

    $schoolId = Auth::user()->school_id; 

    return view('backend.shared.staffs.create', compact(
        'page_title', 'states', 'roles', 'departments',
        'adminStateId', 'adminMunicipalityId', 'adminDistrictId',
        'schoolId'
    ));
}


public function show($id)
{
    
}
    // CREATE STAFF
    protected function saveStaff(array $staffInput)
    {
        try {
            $newStaff = Staff::create($staffInput);
        } catch (\Exception $e) {
            // Handle any specific exception related to staff creation
            throw $e;
        }
    }

    // VALIDATION FOR USERS and STAFFS
    protected function validateUserData(Request $request, $isStaff = false)
    {
        $rules = [

            'state_id' => 'required',
            'district_id' => 'required',
            'municipality_id' => 'required',
            'ward_id' => 'required',
            'local_address' => 'required',
            'permanent_address' => 'required',
            'f_name' => 'required',
            'l_name' => 'required',
            'email' => 'required',
            'religion' => 'nullable',
            'mobile_number' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'blood_group' => 'nullable',
            'emergency_contact_person' => 'nullable',
            'emergency_contact_phone' => 'nullable',
            'username' => 'nullable',
            'employee_id' => 'nullable',
            // 'password' => 'required',
            'facebook' => 'nullable',
            'twitter' => 'nullable',
            'linkedin' => 'nullable',
            'bank_name' => 'nullable',
            'bank_account_no' => 'nullable',
            'bank_branch' => 'nullable',
            'note' => 'nullable',
            'role' => 'nullable',
            // 'marital_status' => 'required',
            'is_active' => 'boolean',

        ];

        // Add conditional validation for Staff
        if ($isStaff) {
            $rules += [
                'marital_status' => 'nullable',
            ];

    }

    return $request->validate($rules);
  }


    protected function saveUserImage($croppedImage)
    {
        try {
            $savePath = public_path($this->imageSavePath);

            if (!File::exists($savePath)) {
                // Create the directory if it doesn't exist
                File::makeDirectory($savePath, 0775, true, true);
            }

            // Generate a unique filename
            $filename = time() . '.' . 'jpg';

            // Save the image with a unique filename
            $image = Image::make($croppedImage);
            $image->encode('jpg')->save($savePath . $filename);

            return $this->imageSavePath . $filename;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    protected function createUser(array $userData)
    {
        $userData['user_type_id'] = 6;
        $userData['school_id'] = 1;

        $result = User::create($userData);
        $result->assignRole((int) $userData['role_id']);
        return $result;
    }

    protected function saveResume(Request $request)
    {
        if ($request->hasFile('resume')) {
            $postPath = time() . '.' . $request->file('resume')->getClientOriginalExtension();
            $destinationPath = public_path('uploads/staffs/resume');
            $request->file('resume')->move($destinationPath, $postPath);
            ;

            return $destinationPath . '/' . $postPath;
        }

        return null;
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name_nepali' => 'required|string|max:255',
            'middle_name_nepali' => 'nullable|string|max:255',
            'last_name_nepali' => 'required|string|max:255',
            'first_name_english' => 'required|string|max:255',
            'middle_name_english' => 'nullable|string|max:255',
            'last_name_english' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'caste' => 'nullable|string|max:255',
            'ethnicity' => 'required|in:Dalit,Janajati,Madhesi,Muslim,Tharu,Brahmin,Chhetri',
            'edj' => 'nullable|boolean',
            'disability_status' => 'nullable|boolean',
            'citizenship_id' => 'required|string|unique:staffs',
            'national_id' => 'nullable|string|unique:staffs',
            'photo' => 'nullable|image|max:2048',
            'citizenship_front' => 'nullable|image|max:2048',
            'citizenship_back' => 'nullable|image|max:2048',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_occupation' => 'nullable|string|max:255',
            
            'permanent_province' => 'required|string|max:255',
            'permanent_district' => 'required|string|max:255',
            'permanent_local_level' => 'required|string|max:255',
            'permanent_ward_no' => 'required|string|max:10',
            'permanent_tole' => 'nullable|string|max:255',
            'permanent_house_no' => 'nullable|string|max:50',
            
            'temporary_province' => 'nullable|string|max:255',
            'temporary_district' => 'nullable|string|max:255',
            'temporary_local_level' => 'nullable|string|max:255',
            'temporary_ward_no' => 'nullable|string|max:10',
            'temporary_tole' => 'nullable|string|max:255',
            'temporary_house_no' => 'nullable|string|max:50',
            
            'level_of_study' => 'nullable|array',
            'board_university_college' => 'nullable|array',
            'registration' => 'nullable|array',
            'institution_name' => 'nullable|array',
            'academic_documents' => 'nullable|array',
            'academic_documents.*' => 'nullable|file|max:5120',
            
            'role' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'job_type' => 'required|in:Temporary,Permanent,Contract,Daily Basis',
            'category' => 'required|in:Technical,Non-Technical',
            'appointment_date' => 'required|date',
            'resume' => 'nullable|file|max:5120',
            'other_documents' => 'nullable|array',
            'other_documents.*' => 'nullable|file|max:5120',
            
            'school_id' => 'nullable|exists:schools,id',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // Handle file uploads
        $data = $request->except([
            'photo', 'citizenship_front', 'citizenship_back', 
            'academic_documents', 'resume', 'other_documents'
        ]);

        // Handle regular image uploads
        if ($request->hasFile('photo')) {
            $photoPath = $this->uploadFile($request->file('photo'), 'staff/photos');
            $data['photo'] = $photoPath;
        }
        
        if ($request->hasFile('citizenship_front')) {
            $frontPath = $this->uploadFile($request->file('citizenship_front'), 'staff/citizenship');
            $data['citizenship_front'] = $frontPath;
        }
        
        if ($request->hasFile('citizenship_back')) {
            $backPath = $this->uploadFile($request->file('citizenship_back'), 'staff/citizenship');
            $data['citizenship_back'] = $backPath;
        }
        
        if ($request->hasFile('resume')) {
            $resumePath = $this->uploadFile($request->file('resume'), 'staff/resumes');
            $data['resume'] = $resumePath;
        }

        // Handle arrays of academic documents
        if ($request->hasFile('academic_documents')) {
            $academicDocPaths = [];
            foreach ($request->file('academic_documents') as $key => $file) {
                if ($file) {
                    $path = $this->uploadFile($file, 'staff/academic_documents');
                    $academicDocPaths[$key] = $path;
                }
            }
            $data['academic_documents'] = json_encode($academicDocPaths);
        }
        
        // Handle other documents array
        if ($request->hasFile('other_documents')) {
            $otherDocPaths = [];
            foreach ($request->file('other_documents') as $key => $file) {
                if ($file) {
                    $path = $this->uploadFile($file, 'staff/other_documents');
                    $otherDocPaths[$key] = $path;
                }
            }
            $data['other_documents'] = json_encode($otherDocPaths);
        }

        // Convert json fields
        if (isset($data['level_of_study'])) {
            $data['level_of_study'] = json_encode($data['level_of_study']);
        }
        
        if (isset($data['board_university_college'])) {
            $data['board_university_college'] = json_encode($data['board_university_college']);
        }
        
        if (isset($data['registration'])) {
            $data['registration'] = json_encode($data['registration']);
        }
        
        if (isset($data['institution_name'])) {
            $data['institution_name'] = json_encode($data['institution_name']);
        }

        $staff = Staff::create($data);

        return redirect()->route('admin.staffs.index')->withToastSuccess('Staff Created successfully');
    }
    public function edit(string $id)
    {
        try {
            $staff = Staff::findOrFail($id);
            $page_title = 'Staff Edit Form';
            $municipalities = Municipality::all();
            $districts = District::all();
            $states = State::all();
            $wards = User::getWards($staff->municipality_id);
            $adminStateId = Auth::user()->state_id;
            $adminDistrictId = Auth::user()->district_id;
            $adminMunicipalityId = Auth::user()->municipality_id;
    
            // Decode JSON academic information
            $academics = [];
            if ($staff->level_of_study) {
                $levels = json_decode($staff->level_of_study, true);
                $institutions = json_decode($staff->institution_name, true);
                $boards = json_decode($staff->board_university_college, true);
                $registrations = json_decode($staff->registration, true);
                $documents = json_decode($staff->academic_documents, true) ?? [];
    
                foreach ($levels as $index => $level) {
                    $academics[] = [
                        'level_of_study' => $level,
                        'institution_name' => $institutions[$index] ?? '',
                        'board_university_college' => $boards[$index] ?? '',
                        'registration' => $registrations[$index] ?? '',
                        'document_path' => $documents[$index] ?? null,
                    ];
                }
            }
    
            return view('backend.shared.staffs.update', compact('staff', 'page_title', 'states', 'districts', 'municipalities', 'wards', 'academics','adminStateId', 'adminMunicipalityId', 'adminDistrictId',));
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }
    

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'first_name_nepali' => 'required|string|max:255',
            'middle_name_nepali' => 'nullable|string|max:255',
            'last_name_nepali' => 'required|string|max:255',
            'first_name_english' => 'required|string|max:255',
            'middle_name_english' => 'nullable|string|max:255',
            'last_name_english' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'caste' => 'nullable|string|max:255',
            'ethnicity' => 'required|in:Dalit,Janajati,Madhesi,Muslim,Tharu,Brahmin,Chhetri',
            'edj' => 'nullable|boolean',
            'disability_status' => 'nullable|boolean',
            'citizenship_id' => 'required|string|unique:staffs,citizenship_id,' . $staff->id,
            'national_id' => 'nullable|string|unique:staffs,national_id,' . $staff->id,
            'photo' => 'nullable|image|max:2048',
            'citizenship_front' => 'nullable|image|max:2048',
            'citizenship_back' => 'nullable|image|max:2048',
            'spouse_name' => 'nullable|string|max:255',
            'spouse_occupation' => 'nullable|string|max:255',
            
            'permanent_province' => 'required|string|max:255',
            'permanent_district' => 'required|string|max:255',
            'permanent_local_level' => 'required|string|max:255',
            'permanent_ward_no' => 'required|string|max:10',
            'permanent_tole' => 'nullable|string|max:255',
            'permanent_house_no' => 'nullable|string|max:50',
            
            'temporary_province' => 'nullable|string|max:255',
            'temporary_district' => 'nullable|string|max:255',
            'temporary_local_level' => 'nullable|string|max:255',
            'temporary_ward_no' => 'nullable|string|max:10',
            'temporary_tole' => 'nullable|string|max:255',
            'temporary_house_no' => 'nullable|string|max:50',
            
            'level_of_study' => 'nullable|array',
            'board_university_college' => 'nullable|array',
            'registration' => 'nullable|array',
            'institution_name' => 'nullable|array',
            'academic_documents' => 'nullable|array',
            'academic_documents.*' => 'nullable|file|max:5120',
            
            'role' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'job_type' => 'required|in:Temporary,Permanent,Contract,Daily Basis',
            'category' => 'required|in:Technical,Non-Technical',
            'appointment_date' => 'required|date',
            'resume' => 'nullable|file|max:5120',
            'other_documents' => 'nullable|array',
            'other_documents.*' => 'nullable|file|max:5120',
            
            'school_id' => 'nullable|exists:schools,id',
            'user_id' => 'nullable|exists:users,id',
            
            'existing_academic_documents' => 'nullable|array',
            'existing_resume' => 'nullable|string',
            'existing_other_documents' => 'nullable|array',
        ]);
    
        // Handle file uploads
        $data = $request->except([
            'photo', 'citizenship_front', 'citizenship_back', 
            'academic_documents', 'resume', 'other_documents',
            'existing_academic_documents', 'existing_resume', 'existing_other_documents'
        ]);
    
        // Handle regular image uploads
        if ($request->hasFile('photo')) {
            // Delete old file if exists
            if ($staff->photo) {
                $this->deleteFile('staff/photos/' . $staff->photo);
            }
            $photoPath = $this->uploadFile($request->file('photo'), 'staff/photos');
            $data['photo'] = $photoPath;
        }
        
        if ($request->hasFile('citizenship_front')) {
            if ($staff->citizenship_front) {
                $this->deleteFile('staff/citizenship/' . $staff->citizenship_front);
            }
            $frontPath = $this->uploadFile($request->file('citizenship_front'), 'staff/citizenship');
            $data['citizenship_front'] = $frontPath;
        }
        
        if ($request->hasFile('citizenship_back')) {
            if ($staff->citizenship_back) {
                $this->deleteFile('staff/citizenship/' . $staff->citizenship_back);
            }
            $backPath = $this->uploadFile($request->file('citizenship_back'), 'staff/citizenship');
            $data['citizenship_back'] = $backPath;
        }
        
        if ($request->hasFile('resume')) {
            if ($staff->resume) {
                $this->deleteFile('staff/resumes/' . $staff->resume);
            }
            $resumePath = $this->uploadFile($request->file('resume'), 'staff/resumes');
            $data['resume'] = $resumePath;
        } elseif ($request->has('existing_resume')) {
            $data['resume'] = $request->existing_resume;
        }
    
        // Handle arrays of academic documents
        $existingAcademicDocs = [];
        if ($request->has('existing_academic_documents')) {
            $existingAcademicDocs = $request->existing_academic_documents;
        } elseif ($staff->academic_documents) {
            $existingAcademicDocs = json_decode($staff->academic_documents, true) ?: [];
        }
        
        $newAcademicDocs = $existingAcademicDocs;
        if ($request->hasFile('academic_documents')) {
            foreach ($request->file('academic_documents') as $key => $file) {
                if ($file) {
                    $path = $this->uploadFile($file, 'staff/academic_documents');
                    $newAcademicDocs[$key] = $path;
                }
            }
        }
        $data['academic_documents'] = json_encode($newAcademicDocs);
        
        // Handle other documents array
        $existingOtherDocs = [];
        if ($request->has('existing_other_documents')) {
            $existingOtherDocs = $request->existing_other_documents;
        } elseif ($staff->other_documents) {
            $existingOtherDocs = json_decode($staff->other_documents, true) ?: [];
        }
        
        $newOtherDocs = $existingOtherDocs;
        if ($request->hasFile('other_documents')) {
            foreach ($request->file('other_documents') as $file) {
                if ($file) {
                    $path = $this->uploadFile($file, 'staff/other_documents');
                    $newOtherDocs[] = $path;
                }
            }
        }
        $data['other_documents'] = json_encode($newOtherDocs);
    
        // Convert json fields
        if (isset($data['level_of_study'])) {
            $data['level_of_study'] = json_encode($data['level_of_study']);
        }
        
        if (isset($data['board_university_college'])) {
            $data['board_university_college'] = json_encode($data['board_university_college']);
        }
        
        if (isset($data['registration'])) {
            $data['registration'] = json_encode($data['registration']);
        }
        
        if (isset($data['institution_name'])) {
            $data['institution_name'] = json_encode($data['institution_name']);
        }
    
        $staff->update($data);
    
        return redirect()->route('admin.staffs.index')->withToastSuccess('Staff updated successfully');
    }
    
    // Helper method for file deletion
    protected function deleteFile($path)
    {
        $fullPath = public_path('uploads/' . $path);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    /**
     * Helper method to upload files
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $folder
     * @return string
     */
    private function uploadFile($file, $folder)
    {
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/' . $folder;
        
        // Create directory if it doesn't exist
        if (!File::isDirectory(public_path($path))) {
            File::makeDirectory(public_path($path), 0777, true);
        }
        
        $file->move(public_path($path), $fileName);
        
        return $path . '/' . $fileName;
    }

    public function destroy(string $id)
    {
        $staff = Staff::with('user')->findOrFail($id);

        if ($staff->delete()) {
            return redirect()->back()->withToastSuccess('Staff Successfully Deleted!');
        } else {
            return back()->withToastError('An error occurred while performing the operation.');
        }
    }


    public function getAllStaff(Request $request)
    {
        $staff = $this->staffUserService->getStaffsForDataTable($request->all());
        // dd($staff);
        return Datatables::of($staff)
            ->editColumn('f_name', function ($row) {
                return $row->f_name;
            })
            ->editColumn('l_name', function ($row) {
                return $row->l_name;
            })
            ->editColumn('marital_status', function ($row) {
                return $row->marital_status ; 
            })
            ->editColumn('date_of_joining', function ($row) {
                return $row->date_of_joining;
            })
            ->editColumn('date_of_leaving', function ($row) {
                return $row->date_of_leaving;
            })
            ->editColumn('contract_type', function ($row) {
                return $row->contract_type;
            })
            ->editColumn('shift', function ($row) {
                return $row->shift;
            })
            ->editColumn('maternity_leave', function ($row) {
                return $row->maternity_leave;
            })
            ->editColumn('other_document', function ($row) {
                return $row->other_document;
            })

            ->escapeColumns([])
            ->addColumn('created_at', function ($user) {
                return $user->created_at->diffForHumans();
            })

            ->addColumn('status', function ($staff) {
                return $staff->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })

            ->addColumn('actions', function ($staff) {
                return view('backend.shared.staffs.partials.controller_action', [
                    'staff' => $staff
                ])->render();
            })

            ->make(true);
    }

    public function importStaffs()
    {
        $page_title = "Import Staff";
        $schoolId = session('school_id');
        return view('backend.shared.staffs.importindex', compact('page_title'));
    }

    public function addLeaveDetails(Request $request)
    {
        $leave = 'Add Leave Details';
        $type = $request->query('type');
        $staffId = $request->query('staff_id');
        
        return view('backend.shared.staffs.leavedetails', compact('leave', 'type', 'staffId'));
    }

    public function storeLeaveDetails(Request $request)
    {
        $validatedData = $request->validate([
            'medical_leave' => 'required|string',
            'casual_leave' => 'required|string',
            'staff_id' => 'required|exists:staffs,id',
        ]);

        // Find the staff member by ID
        $staff = Staff::findOrFail($validatedData['staff_id']);

        // Update the staff member's leave details
        $staff->medical_leave = $validatedData['medical_leave'];
        $staff->casual_leave = $validatedData['casual_leave'];
        $staff->save();

        return redirect()->route('admin.staffs.index')->with('success', 'Leave details added successfully.');
    }

    public function addResignationDetails(Request $request)
    {
        $page_title = 'Add Resignation Details';
        $type= $request->query('type');
        $staffId= $request->query('staff_id');
        return view('backend.shared.staffs.resignationdetails', compact('page_title','type','staffId'));
    }

    public function storeResignationDetails(Request $request)
    {
        $validatedData = $request->validate([
            'resignation_letter' => 'required|string',
            'staff_id' => 'required|exists:staffs,id',
            //'note' => 'nullable|string',
        ]);
        $staff = Staff::findOrFail($validatedData['staff_id']);
        $staff->resignation_letter = $validatedData['resignation_letter'];
        //$staff->note = $validatedData['note'];
        $staff->save();
        return redirect()->route('admin.staffs.index')->with('success', 'Staff resignation added successfully.');
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
    
                    $data = $row->toArray();
    
                    // Ensure 'marital_status' key exists and standardize its value
                    if (!array_key_exists('marital_status', $data)) {
                        $data['marital_status'] = null;
                    } else {
                        $data['marital_status'] = trim(strtolower($data['marital_status']));
                    }
    
                    $validator = Validator::make($data, [
                        'state_id' => 'required',
                        'district_id' => 'required',
                        'municipality_id' => 'required',
                        'ward_id' => 'required',
                        'f_name' => 'required',
                        'l_name' => 'required',
                        'mobile_number' => 'required',
                        'email' => 'required|unique:users,email',
                        'employee_id' => 'required|unique:staffs,employee_id',
                        'gender' => 'required',
                        'role' => 'required',
                        'dob' => 'required',
                        'department' => 'required',
                        'contract_type' => 'required',
                        'emergency_contact_person' => 'required',
                        'emergency_contact_phone' => 'required',
                        'marital_status' => 'nullable', // Allow marital_status to be nullable
                    ]);
    
                    if ($validator->fails()) {
                        // Redirect back with validation errors
                        return redirect()->back()->withErrors($validator)->withInput();
                    }
    
                    // Extract role id from name
                    $role_id = $this->roleIdentification($data['role']);
                    if ($role_id == null) {
                        return redirect()->back()->withErrors('Invalid Role name of : ' . $data['f_name'])->withInput();
                    }
    
                    // Extract department id from name
                    $department_id = $this->departmentIdentification($data['department']);
                    if ($department_id == null) {
                        return redirect()->back()->withErrors('Invalid Department name of : ' . $data['f_name'])->withInput();
                    }
    
                    $marriedId = $this->maritialStatus($data['marital_status']);
                    if ($marriedId === null && $data['marital_status'] !== null) {
                        return redirect()->back()->withErrors('Invalid Marital Status of : ' . $data['f_name'])->withInput();
                    }
    
                    $staffUser = User::create([
                        'user_type_id' => 6,
                        'role_id' => $role_id,
                        'school_id' => session('school_id'),
                        'state_id' => $data['state_id'],
                        'district_id' => $data['district_id'],
                        'municipality_id' => $data['municipality_id'],
                        'ward_id' => $data['ward_id'],
                        'f_name' => $data['f_name'],
                        'm_name' => $data['m_name'] ?? null,
                        'l_name' => $data['l_name'],
                        'email' => $data['email'],
                        'local_address' => $data['local_address'] ?? null,
                        'permanent_address' => $data['permanent_address'] ?? null,
                        'password' => bcrypt('password'),
                        'gender' => $data['gender'],
                        'religion' => $data['religion'] ?? null,
                        'dob' => $data['dob'] ?? null,
                        'blood_group' => $data['blood_group'] ?? null,
                        'father_name' => $data['father_name'] ?? null,
                        'father_phone' => $data['father_phone'] ?? null,
                        'mother_name' => $data['mother_name'] ?? null,
                        'mother_phone' => $data['mother_phone'] ?? null,
                        'emergency_contact_person' => $data['emergency_contact_person'],
                        'emergency_contact_phone' => $data['emergency_contact_phone'],
                    ]);
    
                    // CREATE staff
                    $studentCreate = Staff::create([
                        'user_id' => $staffUser->id,
                        'school_id' => session('school_id'),
                        'employee_id' => $data['employee_id'],
                        'department_id' => $department_id,
                        'qualification' => $data['qualification'] ?? null,
                        'work_experience' => $data['work_experience'] ?? null,
                        'marital_status' => $marriedId,
                        'date_of_joining' => $data['date_of_joining'] ?? null,
                        'payscale' => $data['payscale'] ?? null,
                        'basic_salary' => $data['basic_salary'] ?? null,
                        'contract_type' => $data['contract_type'],
                        'shift' => $data['shift'],
                        'medical_leave' => $data['medical_leave'] ?? null,
                        'casual_leave' => $data['casual_leave'] ?? null,
                        'maternity_leave' => $data['maternity_leave'] ?? null,
                        'role' => $role_id,
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
    

    public function roleIdentification($role_name)
    {
        $roleId = null;
        switch ($role_name) {
            case "Teacher":
                $roleId = 6;
                break;
            case "Accountant":
                $roleId = 7;
                break;
            case "Librarian":
                $roleId = 8;
                break;
            case "Principal":
                $roleId = 9;
                break;
            case "Receptionist":
                $roleId = 10;
                break;
            default:
                $roleId = null;
        }

        return $roleId;
    }
    public function departmentIdentification($department_name)
    {
        $departmentId = null;
        switch ($department_name) {
            case "Academic":
                $departmentId = 1;
                break;
            case "Library":
                $departmentId = 2;
                break;
            case "Sports":
                $departmentId = 3;
                break;
            case "Science":
                $departmentId = 4;
                break;
            case "Commerce":
                $departmentId = 5;
                break;
            case "Arts":
                $departmentId = 6;
                break;
            case "Exam":
                $departmentId = 7;
                break;
            case "Admin":
                $departmentId = 8;
                break;
            case "Finance":
                $departmentId = 9;
                break;
            default:
                $departmentId = null;
        }

        return $departmentId;
    }
    public function maritialStatus($status)
    {
        // Trim whitespace and convert to lowercase for standardization
        $status = trim(strtolower($status));
    
        // Define possible statuses in an associative array
        $statuses = [
            'married' => 1,
            'unmarried' => 0,
            'divorced' => 2,
            'widow' => 3,
            'separated' => 4,  // Corrected spelling from 'separeted'
        ];
    
        // Check if the status exists in the array and return the corresponding value
        $maritalStatus = $statuses[$status] ?? null;
    
        echo $status; // Debugging: print the standardized status
        echo ($maritalStatus); // Debugging: print the marital status id
    
        return $maritalStatus;
    }
    


}

