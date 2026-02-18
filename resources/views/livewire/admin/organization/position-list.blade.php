<div class="p-6 lg:p-10 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex flex-col gap-1">
            <flux:heading size="xl" level="1">{{ __('Positions') }}</flux:heading>
            <flux:subheading>{{ __('Manage structural positions and levels.') }}</flux:subheading>
        </div>
        
        <div class="flex gap-2">
            <flux:modal.trigger name="position-modal">
                <flux:button variant="primary" icon="plus" wire:click="$set('editing_id', null)">{{ __('Add Position') }}</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <flux:card class="!p-0 overflow-hidden">
        <flux:table :paginate="$positions">
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Level') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($positions as $position)
                    <flux:table.row :key="$position->id">
                        <flux:table.cell>
                            <span class="font-medium text-zinc-700 dark:text-zinc-200">{{ $position->name }}</span>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" variant="ghost" color="zinc">{{ $position->level }}</flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" :color="$position->is_active ? 'green' : 'zinc'" variant="solid">
                                {{ $position->is_active ? __('Active') : __('Inactive') }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell align="end">
                            <flux:modal.trigger name="position-modal">
                                <flux:button variant="ghost" size="xs" icon="pencil" wire:click="edit({{ $position->id }})" />
                            </flux:modal.trigger>
                            
                            <flux:button variant="ghost" size="xs" color="red" icon="trash" 
                                wire:confirm="{{ __('Are you sure you want to delete this position?') }}"
                                wire:click="delete({{ $position->id }})" />
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal name="position-modal" class="md:w-[500px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editing_id ? __('Edit Position') : __('Add Position') }}</flux:heading>
                <flux:subheading>{{ __('Fill in the details below.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <flux:input wire:model="name" label="{{ __('Name') }}" required />
                
                <flux:input wire:model="level" type="number" label="{{ __('Level') }}" placeholder="{{ __('Higher number usually means lower structural level') }}" required />

                <flux:checkbox wire:model="is_active" label="{{ __('Is Active') }}" />
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="primary" class="ml-2">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
