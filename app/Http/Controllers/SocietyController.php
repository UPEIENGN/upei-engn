<?php

namespace App\Http\Controllers;

use App\Http\Requests\Society\UpdateSocietyRequest;
use App\Models\Product;
use App\Models\Society;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'executives' => $society->executives,
        ]);
    }

    public function events(Request $request): Response
    {
        $society = Society::first();

        return Inertia::render('society/Events', [
            'society' => $society,
            'calendar' => $this->calendar($request, $society),
        ]);
    }

    public function store(): Response
    {
        $society = Society::first();

        return Inertia::render('society/Store', [
            'society' => $society,
            'products' => $society->products->load(['image']),
        ]);
    }

    public function showProduct(Product $product)
    {
        $society = Society::first();

        return Inertia::render('society/product/Show', [
            'society' => $society,
            'product' => $product->load(['image']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Society $society): Response
    {
        $this->authorize('update', $society);

        return Inertia::render('admin/society/Edit', [
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

    private function calendar(Request $request, Society $society)
    {
        // Get requested month or default to now
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $monthCarbon = Carbon::parse($month.'-01');

        // Pull all events for this society within this calendar grid
        $monthStart = $monthCarbon->copy()->startOfMonth();
        $monthEnd = $monthCarbon->copy()->endOfMonth();

        // Align to full weeks
        $calendarStart = $monthStart->copy()->startOfWeek(CarbonInterface::SUNDAY);
        $calendarEnd = $monthEnd->copy()->endOfWeek(CarbonInterface::SATURDAY);

        // Query events for this span
        $events = $society->events()
            ->whereBetween('start', [$calendarStart->toDateString(), $calendarEnd->toDateString()])
            ->get();

        // Build grid
        $days = [];
        $cursor = $calendarStart->copy();

        while ($cursor->lte($calendarEnd)) {
            $dateStr = $cursor->format('Y-m-d');

            $days[] = [
                'date' => $dateStr,
                'isCurrentMonth' => $cursor->isSameMonth($monthCarbon),
                'isToday' => $cursor->isToday(),
                'events' => $events->filter(fn ($event) => Carbon::parse($event->start)->toDateString() === $dateStr)->values(),
            ];

            $cursor->addDay();
        }

        return $days;
    }
}
