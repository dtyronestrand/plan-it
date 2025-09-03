<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Inertia\Inertia;
use Inertia\Response;
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
            'sub_tasks' => 'nullable|array',
            'attachments' => 'nullable|array',
        ]);

        $task = new Task([
            'name' => $validatedData['name'],
            'user_id' => $validatedData['user_id'],
            'calendar_id' => $validatedData['calendar_id']??null,
            'notes' => $validatedData['notes'] ?? null,
            'done' => $validatedData['done'] ?? false,
            'due_date' => $validatedData['due_date'] ?? null,
            'sub_tasks' => $validatedData['sub_tasks'] ?? [],
            'attachments' => $validatedData['attachments'] ?? [],
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
        \Log::info('Update request data:', $request->all());
        \Log::info('Notes field:', ['notes' => $request->notes]);

        $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'calendar_id' => 'required|exists:calendars,id',
            'notes' => 'nullable|string',
            'done' => 'boolean',
            'due_date' => 'nullable|date',
            'sub_tasks' => 'nullable|array',
            'attachments' => 'nullable|array',
        ]);

        $task = Task::findOrFail($id);

        $task->update([
            'name' => $request->name,
            'user_id' => $request->user_id,
            'calendar_id' => $request->calendar_id,
            'notes' => $request->notes ?? null,
            'done' => $request->done ?? false,
            'due_date' => $request->due_date ?? null,
            'sub_tasks' => $request->sub_tasks ?? [],
            'attachments' => $request->attachments ?? [],
        ]);

        return to_route('calendars.show', [
            'user_id' => $request->user()->id,
            'calendar' => Calendar::findOrFail($request->calendar_id)
        ])->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
