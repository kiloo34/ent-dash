<?php

namespace App\DTOs;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class DashboardFilterDto
{
    public function __construct(
        public ?CarbonImmutable $startDate,
        public ?CarbonImmutable $endDate,
        public ?string $region,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            startDate: $request->date('start_date'),
            endDate: $request->date('end_date'),
            region: $request->input('region'),
        );
    }

    public static function fromArray(array $data): self
    {
        return new self(
            startDate: isset($data['start_date']) ? CarbonImmutable::parse($data['start_date']) : null,
            endDate: isset($data['end_date']) ? CarbonImmutable::parse($data['end_date']) : null,
            region: $data['region'] ?? null,
        );
    }
}
