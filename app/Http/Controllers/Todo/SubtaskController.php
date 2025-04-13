<?php

namespace App\Http\Controllers\todo;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskList;
use App\Enums\Prioritas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SubtaskController extends Controller
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
    public function create(Request $request) {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
      $request->validate([
      'id_task' => 'required|exists:task,id_task',
      'judul_subtask' => 'required|string|max:255',
      'keterangan_subtask' => 'nullable|string',
    ]);

    $subtask = TaskList::create([
      'id_task' => $request->id_task,
      'judul_subtask' => $request->judul_subtask,
      'keterangan_subtask' => $request->keterangan_subtask,
      'status_subtask' => 'belum_selesai',
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Subtask berhasil ditambahkan!',
      'subtask' => $subtask
    ]);
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
    public function update(Request $request) {
    $validated = $request->validate([
        'id_task'            => 'required|exists:task,id_task',
        'id_subtask'         => 'required|exists:task_list,id_subtask',
        'judul_subtask'      => 'required|string|max:255',
        'keterangan_subtask' => 'nullable|string',
    ]);

    $subtask = TaskList::findOrFail($validated['id_subtask']);

    if ($subtask->id_task != $validated['id_task']) {
        return response()->json([
            'success' => false,
            'message' => 'Subtask tidak terkait dengan task yang diberikan.'
        ], 422);
    }

    // Update data subtask (tanpa mengubah field status_subtask)
    $subtask->judul_subtask = $validated['judul_subtask'];
    $subtask->keterangan_subtask = $validated['keterangan_subtask'] ?? null;
    $subtask->save();

    return response()->json([
        'success' => true,
        'subtask' => $subtask
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request) {
    $validated = $request->validate([
        'id_subtask' => 'required|exists:task_list,id_subtask',
    ]);

    $subtask = TaskList::findOrFail($validated['id_subtask']);
    $idTask = $subtask->id_task;
    $subtask->delete();

    return response()->json([
        'success'    => true,
        'id_subtask' => $validated['id_subtask'],
        'id_task'    => $idTask,
    ]);
}
}
