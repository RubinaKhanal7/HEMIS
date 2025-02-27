<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Student;
use App\Models\Program;
use App\Models\IDCardDesign;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Yajra\DataTables\Facades\DataTables;

class IDCardGenerationController extends Controller
{
    /**
     * Display the ID card generation page
     */
    public function index()
    {
        $page_title = 'Generate ID Cards';
        $classes = Classg::all(); // Level of study
        $idcard_designs = IDCardDesign::all();
        
        return view('backend.school_admin.generate_id_card.index', compact('page_title', 'classes', 'idcard_designs'));
    }
    

public function getFaculties($classId)
{
    $sections = Section::where('class_id', $classId)
        ->orderBy('section_name')
        ->get();
    
    return response()->json($sections);
}

public function getProgram($sectionId)
{
    $programs = Program::where('section_id', $sectionId)
        ->orderBy('title')
        ->get();
    
    return response()->json($programs);
}
    
    /**
     * Get students based on filters for DataTable
     */
    public function getStudents(Request $request)
    {
        $query = Student::with(['class', 'section', 'program']);
        
        if ($request->class_id) {
            $query->where('class_id', $request->class_id);
        }
        
        if ($request->section_id) {
            $query->where('section_id', $request->section_id);
        }
        
        if ($request->program_id) {
            $query->where('program_id', $request->program_id);
        }
        
        return DataTables::of($query)
            ->addColumn('full_name', function ($student) {
                return $student->first_name_en . ' ' . $student->middle_name_en . ' ' . $student->last_name_en;
            })
            ->addColumn('actions', function ($student) use ($request) {
                $idCardId = $request->id_card_id;
                $actions = '<div class="btn-group">';
                $actions .= '<a href="javascript:void(0)" class="btn btn-sm btn-info show-id-card" 
                            data-student-id="'.$student->id.'" 
                            data-id-card-id="'.$idCardId.'">
                            <i class="fa fa-eye"></i></a>';
                $actions .= '<a href="javascript:void(0)" class="btn btn-sm btn-success download-id-card" 
                            data-student-id="'.$student->id.'" 
                            data-id-card-id="'.$idCardId.'">
                            <i class="fa fa-download"></i></a>';
                $actions .= '</div>';
                return $actions;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    
    /**
     * Show ID card design for a specific student
     */
    public function showIDCardDesign($studentId, $idCardId)
    {
        $student = Student::with(['class', 'section', 'program'])->findOrFail($studentId);
        $design = IDCardDesign::findOrFail($idCardId);
        
        return view('backend.school_admin.generate_id_card.show', compact('student', 'design'));
    }
/**
 * Download a single ID card for a specific student
 */
public function downloadIDCard($studentId, $idCardId)
{
    $student = Student::with(['class', 'section', 'program'])->findOrFail($studentId);
    $design = IDCardDesign::findOrFail($idCardId);
    $pdf = PDF::loadView('backend.school_admin.generate_id_card.pdf', compact('student', 'design'));
    $pdf->setPaper($design->paper_size ?? 'a4', $design->orientation ?? 'portrait');

    return $pdf->download('id_card_' . $student->id . '.pdf');
}

/**
 * Bulk download ID cards as a ZIP file
 */
public function bulkDownload(Request $request)
{
    $request->validate([
        'student_ids' => 'required|array',
        'id_card_id' => 'required|exists:id_card_designs,id',
    ]);
    
    $studentIds = $request->student_ids;
    $idCardId = $request->id_card_id;
    $design = IDCardDesign::findOrFail($idCardId);
    $tempPath = storage_path('app/temp/id_cards_' . time());
    if (!file_exists($tempPath)) {
        mkdir($tempPath, 0755, true);
    }

    foreach ($studentIds as $studentId) {
        $student = Student::with(['class', 'section', 'program'])->find($studentId);
        
        if ($student) {
            $pdf = PDF::loadView('backend.school_admin.generate_id_card.pdf', compact('student', 'design'));
            $pdf->setPaper($design->paper_size ?? 'a4', $design->orientation ?? 'portrait');
            $pdf->save($tempPath . '/id_card_' . $student->id . '.pdf');
        }
    }

    $zipFileName = 'id_cards_' . date('Y-m-d_H-i-s') . '.zip';
    $zipFilePath = storage_path('app/temp/' . $zipFileName);
    
    $zip = new ZipArchive();
    if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($tempPath),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );
        
        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = basename($filePath);
                $zip->addFile($filePath, $relativePath);
            }
        }
        
        $zip->close();
    }

    $this->cleanTempDirectory($tempPath);
    return response()->download($zipFilePath)->deleteFileAfterSend(true);
}

/**
 * Helper method to clean temporary directory
 */
private function cleanTempDirectory($dir)
{
    $files = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::CHILD_FIRST
    );
    
    foreach ($files as $file) {
        if ($file->isDir()) {
            rmdir($file->getRealPath());
        } else {
            unlink($file->getRealPath());
        }
    }
    
    rmdir($dir);
}
}