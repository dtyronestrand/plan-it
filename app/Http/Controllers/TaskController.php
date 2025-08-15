<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Models\Calendar;

class TaskController extends Controller
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
     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'calendar_id' => 'required|exists:calendars,id',
            'notes' => 'nullable|string',
            'done' => 'boolean',
            'due_date' => 'nullable|date',
        ]);

        $task = new Task([
            'name' => $validatedData['name'],
            'user_id' => $validatedData['user_id'],
            'calendar_id' => $validatedData['calendar_id'],
            'notes' => $validatedData['notes'] ?? null,
            'done' => $validatedData['done'] ?? false,
            'due_date' => $validatedData['due_date'] ?? null,
        ]);

        $task->save();


        return to_route('calendars.show', [
            'user_id' => $request->user()->id,
            'calendar' => Calendar::findOrFail($validatedData['calendar_id'])
        ])->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
