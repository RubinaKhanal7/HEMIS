<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Models\MembershipHead;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MembershipHeadController extends Controller
{
    public function index()
    {
        $page_title = "List Membership Heads";
        $membershiphead = MembershipHead::all();
        return view('backend.school_admin.membershiphead.index', compact('page_title','membershiphead'));
    }

    public function create()
{
    $page_title = "Create Membership Head";
    return view('backend.school_admin.membershiphead.create', compact('page_title'));
}

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        MembershipHead::create($request->all());

        return redirect()->route('admin.membershiphead.index')->with('success', 'Membership Head created successfully!');
    }

    public function edit(MembershipHead $membershiphead)
{
    $page_title = "Edit Membership Head";
    // Return the edit view, not the index view
    return view('backend.school_admin.membershiphead.update', compact('page_title', 'membershiphead'));
}

    public function update(Request $request, MembershipHead $membershiphead)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $membershiphead->update($request->all());

        return redirect()->route('admin.membershiphead.index')->with('success', 'Membership Head updated successfully!');
    }

    public function destroy(MembershipHead $membershiphead)
    {
        $membershiphead->delete();
        return redirect()->route('admin.membershiphead.index')->with('success', 'Membership Head deleted successfully!');
    }
}
