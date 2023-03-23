<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'completed'
    ];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected $touches = ['project'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function path(): string
    {
        return $this->project->path() . '/tasks/' . $this->id;
    }

    public function complete()
    {
        $this->update([
            'completed' => true
        ]);
    }

    public function incomplete()
    {
        $this->update([
            'completed' => false
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function recordActivity($description)
    {
        //dd($this->project->id);
        $this->activity()->save($this->project->recordActivity($description));
    }
}
