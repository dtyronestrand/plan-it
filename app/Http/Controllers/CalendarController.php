<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\User;
use App\Models\Calendar;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CalendarController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    return Inertia::render('Calendar/Index', [
        'calendars' => Calendar::where('user_id', $request->user()->id)->get()
    ]);
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:7', // Assuming color is a hex code
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $calendar = new Calendar([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
            'is_default' => $request->is_default,
            'is_active' => $request->is_active,
            'user_id' => $request->user()->id,
        ]);

        $calendar->save();

        return to_route('calendars.show', [
            'user_id' => $request->user()->id,
            'calendar' => $calendar->id,
        ])->with('success', 'Calendar created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $user_id, Calendar $calendar = null)
    {
        if (!$calendar) {
            $calendar = Calendar::where('user_id', $user_id)
                ->where('is_default', true)
                ->firstOrFail();
        }

        $this->authorize('view', $calendar);

        return Inertia::render('Calendars/Show', [
            'calendar' => $calendar,
            'tasks' => $calendar->tasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $user_id, Calendar $calendar)
    {
       $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'color' => 'nullable|string|max:7', // Assuming color is a hex code
            'is_default' => 'boolean',
            'is_active' => 'boolean',
        ]);
        
        $this->authorize('update', $calendar);

        $calendar->update($request->only(['name', 'description', 'color', 'is_default', 'is_active']));

        return to_route('calendars.show', [
            'user_id' => $user_id,
            'calendar' => $calendar->id,
        ])->with('success', 'Calendar updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user_id, Calendar $calendar)
    {
        $this->authorize('delete', $calendar);

        $calendar->delete();

        // Redirect to the default calendar after deletion
        $defaultCalendar = Calendar::where('user_id', $user_id)
            ->where('is_default', true)
            ->firstOrFail();

        return redirect()->route('calendars.show', [
            'user_id' => $user_id,
            'calendar' => $defaultCalendar->id,
        ])->with('success', 'Calendar deleted successfully.');
    }
}
