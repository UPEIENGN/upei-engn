<?php

namespace App\Http\Controllers\SocietyMember;

use App\Http\Controllers\Controller;
use App\Models\Society;
use App\Models\SocietyMember;
use Illuminate\Http\Request;

class SocietyMemberRenewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Society $society, SocietyMember $societyMember)
    {
        $this->authorize('update', [SocietyMember::class, $society, $societyMember]);

        $societyMember->renewed_at = now();
        $societyMember->save();

        return back()->with('success', 'Society member membership renewed successfully.');
    }
}
