<?php

namespace App\Models\Traits;

use Illuminate\Support\Arr;

trait RecordsActivity
{
    public function recordActivity($description)
    {
        return $this->activities()->create([
            'project_id' => $this->project_id,
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
}
