<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Notifikasi;
use App\Models\Task;

class MailController extends Controller
{
    public function sendEmail($id_task) {
        $task = Task::with('user')->find($id_task);   
        if (!$task) {
            return "Task tidak ditemukan.";
        }
        
        $data = [
          'subject'         => 'Notifikasi Task: ' . $task->judul_task,
          'name'            => $task->user->name,
          'message'         => 'Task "' . $task->judul_task . '" dengan keterangan: ' . $task->keterangan_task . ' akan segera mencapai deadline pada ' . $task->deadline->format('d M Y, H:i'),
          'id_task'         => $task->id_task,
          'keterangan_task' => $task->keterangan_task,
          'deadline'        => $task->deadline->format('d M Y, H:i'),
        ];
        
        Mail::to($task->user->email)->send(new Notifikasi($data));
        
        return "Email notifikasi telah dikirim.";
    }
}