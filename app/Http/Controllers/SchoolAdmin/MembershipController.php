<?php




namespace App\Http\Controllers\SchoolAdmin;




use App\Models\Membership;
use App\Models\MembershipHead;
use App\Models\State;
use App\Models\District;
use App\Models\Municipality;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;




class MembershipController extends Controller
{
    public function index()
    {
        $page_title = "List Members";
        $members = Membership::with('membershiphead')->get();
        return view('backend.school_admin.membership.index', compact('page_title', 'members'));
    }




    public function create()
    {
        $page_title = "Create Member";
        $membershipHeads = MembershipHead::where('is_active', 1)->get();




        // Fetch the last member's membership number
        $lastMember = Membership::orderBy('membershipnumber', 'desc')->first();




        if ($lastMember) {
            $lastMembershipNumber = (int) str_replace('MEM-', '', $lastMember->membershipnumber);
            $nextMembershipNumber = 'MEM-' . ($lastMembershipNumber + 1); // Increment by 1
        } else {
            // If no member exists, start from 'MEM-100001'
            $nextMembershipNumber = 'MEM-100001';
        }




        // Get all states for dropdown
        $states = State::orderBy('name')->get();
       
        // Get user's location information (if available)
        $user = Auth::user();
        $adminStateId = $user->state_id ?? null;
        $adminDistrictId = $user->district_id ?? null;
        $adminMunicipalityId = $user->municipality_id ?? null;




        return view('backend.school_admin.membership.create', compact(
            'page_title',
            'membershipHeads',
            'nextMembershipNumber',
            'states',
            'adminStateId',
            'adminDistrictId',
            'adminMunicipalityId'
        ));
    }




    public function store(Request $request)
    {
        $request->validate([
            'memberhead_id' => 'required|exists:membershiphead,id',
            'fullname' => 'required|string|max:255',
            'membershipdate' => 'required|date',
            'mobile_number' => 'required|string|size:10|unique:members,mobile_number',
            'email' => 'required|email|unique:members,email',
            'state_id' => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
            'municipality_id' => 'required|exists:municipalities,id',
            'ward_id' => 'required',
            'tole' => 'required|string|max:255',
        ]);




        // Get location names for saving
        $state = State::find($request->state_id);
        $district = District::find($request->district_id);
        $municipality = Municipality::find($request->municipality_id);




        // Create the member
        Membership::create([
            'memberhead_id' => $request->memberhead_id,
            'fullname' => $request->fullname,
            'membershipdate' => $request->membershipdate,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'state_id' => $request->state_id,
            'district_id' => $request->district_id,
            'municipality_id' => $request->municipality_id,
            'ward_id' => $request->ward_id,
            'province' => $state->name,
            'district' => $district->name,
            'locallevel' => $municipality->name,
            'ward' => $request->ward_id,
            'tole' => $request->tole,
            'membershipnumber' => $request->membershipnumber,
        ]);




        return redirect()->route('admin.members.index')->with('success', 'Member created successfully!');
    }




    public function edit(Membership $member)
    {
        $page_title = "Edit Member";
        $membershipHeads = MembershipHead::where('is_active', 1)->get();
       
        // Get all states for dropdown
        $states = State::orderBy('name')->get();
       
        // Set selected location values
        $adminStateId = $member->state_id;
        $adminDistrictId = $member->district_id;
        $adminMunicipalityId = $member->municipality_id;
       
        return view('backend.school_admin.membership.update', compact(
            'page_title',
            'member',
            'membershipHeads',
            'states',
            'adminStateId',
            'adminDistrictId',
            'adminMunicipalityId'
        ));
    }




    public function update(Request $request, Membership $member)
    {
        $request->validate([
            'memberhead_id' => 'required|exists:membershiphead,id',
            'fullname' => 'required|string|max:255',
            'membershipdate' => 'required|date',
            'membershipnumber' => 'required|string|unique:members,membershipnumber,' . $member->id,
            'mobile_number' => 'required|string|size:10|unique:members,mobile_number,' . $member->id,
            'email' => 'required|email|unique:members,email,' . $member->id,
            'state_id' => 'required|exists:states,id',
            'district_id' => 'required|exists:districts,id',
            'municipality_id' => 'required|exists:municipalities,id',
            'ward_id' => 'required',
            'tole' => 'required|string|max:255',
        ]);




        // Get location names for saving
        $state = State::find($request->state_id);
        $district = District::find($request->district_id);
        $municipality = Municipality::find($request->municipality_id);
       
        // Update member data
        $updateData = $request->all();
        $updateData['province'] = $state->name;
        $updateData['district'] = $district->name;
        $updateData['locallevel'] = $municipality->name;
        $updateData['ward'] = $request->ward_id;
       
        $member->update($updateData);




        return redirect()->route('admin.members.index')->with('success', 'Member updated successfully!');
    }




    public function destroy(Membership $member)
    {
        $member->delete();
        return redirect()->route('admin.members.index')->with('success', 'Member deleted successfully!');
    }
   
    // AJAX methods for location dropdowns
   
    /**
     * Get districts by state ID
     *
     * @param int $stateId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistrictsByState($stateId)
    {
        $districts = District::where('province_id', $stateId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
           
        return response()->json($districts);
    }




    /**
     * Get municipalities by district ID
     *
     * @param int $districtId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMunicipalitiesByDistrict($districtId)
    {
        $municipalities = Municipality::where('district_id', $districtId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
           
        return response()->json($municipalities);
    }




    /**
     * Get wards by municipality ID
     *
     * @param int $municipalityId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWardsByMunicipality($municipalityId)
    {
        $municipality = Municipality::find($municipalityId);
       
        if (!$municipality) {
            return response()->json([]);
        }
       
        // Assuming wards is stored as a JSON array in the database
        $wards = json_decode($municipality->wards, true);
       
        return response()->json($wards ?? []);
    }
}
