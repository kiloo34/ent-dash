<?php

namespace App\Livewire\Admin\Security;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;
use Livewire\WithPagination;

class RoleList extends Component
{
    use WithPagination;

    public $name;
    public $guard_name = 'web';
    public $selected_permissions = [];
    public $editing_id = null;

    protected $rules = [
        'name' => 'required|string|max:255|unique:roles,name',
        'guard_name' => 'required|string|max:255',
    ];

    public function create()
    {
        $this->reset(['name', 'guard_name', 'selected_permissions', 'editing_id']);
    }

    public function edit(Role $role)
    {
        $this->editing_id = $role->id;
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
        $this->selected_permissions = $role->permissions->pluck('name')->toArray();
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->editing_id) {
            $rules['name'] .= ',' . $this->editing_id;
        }

        $this->validate($rules);

        if ($this->editing_id) {
            $role = Role::findById($this->editing_id, $this->guard_name);
            $role->update(['name' => $this->name, 'guard_name' => $this->guard_name]);
        } else {
            $role = Role::create(['name' => $this->name, 'guard_name' => $this->guard_name]);
        }

        $role->syncPermissions($this->selected_permissions);

        $this->reset(['name', 'guard_name', 'selected_permissions', 'editing_id']);
    }

    public function delete(Role $role)
    {
        $role->delete();
    }

    public function render()
    {
        return view('livewire.admin.security.role-list', [
            'roles' => Role::with('permissions')->latest()->paginate(10),
            'permissions' => Permission::all(),
        ])->layout('layouts.app');
    }
}
