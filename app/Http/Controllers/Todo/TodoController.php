<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskList;
use App\Enums\Prioritas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    /*public function index()
    {
      //dd(Auth()->user());
      $id_user = auth()->user()->id_user;
      if(request('search')) {
        $data = Task::where('id_user', $id_user)->where('judul_task', 'like', '%'.request('search').'%')->get();
      } else {
        $data = Task::where('id_user', $id_user)->orderBy('judul_task', 'asc')->get();
      }
      return view("/dashboard", compact('data'));
    }*/
    public function index()
    {
      $id_user = auth()->user()->id_user;
      $query = Task::where('id_user', $id_user)->with('subtasks');
    if (request('search')) {
      $query->where('judul_task', 'like', '%'.request('search').'%');
    }

    $data = $query->orderBy('judul_task', 'asc')->get();
    //$data = $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")->get();

    return view("/dashboard", compact('data'));
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
     
     
    /*public function store(Request $request)
    {
        //dd($request);
        $request->validate([
          'task'=>'required|min:6|max:25'
        ], [
          'task.required'=>'Task wajib diisi',
          'task.min'=>'Task hanya bisa diisi minimal 6 karakter',
          'task.max'=>'Maksimal task hanya bisa diisi minimal 25 karakter',
        ]);
        
        $task = [
          'id_user'=> Auth()->user()->id_user,
          'judul_task'=>$request->input('task'),
          'keterangan_task'=>$request->input('keterangan')
        ];
        
        Task::create($task);
        //return redirect('/dashboard')->with('sukses', 'task berhasil ditambahkan');
        
        $subtask = [
          'id_task'=> $task->id_task,
          'judul_subtask'=>$request->input('subtask'),
          'keterangan_subtask'=>$request->input('keterangan_subtask')
        ];
        
        TaskList::create($subtask);
        return redirect('/dashboard')->with('sukses', 'task berhasil ditambahkan');
    }*/
    public function store(Request $request) {
    $request->validate([
        'task' => 'required|min:6|max:25'
    ], [
        'task.required' => 'Task wajib diisi',
        'task.min' => 'Task hanya bisa diisi minimal 6 karakter',
        'task.max' => 'Maksimal task hanya bisa diisi minimal 25 karakter',
    ]);

    $task = Task::create([
        'id_user' => Auth::user()->id_user,
        'judul_task' => $request->input('task'),
        'keterangan_task' => $request->input('keterangan'),
        'prioritas' => $request->input('prioritas'),
        'deadline' => $request->input('deadline'),
    ]);

    if ($request->input('subtask')) {
        TaskList::create([
            'id_task' => $task->id_task,
            'judul_subtask' => $request->input('subtask'),
            'keterangan_subtask' => $request->input('keterangan_subtask')
        ]);
    }

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
    public function update(Request $request, string $id_task/*, string $id_subtask*/)
    {
      $request->validate([
          'task'=>'required|min:6|max:25'
        ], [
          'task.required'=>'Task wajib diisi',
          'task.min'=>'Task hanya bisa diisi minimal 6 karakter',
          'task.max'=>'Maksimal task hanya bisa diisi minimal 25 karakter',
        ]);
        
        $task = [
          'judul_task'=>$request->input('task'),
          //'status_task'=>$request->input('status_task')
        ];
        
        Task::where('id_task', $id_task)->update($task);
        
        return redirect()->route('dashboard')->with('sukses', 'data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_task)
    {
      Task::where('id_task', $id_task)->delete();
      
      return redirect()->route('dashboard')->with('sukses', 'data sudah dihapus');
    }
    
    public function updateStatus(Request $request, string $id_task) {
      
      //dd($request->all());
    // Temukan task berdasarkan id
    $task = Task::findOrFail($id_task);
    
    // Perbarui status task dengan nilai dari form
    $task->status_task = $request->input('status_task');
    $task->save();
    
    // Redirect kembali ke dashboard atau kirim respons JSON jika diperlukan
    /*return redirect()->back()->with('sukses', 'Status task telah diperbarui.');*/
      return response()->json([
        'success' => true,
        'new_status' => $task->status_task, // Kirim status baru ke frontend
      ]);
    }
    
    public function updateStatussub(Request $request, string $id_subtask)
    {
      // Validasi data yang dikirim (sesuaikan dengan nilai enum Anda)
     /* $request->validate([
        'status_subtask' => 'required|in:selesai,belum_selesai'
      ]);*/

      $subtask = TaskList::findOrFail($id_subtask);
      $subtask->status_subtask = $request->status_subtask;
      $subtask->save();
      
      return response()->json([
        'success' => true,
        'subtask' => $subtask
      ]);
    }
    
    public function tambahSubtask(Request $request) {
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

    
}