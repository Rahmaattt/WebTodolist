<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskList;
use App\Enums\Prioritas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TodoController extends Controller {
  
  public function index(Request $request) {
    $id_user = auth()->user()->id_user;
    $query = Task::where('id_user', $id_user)->with('subtasks');
    
    if ($request->has('search')) {
      $query->where('judul_task', 'like', '%'.$request->search.'%');
    }
    
    if ($request->has('priority') && $request->priority !== "all" && $request->priority !== "") {
      $query->where('priority', $request->priority);
    }
    
    $data = $query->orderBy('judul_task', 'asc')->get();
    
    if ($request->ajax()) {
        return view('partials.dashboard_tasks', compact('data'))->render();
    }
    
    $belumSelesai = Task::where('status_task', 'belum_selesai')->where('id_user', $id_user)->count();
    $selesai = Task::where('status_task', 'selesai')->where('id_user', $id_user)->count();
    $terlambat = Task::where('status_task', 'terlambat')->where('id_user', $id_user)->count();
    
    return view("dashboard", compact('data', 'belumSelesai', 'selesai', 'terlambat'));
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
     
     
    public function store(Request $request) {
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) {
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_task) {
    }
    
    
    public function updateStatus(Request $request, string $id_task) {
      
    $task = Task::findOrFail($id_task);
    
    $task->status_task = $request->input('status_task');
    $task->save();
    
      return response()->json([
        'success' => true,
        'new_status' => $task->status_task,
      ]);
    }
    
    public function updateStatussub(Request $request, string $id_subtask) {

      $subtask = TaskList::findOrFail($id_subtask);
      $subtask->status_subtask = $request->status_subtask;
      $subtask->save();
      
      return response()->json([
        'success' => true,
        'subtask' => $subtask
      ]);
    }

public function updateSubtask(Request $request) {
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

    $subtask->judul_subtask = $validated['judul_subtask'];
    $subtask->keterangan_subtask = $validated['keterangan_subtask'] ?? null;
    $subtask->save();

    return response()->json([
        'success' => true,
        'subtask' => $subtask
    ]);
}


}