<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreEventRequest;
use App\Http\Requests\Event\UpdateEventRequest;
use App\Models\Event;
use App\Models\Society;
use Inertia\Inertia;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Society $society)
    {
        $this->authorize('viewAny', [Event::class, $society]);

        return Inertia::render('admin/event/Index', [
            'society' => $society,
            'events' => $society->events()->paginate()
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
}
