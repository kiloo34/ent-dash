<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <flux:heading size="xl" level="1">Roles</flux:heading>
            <flux:subheading>Manage system roles and their permissions.</flux:subheading>
        </div>
        <flux:modal.trigger name="role-modal">
            <flux:button icon="plus" variant="primary" wire:click="create">Add Role</flux:button>
        </flux:modal.trigger>
    </div>

    <flux:card>
        <flux:table :paginate="$roles">
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Guard</flux:table.column>
                <flux:table.column>Permissions</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($roles as $role)
                    <flux:table.row :key="$role->id">
                        <flux:table.cell class="font-medium">{{ $role->name }}</flux:table.cell>
                        <flux:table.cell>{{ $role->guard_name }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex flex-wrap gap-1">
                                @foreach ($role->permissions as $permission)
                                    <flux:badge size="sm" color="zinc">{{ $permission->name }}</flux:badge>
                                @endforeach
                            </div>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:modal.trigger name="role-modal">
                                    <flux:button icon="pencil" size="sm" variant="ghost" wire:click="edit({{ $role->id }})" />
                                </flux:modal.trigger>
                                <flux:button icon="trash" size="sm" variant="ghost" color="red" wire:confirm="Are you sure?" wire:click="delete({{ $role->id }})" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal name="role-modal" class="md:w-[600px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editing_id ? 'Edit Role' : 'Add New Role' }}</flux:heading>
                <flux:subheading>Define role name and assign permissions.</flux:subheading>
            </div>

            <flux:input label="Role Name" wire:model="name" placeholder="e.g. manager" />
            <flux:input label="Guard Name" wire:model="guard_name" />

            <div>
                <flux:label>Permissions</flux:label>
                <div class="grid grid-cols-2 gap-2 mt-2 h-48 overflow-y-auto p-2 border border-zinc-200 dark:border-zinc-700 rounded-lg">
                    @foreach ($permissions as $permission)
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" wire:model="selected_permissions" value="{{ $permission->name }}" class="rounded border-zinc-300 dark:border-zinc-600">
                            {{ $permission->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Save Changes</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
