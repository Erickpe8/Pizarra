<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'team_id',
        'created_by',
        'assigned_to',
        'assigned_at',
        'due_date',
        'estimated_time',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'due_date' => 'date',
            'estimated_time' => 'integer',
        ];
    }

    /**
     * Equipo al que pertenece la tarea.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Usuario que creó la tarea.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Usuario al que está asignada la tarea.
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}