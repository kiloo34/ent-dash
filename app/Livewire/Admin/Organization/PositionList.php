<?php

namespace App\Livewire\Admin\Organization;

use App\Models\Position;
use Livewire\Component;
use Livewire\WithPagination;

class PositionList extends Component
{
    use WithPagination;

    public $name;
    public $level;
    public $is_active = true;
    public $editing_id = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'level' => 'required|integer|min:1',
        'is_active' => 'boolean',
    ];

    public function edit(Position $position)
    {
        $this->editing_id = $position->id;
        $this->name = $position->name;
        $this->level = $position->level;
        $this->is_active = $position->is_active;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'level' => $this->level,
            'is_active' => $this->is_active,
        ];

        if ($this->editing_id) {
            Position::find($this->editing_id)->update($data);
        } else {
            Position::create($data);
        }

        $this->reset(['name', 'level', 'is_active', 'editing_id']);
    }

    public function delete(Position $position)
    {
        $position->delete();
    }

    public function render()
    {
        return view('livewire.admin.organization.position-list', [
            'positions' => Position::latest()->paginate(10),
        ])->layout('layouts.app');
    }
}
