<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['project_id', 'name', 'title', 'deadline', 'is_done'];

    protected $appends = ['title'];

    protected function casts(): array
    {
        return [
            'is_done' => 'boolean',
            'deadline' => 'date',
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getTitleAttribute(): ?string
    {
        return $this->attributes['name'] ?? null;
    }

    public function setTitleAttribute(mixed $value): void
    {
        if ($value !== null) {
            $strValue = trim((string) $value);
            if ($strValue !== '') {
                $this->attributes['name'] = (string) $value;
            }
        }
    }

    public function setDeadlineAttribute(mixed $value): void
    {
        if ($value === '' || $value === null) {
            $this->attributes['deadline'] = null;
        } else {
            $this->attributes['deadline'] = $this->fromDateTime($value);
        }
    }

    public function scopeWhereTitle(Builder $query, mixed $value): Builder
    {
        return $query->where('name', $value);
    }

    public function scopeTitle(Builder $query, mixed $value): Builder
    {
        return $query->where('name', $value);
    }
}
