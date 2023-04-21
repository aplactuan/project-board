<?php

namespace App\Models\Traits;

use Illuminate\Support\Arr;

trait RecordsActivity
{
    public function recordActivity($description)
    {
        $this->activities()->create([
            'description' => $description,
            'changes' => $this->changes(),
        ]);
    }

    public function recordTaskActivity($description)
    {
        $this->activities()->save($this->project->recordActivity($description));
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
}
