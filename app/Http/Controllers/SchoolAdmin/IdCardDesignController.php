<?php
namespace App\Http\Controllers\SchoolAdmin;


use App\Http\Controllers\Controller;
use App\Models\IdCardDesign;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class IdCardDesignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $data['page_title'] = 'ID Card Designs';
    
    
    $data['designs'] = IdCardDesign::with(['school', 'student'])
        ->latest()
        ->get()
        ->unique('school_id');
    
   
    
    return view('backend.school_admin.id_card_design.index', $data);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['page_title'] = 'Create ID Card Design';
        $data['schools'] = School::all();
        return view('backend.school_admin.id_card_design.create', $data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'nullable|exists:schools,id',
            'college_name' => 'required|string|max:255',
            'content_footer' => 'required|string',
        ]);


        $idCardDesign = new IdCardDesign();
        $idCardDesign->school_id = $request->school_id;
        $idCardDesign->college_name = $request->college_name;
        $idCardDesign->content_footer = $request->content_footer;


        // Handle sign upload
        if ($request->hasFile('sign')) {
            $file = $request->file('sign');
            $filename = time() . '_sign.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/id_cards/');
           
            // Create directory if it doesn't exist
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true);
            }
           
            $file->move($uploadPath, $filename);
            $idCardDesign->sign = 'uploads/id_cards/' . $filename;
        }


        // Handle background_img upload
        if ($request->hasFile('background_img')) {
            $file = $request->file('background_img');
            $filename = time() . '_background.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/id_cards/');
           
            // Create directory if it doesn't exist
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0777, true);
            }
           
            $file->move($uploadPath, $filename);
            $idCardDesign->background_img = 'uploads/id_cards/' . $filename;
        }


        $idCardDesign->save();


        return redirect()->route('admin.id-carddesigns.index')
                        ->with('success', 'ID Card design created successfully');
    }


    public function show(IdCardDesign $idCardDesign)
    {
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'design' => [
                    'id' => $idCardDesign->id,
                    'college_name' => $idCardDesign->college_name,
                    'content_footer' => $idCardDesign->content_footer,
                    'sign' => $idCardDesign->sign ? asset($idCardDesign->sign) : null,
                    'background_img' => $idCardDesign->background_img ? asset($idCardDesign->background_img) : null,
                    'created_at' => $idCardDesign->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $idCardDesign->updated_at->format('Y-m-d H:i:s'),
                ]
            ]);
        }
        
        return redirect()->route('admin.id-carddesigns.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $idCardDesign = IdCardDesign::findOrFail($id);
        $data['page_title'] = 'Edit ID Card Design';
        $data['design'] = $idCardDesign;
        $data['schools'] = School::all();
        
        return view('backend.school_admin.id_card_design.update', $data);
    }
    
   
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validate the form data
    $request->validate([
        'school_id' => 'nullable|exists:schools,id',
        'college_name' => 'required|string|max:255',
        'content_footer' => 'required|string',
    ]);

    // Find the design by ID
    $idCardDesign = IdCardDesign::findOrFail($id);

    // Prepare data to be updated
    $updateData = [
        'school_id' => $request->school_id,
        'college_name' => $request->college_name,
        'content_footer' => $request->content_footer,
    ];

    // Handle the 'sign' image upload
    if ($request->hasFile('sign')) {
       
        if ($idCardDesign->sign && File::exists(public_path($idCardDesign->sign))) {
            File::delete(public_path($idCardDesign->sign));
        }
        $file = $request->file('sign');
        $filename = time() . '_sign.' . $file->getClientOriginalExtension();
        $uploadPath = public_path('uploads/id_cards/');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true);
        }

        $file->move($uploadPath, $filename);
        $updateData['sign'] = 'uploads/id_cards/' . $filename;
    }

    // Handle the 'background_img' upload
    if ($request->hasFile('background_img')) {
    
        if ($idCardDesign->background_img && File::exists(public_path($idCardDesign->background_img))) {
            File::delete(public_path($idCardDesign->background_img));
        }
        $file = $request->file('background_img');
        $filename = time() . '_background.' . $file->getClientOriginalExtension();
        $uploadPath = public_path('uploads/id_cards/');

        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true);
        }

        $file->move($uploadPath, $filename);
        $updateData['background_img'] = 'uploads/id_cards/' . $filename;
    }

   
    $idCardDesign->update($updateData);

    return redirect()->route('admin.id-carddesigns.index')
                    ->with('success', 'ID Card design updated successfully');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $idCardDesign = IdCardDesign::find($id);

            if (!$idCardDesign) {
                Log::error('ID Card Design not found: ' . $id);
                return redirect()->route('admin.id-carddesigns.index')
                                ->with('error', 'ID Card design not found');
            }
            $deleteResult = $idCardDesign->delete();
            
            return redirect()->route('admin.id-carddesigns.index')
                            ->with('success', 'ID Card design deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('admin.id-carddesigns.index')
                            ->with('error', 'Error deleting ID Card design: ' . $e->getMessage());
        }
    }

    /**
 * Display the ID card design preview.
 */
public function showDesign($id)
{
    $design = IdCardDesign::findOrFail($id);
    $data['page_title'] = 'ID Card Design Preview';
    $data['design'] = $design;
    
    return view('backend.school_admin.id_card_design.show', $data);
}
   
}