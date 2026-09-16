<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'owner_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    // User yang memiliki project
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
