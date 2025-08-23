<?php

namespace App\Http\Controllers;

use App\Http\Requests\SocietyMember\StoreSocietyMemberRequest;
use App\Http\Requests\SocietyMember\UpdateSocietyMemberRequest;
use App\Models\SocietyMember;

class SocietyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSocietyMemberRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SocietyMember $societyMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocietyMember $societyMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocietyMemberRequest $request, SocietyMember $societyMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocietyMember $societyMember)
    {
        //
    }
}
