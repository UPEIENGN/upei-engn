<?php

namespace App\Http\Controllers;

use App\Http\Requests\Society\UpdateSocietyRequest;
use App\Models\Society;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class SocietyController extends Controller
{
    public function home(): Response
    {
        $society = Society::first();

        return Inertia::render('society/Home', [
            'society' => $society,
        ]);
    }

    public function about(): Response
    {
        $society = Society::first();

        return Inertia::render('society/About', [
            'society' => $society,
        ]);
    }

    public function events(): Response
    {
        $society = Society::first();

        return Inertia::render('society/Events', [
            'society' => $society,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Society $society): Response
    {
        $this->authorize('update', $society);

        return Inertia::render('societies/Edit', [
            'society' => $society,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSocietyRequest $request, Society $society): RedirectResponse
    {
        $society->update($request->validated());

        return back()->with('success', 'Society updated successfully.');
    }
}
