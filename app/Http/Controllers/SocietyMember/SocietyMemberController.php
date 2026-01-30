<?php

namespace App\Http\Controllers\SocietyMember;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocietyMember\StoreSocietyMemberRequest;
use App\Http\Requests\SocietyMember\UpdateSocietyMemberRequest;
use App\Models\Society;
use App\Models\SocietyMember;
use App\SocietyMemberRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SocietyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Society $society)
    {
        $this->authorize('viewAny', [SocietyMember::class, $society]);

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'created_at');
        $desc = $request->boolean('desc', true);

        $members = $society->members()
            ->where('name', 'like', "%$search%")
            ->orderBy($sort, $desc ? 'desc' : 'asc')
            ->paginate($perPage);

        return Inertia::render('admin/society-member/Index', [
            'society' => $society,
            'members' => $members,
            'executives' => $society->executives->load(['image']),
            'allMembers' => $society->members->load(['image']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Society $society)
    {
        $this->authorize('create', [SocietyMember::class, $society]);

        return Inertia::render('admin/society-member/Create', [
            'society' => $society,
            'roles' => SocietyMemberRole::asSelectArray(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocietyMemberRequest $request, Society $society)
    {
        $societyMember = $society->members()->create(
            $request->safe()->except('image')
        );

        if ($request->get('paid_membership')) {
            $societyMember->renewed_at = now();
            $societyMember->save();
        }

        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');

            $path = $uploadedFile->store('society-members', 'public');

            $societyMember->image()->create([
                'name' => $uploadedFile->hashName(),
                'original_name' => $uploadedFile->getClientOriginalName(),
                'path' => $path,
                'disk' => 'public',
                'size' => $uploadedFile->getSize(),
            ]);
        }

        return redirect()->route('admin.societies.society-members.index', $society)
            ->with('success', 'Society member created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Society $society, SocietyMember $societyMember)
    {
        $this->authorize('update', [SocietyMember::class, $society, $societyMember]);

        return Inertia::render('admin/society-member/Edit', [
            'society' => $society,
            'member' => $societyMember->load(['image']),
            'roles' => SocietyMemberRole::asSelectArray(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocietyMemberRequest $request, Society $society, SocietyMember $societyMember)
    {
        $societyMember->update(
            $request->safe()->except('image')
        );

        if ($request->hasFile('image')) {
            // Remove old image if it exists
            if ($societyMember->image) {
                Storage::disk($societyMember->image->disk)->delete($societyMember->image->path);

                $societyMember->image->delete();
            }

            $uploadedFile = $request->file('image');
            $path = $uploadedFile->store('society-members', 'public');

            $societyMember->image()->create([
                'name' => $uploadedFile->hashName(),
                'original_name' => $uploadedFile->getClientOriginalName(),
                'path' => $path,
                'disk' => 'public',
                'size' => $uploadedFile->getSize(),
            ]);
        }

        return redirect()->route('admin.societies.society-members.index', $society)
            ->with('success', 'Society member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Society $society, SocietyMember $societyMember)
    {
        $this->authorize('delete', [SocietyMember::class, $society, $societyMember]);

        $societyMember->delete();

        return back()->with('success', 'Society member deleted successfully.');
    }
}
