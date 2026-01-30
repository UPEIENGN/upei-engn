<?php

namespace App\Http\Controllers\SocietyMember;

use App\Http\Controllers\Controller;
use App\Models\Society;
use App\Models\SocietyMember;
use Illuminate\Http\Request;

class ExecutiveMemberController extends Controller
{
    public function __invoke(Request $request, Society $society)
    {
        $this->authorize('reorderExecutives', [SocietyMember::class, $society]);

        $validated = $request->validate([
            'executives' => 'present|array',
            'executives.*.id' => 'required|exists:society_members,id',
            'executives.*.order' => 'required|integer|min:1',
        ]);

        $submittedIds = collect($validated['executives'])->pluck('id')->toArray();

        foreach ($validated['executives'] as $item) {
            $society->members()
                ->where('id', $item['id'])
                ->update([
                    'executive_display_order' => $item['order'],
                ]);
        }

        $society->members()
            ->whereNotNull('executive_display_order')
            ->whereNotIn('id', $submittedIds)
            ->update([
                'executive_display_order' => null,
            ]);

        return back();
    }
}
