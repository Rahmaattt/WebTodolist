<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Controllers\TodoController;
use App\Enums\Status_subtask;
use Illuminate\Notifications\Notifiable;

class TaskList extends Model
{
  use HasFactory, Notifiable;
    
  protected $table="task_list";
  protected $primaryKey = 'id_subtask';
  public $incrementing = true;
  protected $keyType = 'int';
  
  protected $fillable=[
    'id_task',
    'judul_subtask',
    'keterangan_subtask',
    'status_subtask'
  ];
  
  protected $casts = [
    'status_subtask' => Status_subtask::class,
  ];
  
  public function task(): BelongsTo
    {
      return $this->belongsTo(Task::class, 'id_task', 'id_task');
    }
}
