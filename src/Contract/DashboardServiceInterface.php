<?php

namespace App\Contract;

interface DashboardServiceInterface
{
    public function getOverviewStats(): array;

    public function getRecentActivities(int $limit = 10): array;

    public function getOpportunitiesPipeline(): array;

    public function getTasksSummary(): array;
}