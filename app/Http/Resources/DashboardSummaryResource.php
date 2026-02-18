<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => $this->resource->type,
            'meta' => [
                'period' => [
                    'start' => $this->resource->filters->startDate?->format('Y-m-d'),
                    'end' => $this->resource->filters->endDate?->format('Y-m-d'),
                ],
                'region' => $this->resource->filters->region,
            ],
            'data' => $this->resource->data,
        ];
    }
}
