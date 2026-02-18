<x-layouts::app :title="__('Superadmin Dashboard')">
    <div class="flex flex-col gap-6">
        <!-- Stats overview -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <flux:card class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <flux:text size="sm" class="uppercase tracking-wider font-semibold text-zinc-500">{{ __('Total Users') }}</flux:text>
                    <flux:icon.users variant="mini" class="text-indigo-500" />
                </div>
                <flux:heading size="xl">{{ number_format($stats['users']) }}</flux:heading>
            </flux:card>

            <flux:card class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <flux:text size="sm" class="uppercase tracking-wider font-semibold text-zinc-500">{{ __('Org Units') }}</flux:text>
                    <flux:icon.building-office variant="mini" class="text-emerald-500" />
                </div>
                <flux:heading size="xl">{{ number_format($stats['units']) }}</flux:heading>
            </flux:card>

            <flux:card class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <flux:text size="sm" class="uppercase tracking-wider font-semibold text-zinc-500">{{ __('Job Positions') }}</flux:text>
                    <flux:icon.briefcase variant="mini" class="text-amber-500" />
                </div>
                <flux:heading size="xl">{{ number_format($stats['positions']) }}</flux:heading>
            </flux:card>

            <flux:card class="flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <flux:text size="sm" class="uppercase tracking-wider font-semibold text-zinc-500">{{ __('System Activities') }}</flux:text>
                    <flux:icon.command-line variant="mini" class="text-rose-500" />
                </div>
                <flux:heading size="xl">{{ number_format($stats['activity']) }}</flux:heading>
            </flux:card>
        </div>

        <!-- Recent Activity Table -->
        <flux:card class="flex flex-col gap-4">
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="lg">{{ __('Recent System Activity') }}</flux:heading>
                    <flux:subheading>{{ __('Latest logs across all modules') }}</flux:subheading>
                </div>
                <flux:button variant="ghost" size="sm" :href="route('superadmin.activity-logs')" wire:navigate>
                    {{ __('View All') }}
                </flux:button>
            </div>

            <flux:separator />

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>{{ __('Activity') }}</flux:table.column>
                    <flux:table.column>{{ __('User') }}</flux:table.column>
                    <flux:table.column>{{ __('Subject') }}</flux:table.column>
                    <flux:table.column>{{ __('Date') }}</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach($recent_activity as $log)
                        <flux:table.row>
                            <flux:table.cell>
                                <flux:badge color="{{ match($log->description) { 'created' => 'emerald', 'updated' => 'amber', 'deleted' => 'rose', default => 'zinc' } }}" size="sm">
                                    {{ $log->description }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell class="font-medium">{{ $log->causer?->name ?? 'System' }}</flux:table.cell>
                            <flux:table.cell class="text-zinc-500 italic">{{ str_replace('App\\Models\\', '', $log->subject_type) }}</flux:table.cell>
                            <flux:table.cell class="whitespace-nowrap">{{ $log->created_at->diffForHumans() }}</flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </flux:card>

        <!-- Quick Links / Hero Section -->
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <flux:card class="bg-indigo-600 !p-8 text-white">
                <div class="flex flex-col gap-4">
                    <flux:heading size="xl" class="text-white">Admin Command Center</flux:heading>
                    <flux:text class="text-indigo-100 italic">Welcome back, Superadmin. Manage your enterprise resources and monitor system health from one central location.</flux:text>
                    <div class="flex gap-2">
                        <flux:button variant="filled" class="bg-white/20 hover:bg-white/30 border-none text-white" :href="route('superadmin.organization.units')">Manage Units</flux:button>
                        <flux:button variant="filled" class="bg-white/20 hover:bg-white/30 border-none text-white" :href="route('superadmin.organization.positions')">Manage Positions</flux:button>
                    </div>
                </div>
            </flux:card>
            
            <flux:card class="flex flex-col items-center justify-center border-dashed border-2 p-8">
                <flux:text class="text-center text-zinc-400">Custom widgets and system health monitors will appear here as the system expands.</flux:text>
            </flux:card>
        </div>
    </div>
</x-layouts::app>
