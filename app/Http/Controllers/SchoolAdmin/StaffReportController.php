<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffReportController extends Controller
{
    public function index()
    {
        $roles = Staff::select('role')->distinct()->pluck('role')->toArray();
        $levels = Staff::select('level')->distinct()->pluck('level')->toArray();
        $schools = School::all();
       
        // Pass empty collection to the view
        $staffs = collect();
       
        return view('backend.school_admin.report.staffreport', compact('staffs', 'roles', 'levels', 'schools'));
    }
   
    public function report(Request $request)
    {
        $roles = Staff::select('role')->distinct()->pluck('role')->toArray();
        $levels = Staff::select('level')->distinct()->pluck('level')->toArray();
        $schools = School::all();
       
        // Check if any filter is applied
        $hasFilters = $request->filled('level') || 
                      $request->filled('role') || 
                      $request->filled('job_type') || 
                      $request->filled('gender') || 
                      $request->filled('ethnicity') || 
                      $request->filled('category') || 
                      $request->filled('full_name');
                      
        // If no filters are applied, return an empty collection
        if (!$hasFilters) {
            $staffs = collect();
            return view('backend.school_admin.report.staffreport', compact('staffs', 'roles', 'levels', 'schools'));
        }
        
        $query = Staff::with('school');

        // Filter by level if provided
        $query->when($request->filled('level'), function ($q) use ($request) {
            $selectedLevels = is_array($request->level) ? $request->level : [$request->level];
            $q->whereIn('level', $selectedLevels);
        });
        
        // Filter by role if provided
        $query->when($request->filled('role'), function ($q) use ($request) {
            $selectedRoles = is_array($request->role) ? $request->role : [$request->role];
            $q->whereIn('role', $selectedRoles);
        });
        
        // Filter by job_type if provided
        $query->when($request->filled('job_type'), function ($q) use ($request) {
            $jobTypes = is_array($request->job_type) ? $request->job_type : [$request->job_type];
            $q->whereIn('job_type', $jobTypes);
        });
        
        // Filter by category if provided
        $query->when($request->filled('category'), function ($q) use ($request) {
            $categories = is_array($request->category) ? $request->category : [$request->category];
            $q->whereIn('category', $categories);
        });
        
        // Filter by gender if provided
        $query->when($request->filled('gender'), function ($q) use ($request) {
            $genders = is_array($request->gender) ? $request->gender : [$request->gender];
            $q->whereIn('gender', $genders);
        });
        
        // Filter by ethnicity if provided
        $query->when($request->filled('ethnicity'), function ($q) use ($request) {
            $ethnicities = is_array($request->ethnicity) ? $request->ethnicity : [$request->ethnicity];
            $q->whereIn('ethnicity', $ethnicities);
        });
        
        // Filter by full_name if provided
        $query->when($request->filled('full_name'), function ($q) use ($request) {
            $name = $request->full_name;
            $q->where(function($subQuery) use ($name) {
                $subQuery->where(DB::raw("CONCAT(first_name_english, ' ', COALESCE(middle_name_english, ''), ' ', last_name_english)"), 'LIKE', "%{$name}%")
                        ->orWhere(DB::raw("CONCAT(first_name_nepali, ' ', COALESCE(middle_name_nepali, ''), ' ', last_name_nepali)"), 'LIKE', "%{$name}%");
            });
        });
        
        // Get filtered staff records
        $staffs = $query->get();
        
        return view('backend.school_admin.report.staffreport', compact('staffs', 'roles', 'levels', 'schools'));
    }
}