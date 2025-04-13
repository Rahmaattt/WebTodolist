<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Http\Controllers\TodoController;
use App\Enums\Prioritas;
use App\Enums\Status_task;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory, Notifiable;
    
    protected $table="task";
    protected $primaryKey = 'id_task';
    public $incrementing = true;
    protected $keyType = 'int';

    
    protected $fillable=[
      'id_user',
      'judul_task',
      'keterangan_task',
      'status_task',
      'prioritas',
      'deadline'
    ];
    
    protected $casts = [
      'deadline' => 'datetime',
      'prioritas' => Prioritas::class,
      'status_task' => Status_task::class,
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    
    public function subtasks(): HasMany
    {
      return $this->hasMany(TaskList::class, 'id_task', 'id_task');
    }
    
    
  // **Accessor untuk menampilkan deadline dalam format yang lebih baik**
    public function getDeadlineFormattedAttribute()
    {
        return $this->deadline ? $this->deadline->format('d M Y, H:i') : null;
    }

    // **Mutator untuk memastikan deadline tersimpan dalam format yang benar**
    public function setDeadlineAttribute($value)
    {
        $this->attributes['deadline'] = Carbon::parse($value);
    }
}
