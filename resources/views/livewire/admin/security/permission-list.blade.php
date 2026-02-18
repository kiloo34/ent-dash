<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <flux:heading size="xl" level="1">Permissions</flux:heading>
            <flux:subheading>Manage fine-grained system permissions.</flux:subheading>
        </div>
        <flux:modal.trigger name="permission-modal">
            <flux:button icon="plus" variant="primary" wire:click="create">Add Permission</flux:button>
        </flux:modal.trigger>
    </div>

    <flux:card>
        <flux:table :paginate="$permissions">
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Guard</flux:table.column>
                <flux:table.column>Created At</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($permissions as $permission)
                    <flux:table.row :key="$permission->id">
                        <flux:table.cell class="font-medium">{{ $permission->name }}</flux:table.cell>
                        <flux:table.cell>{{ $permission->guard_name }}</flux:table.cell>
                        <flux:table.cell>{{ $permission->created_at->format('M d, Y') }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:modal.trigger name="permission-modal">
                                    <flux:button icon="pencil" size="sm" variant="ghost" wire:click="edit({{ $permission->id }})" />
                                </flux:modal.trigger>
                                <flux:button icon="trash" size="sm" variant="ghost" color="red" wire:confirm="Are you sure?" wire:click="delete({{ $permission->id }})" />
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal name="permission-modal" class="md:w-[400px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editing_id ? 'Edit Permission' : 'Add New Permission' }}</flux:heading>
                <flux:subheading>Define the permission identifier.</flux:subheading>
            </div>

            <flux:input label="Permission Name" wire:model="name" placeholder="e.g. users.create" />
            <flux:input label="Guard Name" wire:model="guard_name" />

            <div class="flex gap-2 justify-end">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancel</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary">Save Changes</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
