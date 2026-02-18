<div class="p-6 lg:p-10 space-y-8">
    <div class="flex flex-col gap-1 mb-6">
        <flux:heading size="xl" level="1">{{ __('Activity Logs') }}</flux:heading>
        <flux:subheading>{{ __('Monitor all changes and activities within the system.') }}</flux:subheading>
    </div>

    <flux:card class="!p-0 overflow-hidden">
        <flux:table :paginate="$activities">
            <flux:table.columns>
                <flux:table.column>{{ __('Type') }}</flux:table.column>
                <flux:table.column>{{ __('Description') }}</flux:table.column>
                <flux:table.column>{{ __('Subject') }}</flux:table.column>
                <flux:table.column>{{ __('Causer') }}</flux:table.column>
                <flux:table.column>{{ __('Details') }}</flux:table.column>
                <flux:table.column>{{ __('Date') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($activities as $activity)
                    <flux:table.row :key="$activity->id">
                        <flux:table.cell>
                            <flux:badge size="sm" color="zinc" variant="outline">
                                {{ $activity->log_name ?? 'default' }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="font-medium text-zinc-700 dark:text-zinc-200">{{ $activity->description }}</span>
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($activity->subject)
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold uppercase text-zinc-400">{{ class_basename($activity->subject_type) }}</span>
                                    <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300">ID: {{ $activity->subject_id }}</span>
                                </div>
                            @else
                                <flux:text variant="subtle italic">{{ __('System') }}</flux:text>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($activity->causer)
                                <div class="flex items-center gap-2">
                                    <flux:avatar size="xs" :name="$activity->causer->name" class="bg-indigo-100 text-indigo-700" />
                                    <span class="text-sm font-medium">{{ $activity->causer->name }}</span>
                                </div>
                            @else
                                <flux:text variant="subtle italic">{{ __('Guest/System') }}</flux:text>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            @if($activity->changes() && count($activity->changes()) > 0)
                                <flux:modal.trigger name="details-{{ $activity->id }}">
                                    <flux:button size="xs" variant="ghost" icon="eye"></flux:button>
                                </flux:modal.trigger>

                                <flux:modal name="details-{{ $activity->id }}" class="md:w-[600px]">
                                    <div class="space-y-6">
                                        <flux:header>
                                            <flux:heading size="lg">{{ __('Activity Details') }}</flux:heading>
                                            <flux:subheading>{{ __('Detailed property changes for this event.') }}</flux:subheading>
                                        </flux:header>

                                        <div class="relative">
                                            <pre class="p-4 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-xs overflow-auto max-h-96 text-zinc-700 dark:text-zinc-300"><code>{{ json_encode($activity->changes(), JSON_PRETTY_PRINT) }}</code></pre>
                                        </div>

                                        <div class="flex">
                                            <flux:spacer />
                                            <flux:modal.close>
                                                <flux:button variant="ghost">{{ __('Close') }}</flux:button>
                                            </flux:modal.close>
                                        </div>
                                    </div>
                                </flux:modal>
                            @else
                                <span class="text-zinc-300">-</span>
                            @endif
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:text size="sm" variant="subtle">{{ $activity->created_at->diffForHumans() }}</flux:text>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
