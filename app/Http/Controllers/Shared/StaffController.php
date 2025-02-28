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
use App\Imports\StaffsImport;


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
use App\Http\Services\StaffUserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


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
        // Check if it's an AJAX request for DataTable
        if ($request->ajax()) {
            try {
                Log::info('Fetching staff data via AJAX');  // Add a log entry to confirm we're reaching this point
   
                // Select only the necessary columns for performance
                $staffs = Staff::select([
                    'id',
                    'first_name_english',
                    'last_name_english',
                    'role',
                    'level',
                    'job_type',
                    'category',
                ]);
   
                // Apply search functionality if the search parameter exists
                if ($search = $request->get('search')['value']) {
                    $staffs = $staffs->where(function($query) use ($search) {
                        $query->where('first_name_english', 'like', "%$search%")
                            ->orWhere('last_name_english', 'like', "%$search%")
                            ->orWhere('role', 'like', "%$search%")
                            ->orWhere('level', 'like', "%$search%")
                            ->orWhere('job_type', 'like', "%$search%")
                            ->orWhere('category', 'like', "%$search%");
                    });
                }
   
                // Apply sorting functionality
                if ($order = $request->get('order')) {
                    $column = $request->get('columns')[$order[0]['column']]['data'];
                    $direction = $order[0]['dir'];
                    $staffs = $staffs->orderBy($column, $direction);
                }
   
                // Apply pagination - paginate directly with DataTables pagination parameters
                $staffs = $staffs->paginate($request->get('length', 10));
   
                Log::info('Fetched ' . $staffs->total() . ' staff records.');
   
                // Add the 'actions' column for each staff row (e.g., Edit and Delete buttons)
                $data = $staffs->items();
                foreach ($data as $staff) {
                    $staff->actions = view('backend.shared.staffs.partials.controller_action', compact('staff'))->render();
                }
   
                // Return the data in the format that DataTables expects
                return response()->json([
                    'draw' => intval($request->get('draw')),
                    'recordsTotal' => $staffs->total(),
                    'recordsFiltered' => $staffs->total(),
                    'data' => $data  // The actual data for the table
                ]);
            } catch (\Exception $e) {
                Log::error("Error fetching staff data: " . $e->getMessage());
                return response()->json([
                    'error' => 'Failed to fetch staff data'
                ], 500);  // Return a 500 error if something goes wrong
            }
        }
   
        // Return a 400 error if it's not an AJAX request
        return response()->json(['error' => 'Invalid request'], 400);
    }
   


    public function importStaffs()
    {
        $page_title = "Import Staff";
        $schoolId = session('school_id');
        return view('backend.shared.staffs.importindex', compact('page_title'));
    }


    public function import(Request $request)
    {
        try {
            if (!$request->hasFile('file')) {
                return redirect()->back()->with('error', 'No file was uploaded');
            }
           
            // Begin a database transaction
            DB::beginTransaction();
           
            Excel::import(new StaffsImport(), $request->file('file'));
           
            // If we reach this point without exceptions, commit the transaction
            DB::commit();
           
            return redirect()->route('admin.staffs.index')->with('success', 'Staff data has been successfully imported.');
           
        } catch (\Exception $e) {
            // Roll back the transaction in case of error
            DB::rollback();
           
            return redirect()->back()->with('error', 'Error importing staff data: ' . $e->getMessage());
        }
    }
}





