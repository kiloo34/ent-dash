<?php

namespace App\Livewire\Admin\Organization;

use App\Models\OrganizationUnit;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;

class UnitList extends Component
{
    use WithPagination;

    public $name;
    public $type;
    public $parent_id;
    public $is_active = true;
    public $editing_id = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:50',
        'parent_id' => 'nullable|exists:app.organization_units,id',
        'is_active' => 'boolean',
    ];

    public function create()
    {
        $this->reset(['name', 'type', 'parent_id', 'is_active', 'editing_id']);
    }

    public function edit(OrganizationUnit $unit)
    {
        $this->editing_id = $unit->id;
        $this->name = $unit->name;
        $this->type = $unit->type;
        $this->parent_id = $unit->parent_id;
        $this->is_active = $unit->is_active;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'parent_id' => $this->parent_id,
            'is_active' => $this->is_active,
        ];

        if ($this->editing_id) {
            OrganizationUnit::find($this->editing_id)->update($data);
        } else {
            OrganizationUnit::create($data);
        }

        $this->reset(['name', 'type', 'parent_id', 'is_active', 'editing_id']);
        // Flux::modal('unit-modal')->close(); // Assuming a modal named unit-modal
    }

    public function delete(OrganizationUnit $unit)
    {
        $unit->delete();
    }

    public function render()
    {
        return view('livewire.admin.organization.unit-list', [
            'units' => OrganizationUnit::with('parent')->latest()->paginate(10),
            'parents' => OrganizationUnit::whereNot('id', $this->editing_id)->get(),
        ])->layout('layouts.app');
    }
}
