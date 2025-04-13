<?php

namespace App\Http\Controllers\todo;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskList;
use App\Enums\Prioritas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
    $validated = $request->validate([
        'task' => 'required|min:6|max:25'
    ], [
        'task.required' => 'Task wajib diisi',
        'task.min' => 'Task hanya bisa diisi minimal 6 karakter',
        'task.max' => 'Maksimal task hanya bisa diisi maksimal 25 karakter',
    ]);

    $task = Task::create([
      'id_user' => Auth::user()->id_user,
      'judul_task' => $request->input('task'),
      'keterangan_task' => $request->input('keterangan'),
      'prioritas' => $request->input('prioritas'),
      'deadline' => $request->input('deadline'),
      'status_task' => \App\Enums\Status_task::BELUM_SELESAI,
    ]);

    $subtask = null;
    if ($request->filled('subtask')) {
        $subtask = TaskList::create([
            'id_task' => $task->id_task,
            'judul_subtask' => $request->input('subtask'),
            'keterangan_subtask' => $request->input('keterangan_subtask')
        ]);
    }

    return response()->json([
      'success' => true,
      'message' => 'Subtask berhasil ditambahkan!',
      'task' => $task,
      'subtask' => $subtask,
    ]);

    return redirect('/dashboard')->with('sukses', 'Task berhasil ditambahkan');
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
    public function update(Request $request, string $id_task) {
    $request->validate([
        'task' => 'required|min:6|max:25',
        'keterangan' => 'nullable|max:100',
        'deadline' => 'nullable|date',
    ], [
        'task.required' => 'Task wajib diisi',
        'task.min' => 'Task hanya bisa diisi minimal 6 karakter',
        'task.max' => 'Maksimal task hanya bisa diisi 25 karakter',
    ]);

    $task = Task::where('id_task', $id_task)->first();
    if (!$task) {
        return response()->json(['success' => false, 'message' => 'Task tidak ditemukan']);
    }

    $changes = [];
    if ($task->judul_task !== $request->task) $changes[] = "Judul task";
    if ($task->keterangan_task !== $request->keterangan) $changes[] = "Keterangan task";
    if ($task->deadline !== $request->deadline) $changes[] = "Deadline";

    if (empty($changes)) {
        return response()->json(['success' => false, 'message' => 'Tidak ada perubahan']);
    }

    $task->update([
        'judul_task' => $request->task,
        'keterangan_task' => $request->keterangan,
        'deadline' => $request->deadline,
        'status_task' => $request->status_task,
    ]);

    return response()->json([
        'success' => true,
        'task' => $task,
        'message' => count($changes) === 3 ? "Task berhasil diperbarui" : implode(", ", $changes) . " berhasil diperbarui"
    ]);
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id_task) {
    Task::where('id_task', $id_task)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task berhasil dihapus'
        ]);
  }
}
