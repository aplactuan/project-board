<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $old = [];

    public function path()
    {
        return '/projects/' . $this->id;
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function recordActivity($description)
    {
        return $this->activities()->create([
            'description' => $description,
            'changes' => $this->changes($description)
        ]);
    }

    /**
     * @return array
     */
    public function changes($description)
    {
        if ($description === 'updated') {
            return [
                'before' => array_diff($this->old, $this->getAttributes()),
                'after' => array_diff($this->getAttributes(), $this->old)
            ];
        }
    }
}
