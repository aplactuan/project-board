<?php

namespace App\Models\Traits;

use App\Models\Activity;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    public $old = [];

    public function recordActivity($description)
    {
        return $this->activities()->create([
            'project_id' => $this->id,
            'description' => $description,
            'changes' => $this->changes(),
        ]);
    }

    /**
     * @return array
     */
    public function changes()
    {
        if ($this->wasChanged()) {
            return [
                'before' => Arr::except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after' => Arr::except($this->getChanges(), 'updated_at')
            ];
        }
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}
