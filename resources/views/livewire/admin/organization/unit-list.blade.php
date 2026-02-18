<div class="p-6 lg:p-10 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex flex-col gap-1">
            <flux:heading size="xl" level="1">{{ __('Organization Units') }}</flux:heading>
            <flux:subheading>{{ __('Manage departments, divisions, and branches.') }}</flux:subheading>
        </div>
        
        <div class="flex gap-2">
            <flux:modal.trigger name="unit-modal">
                <flux:button variant="primary" icon="plus" wire:click="create">{{ __('Add Unit') }}</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <flux:card class="!p-0 overflow-hidden">
        <flux:table :paginate="$units">
            <flux:table.columns>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Type') }}</flux:table.column>
                <flux:table.column>{{ __('Parent Unit') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($units as $unit)
                    <flux:table.row :key="$unit->id">
                        <flux:table.cell>
                            <span class="font-medium text-zinc-700 dark:text-zinc-200">{{ $unit->name }}</span>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" variant="outline">{{ $unit->type }}</flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="text-sm text-zinc-500">{{ $unit->parent->name ?? '-' }}</span>
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" :color="$unit->is_active ? 'green' : 'zinc'" variant="solid">
                                {{ $unit->is_active ? __('Active') : __('Inactive') }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell align="end">
                            <flux:modal.trigger name="unit-modal">
                                <flux:button variant="ghost" size="xs" icon="pencil" wire:click="edit({{ $unit->id }})" />
                            </flux:modal.trigger>
                            
                            <flux:button variant="ghost" size="xs" color="red" icon="trash" 
                                wire:confirm="{{ __('Are you sure you want to delete this unit?') }}"
                                wire:click="delete({{ $unit->id }})" />
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal name="unit-modal" class="md:w-[500px]">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editing_id ? __('Edit Unit') : __('Add Unit') }}</flux:heading>
                <flux:subheading>{{ __('Fill in the details below.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                <flux:input wire:model="name" label="{{ __('Name') }}" required />
                
                <flux:input wire:model="type" label="{{ __('Type') }}" placeholder="{{ __('e.g. Branch, Division') }}" required />

                <flux:select wire:model="parent_id" label="{{ __('Parent Unit') }}">
                    <option value="">{{ __('None') }}</option>
                    @foreach($parents as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </flux:select>

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
