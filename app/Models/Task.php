<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $incrementing = false;
    use HasFactory;
    protected $fillable = ['title', 'description', 'assigned_to', 'created_by'];
}
