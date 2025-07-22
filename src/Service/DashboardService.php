<?php

namespace App\Service;

use App\Contract\DashboardServiceInterface;
use App\Contract\ContactRepositoryInterface;
use App\Contract\CompanyRepositoryInterface;
use App\Contract\OpportunityRepositoryInterface;
use App\Contract\TaskRepositoryInterface;
use App\Contract\NoteRepositoryInterface;
use App\Entity\OpportunityStatus;
use App\Entity\TaskStatus;

class DashboardService implements DashboardServiceInterface
{
    public function __construct(
        private readonly ContactRepositoryInterface $contactRepository,
        private readonly CompanyRepositoryInterface $companyRepository,
        private readonly OpportunityRepositoryInterface $opportunityRepository,
        private readonly TaskRepositoryInterface $taskRepository,
        private readonly NoteRepositoryInterface $noteRepository,
    ) {
    }

    public function getOverviewStats(): array
    {
        return [
            'contacts' => $this->contactRepository->count([]),
            'companies' => $this->companyRepository->count([]),
            'opportunities' => $this->opportunityRepository->count([]),
            'tasks' => $this->taskRepository->count([]),
            'notes' => $this->noteRepository->count([]),
        ];
    }

    public function getRecentActivities(int $limit = 10): array
    {
        $since = new \DateTimeImmutable('-7 days');
        
        return [
            'recent_notes' => $this->noteRepository->findRecentNotes($since),
            'upcoming_tasks' => $this->taskRepository->findDueSoon(new \DateTimeImmutable('+7 days')),
            'overdue_tasks' => $this->taskRepository->findOverdue(new \DateTimeImmutable()),
        ];
    }

    public function getOpportunitiesPipeline(): array
    {
        $pipeline = [];
        
        foreach (OpportunityStatus::cases() as $status) {
            $pipeline[$status->value] = [
                'count' => count($this->opportunityRepository->findByStatus($status)),
                'total_amount' => $this->opportunityRepository->getTotalAmountByStatus($status),
            ];
        }

        return $pipeline;
    }

    public function getTasksSummary(): array
    {
        $summary = [];
        
        foreach (TaskStatus::cases() as $status) {
            $summary[$status->value] = count($this->taskRepository->findByStatus($status));
        }

        return $summary;
    }
}