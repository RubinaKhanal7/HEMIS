<?php
namespace App\Http\Controllers\SchoolAdmin;


use App\Models\Student;
use App\Models\Program;
use App\Models\Classg;
use App\Models\State;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Section;


class StudentReportController extends Controller
{
    public function index(Request $request)
    {
        // Get the total count of all students in the database
        $totalStudentsCount = Student::count();
       
        // Fetch distinct values for dropdown filters
        $admissionYears = Student::distinct()
            ->orderBy('admission_year', 'desc')
            ->pluck('admission_year');
           
        $programs = Program::orderBy('title')->get();
        $classes = Classg::orderBy('class')->get();
        $sections = Section::orderBy('section_name')->get();
       
        // Get distinct values for other filters
        $ethnicities = Student::distinct()
            ->whereNotNull('ethnicity')
            ->orderBy('ethnicity')
            ->pluck('ethnicity');
           
        // Get provinces (states)
        $provinces = State::orderBy('name')->get();
       
        // Get districts (initially empty or all depending on your preference)
        // If no province is selected, we'll load all districts
        if ($request->filled('permanent_province')) {
            $districts = District::where('province_id', $request->permanent_province)
                ->orderBy('name')
                ->get();
        } else {
            $districts = District::orderBy('name')->get();
        }
   
        // Initialize query builder
        $studentsQuery = Student::query()
            ->with(['program', 'class']) // Eager load relationships
            ->select('students.*');
   
        // Apply filters only if they are filled
        if ($request->filled('admission_year')) {
            $studentsQuery->where('admission_year', $request->admission_year);
        }
       
        if ($request->filled('program_id')) {
            $studentsQuery->where('program_id', $request->program_id);
        }
       
        if ($request->filled('class_id')) {
            $studentsQuery->where('class_id', $request->class_id);
        }
       
        if ($request->filled('gender')) {
            $studentsQuery->where('gender', $request->gender);
        }
       
        if ($request->filled('ethnicity')) {
            $studentsQuery->where('ethnicity', $request->ethnicity);
        }
       
        if ($request->filled('permanent_province')) {
            $studentsQuery->where('permanent_province', $request->permanent_province);
        }
       
        if ($request->filled('permanent_district')) {
            $studentsQuery->where('permanent_district', $request->permanent_district);
        }


        // Get filtered count
        $filteredCount = $studentsQuery->count();
       
        // Get students based on applied filters
        $students = $studentsQuery->get();
   
        // Return the view with filtered results or empty collection
        return view('backend.school_admin.report.index', compact(
            'students',
            'admissionYears',
            'programs',
            'classes',
            'ethnicities',
            'provinces',
            'districts',
            'totalStudentsCount',  // Total students in database
            'filteredCount',
            'sections'        // Filtered results count
        ));
    }
   
    // Method to get districts by province
    public function getDistrictsByProvince($provinceId)
    {
        $districts = District::where('province_id', $provinceId)
            ->orderBy('name')
            ->get();
       
        return response()->json($districts);
    }


    public function getSectionsByClass($classId)
    {
        $sections = Section::where('class_id', $classId)->get();
        return response()->json($sections);
    }


    // Method to get programs by section
    public function getProgramsBySection($sectionId)
    {
        $programs = Program::where('section_id', $sectionId)->get();
        return response()->json($programs);
    }


}

