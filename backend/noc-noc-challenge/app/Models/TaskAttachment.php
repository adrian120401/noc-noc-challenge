<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAttachment extends Model
{
    public $incrementing = false;
    use HasFactory;

    protected $fillable = ['id', 'task_id', 'user_id' ,'filename', 'filepath'];

}
