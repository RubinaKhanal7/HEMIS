<?php

namespace App\Http\Controllers\SchoolAdmin;

use Alert;
use Validator;
use Exception;
use Carbon\Carbon;
use App\Models\Classg;
use App\Models\Section;
use App\Models\Program;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProgramController extends Controller
{
    public function index()
    {
        $page_title = 'Program Listing';
        $classes = Classg::where('is_active', 1)->get();
        $sections = Section::where('is_active', 1)->get();
        return view('backend.school_admin.program.index', compact('page_title', 'classes', 'sections'));
    }

    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        try {
            Program::create($request->all());
            return redirect()->back()->withToastSuccess('Program Saved Successfully!');
        } catch (\Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $program = Program::find($id);
        return view('backend.school_admin.program.index', compact('program'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'is_active' => 'required',
        ]);

        if ($validatedData->fails()) {
            return back()->withToastError($validatedData->messages()->all()[0])->withInput();
        }

        $program = Program::findorfail($id);
        try {
            $program->update($request->all());
            return redirect()->back()->withToastSuccess('Successfully Updated Program!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        $program = Program::find($id);
        try {
            $program->delete();
            return redirect()->back()->withToastSuccess('Program has been Successfully Deleted!');
        } catch (Exception $e) {
            return back()->withToastError($e->getMessage());
        }
    }

    public function getAllPrograms(Request $request)
    {
        $programs = $this->getForDataTable($request->all());

        return Datatables::of($programs)
            ->escapeColumns([])
            ->addColumn('id', function ($program) {
                return $program->id;
            })
            ->addColumn('class', function ($program) {
                return $program->class->class;
            })
            ->addColumn('section', function ($program) {
                return $program->section->section_name;
            })
            ->addColumn('title', function ($program) {
                return $program->title;
            })
            ->addColumn('created_at', function ($program) {
                return $program->created_at->diffForHumans();
            })
            ->addColumn('status', function ($program) {
                return $program->is_active == 1 ? '<span class="btn-sm btn-success">Active</span>' : '<span class="btn-sm btn-danger">Inactive</span>';
            })
            ->addColumn('actions', function ($program) {
                return view('backend.school_admin.program.partials.controller_action', ['program' => $program])->render();
            })
            ->make(true);
    }

    public function getForDataTable($request)
    {
        $dataTableQuery = Program::with(['class', 'section'])
            ->when(isset($request->id), function ($query) use ($request) {
                $query->where('id', $request->id);
            })
            ->get();

        return $dataTableQuery;
    }


public function getSectionsByClass(Request $request)
{
    $validator = Validator::make($request->all(), [
        'class_id' => 'required|exists:classes,id',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 422);
    }
    $sections = Section::whereHas('classes', function($query) use ($request) {
        $query->where('class_id', $request->class_id);
    })->where('is_active', 1)->get();

    return response()->json(['sections' => $sections]);
}
}