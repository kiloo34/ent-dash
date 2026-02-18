<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityLog extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.activity-log', [
            'activities' => Activity::with('causer')->latest()->paginate(10),
        ])->layout('layouts.app');
    }
}
