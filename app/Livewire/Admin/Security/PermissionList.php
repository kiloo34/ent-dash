<?php

namespace App\Livewire\Admin\Security;

use Spatie\Permission\Models\Permission;
use Livewire\Component;
use Livewire\WithPagination;

class PermissionList extends Component
{
    use WithPagination;

    public $name;
    public $guard_name = 'web';
    public $editing_id = null;

    protected $rules = [
        'name' => 'required|string|max:255|unique:permissions,name',
        'guard_name' => 'required|string|max:255',
    ];

    public function create()
    {
        $this->reset(['name', 'guard_name', 'editing_id']);
    }

    public function edit(Permission $permission)
    {
        $this->editing_id = $permission->id;
        $this->name = $permission->name;
        $this->guard_name = $permission->guard_name;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->editing_id) {
            $rules['name'] .= ',' . $this->editing_id;
        }

        $this->validate($rules);

        if ($this->editing_id) {
            Permission::find($this->editing_id)->update([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);
        } else {
            Permission::create([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
            ]);
        }

        $this->reset(['name', 'guard_name', 'editing_id']);
    }

    public function delete(Permission $permission)
    {
        $permission->delete();
    }

    public function render()
    {
        return view('livewire.admin.security.permission-list', [
            'permissions' => Permission::latest()->paginate(15),
        ])->layout('layouts.app');
    }
}
