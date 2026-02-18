<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

class DashboardSummaryDto
{
    public function __construct(
        public string $type,
        public DashboardFilterDto $filters,
        public Collection $data,
    ) {}

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'filters' => [
                'start_date' => $this->filters->startDate?->format('Y-m-d'),
                'end_date' => $this->filters->endDate?->format('Y-m-d'),
                'region' => $this->filters->region,
            ],
            'data' => $this->data,
        ];
    }
}
