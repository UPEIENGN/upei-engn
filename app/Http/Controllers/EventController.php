<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use App\Models\Society;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Society $society)
    {
        $this->authorize('viewAny', [Event::class, $society]);

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', "");
        $sort = $request->input('sort', "created_at");
        $desc = $request->boolean('desc', false);

        $events = $society->events()
            ->where('title', 'like', "%$search%")
            ->orderBy($sort, $desc ? "desc" : "asc")
            ->paginate($perPage);

        return Inertia::render('admin/event/Index', [
            'society' => $society,
            'events' => $events,
            'upcoming' => $society->events()->orderBy('start', 'asc')->limit(3)->get(),
            'calendar' => $this->calendar($request, $society),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Society $society)
    {
        $this->authorize('create', [Event::class, $society]);

        return Inertia::render('admin/event/Create', [
            'society' => $society,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request, Society $society)
    {
        $this->authorize('create', [Event::class, $society]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Society $society, Event $event)
    {
        $this->authorize('update', [Event::class, $society, $event]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Society $society, Event $event)
    {
        $this->authorize('update', [Event::class, $society, $event]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Society $society, Event $event)
    {
        $this->authorize('delete', [Event::class, $society, $event]);
    }

    private function calendar(Request $request, Society $society)
    {
        // Get requested month or default to now
        $month = $request->input('month', Carbon::now()->format('Y-m'));
        $monthCarbon = Carbon::parse($month . '-01');

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
                'events' => $events->filter(fn ($event) => Carbon::parse($event->start)->toDateString() === $dateStr)->values()
            ];

            $cursor->addDay();
        }


        return $days;
    }
}
