<?php

namespace App\Controller;

use App\Contract\DashboardServiceInterface;
use App\Response\ApiResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/dashboard')]
class DashboardController extends AbstractController
{
    public function __construct(
        private readonly DashboardServiceInterface $dashboardService
    ) {
    }

    #[Route('/stats', name: 'api_dashboard_stats', methods: ['GET'])]
    public function getStats(): JsonResponse
    {
        try {
            $stats = $this->dashboardService->getOverviewStats();
            return ApiResponse::success($stats);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve dashboard statistics');
        }
    }

    #[Route('/activities', name: 'api_dashboard_activities', methods: ['GET'])]
    public function getActivities(): JsonResponse
    {
        try {
            $activities = $this->dashboardService->getRecentActivities();
            return ApiResponse::success($activities);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve recent activities');
        }
    }

    #[Route('/pipeline', name: 'api_dashboard_pipeline', methods: ['GET'])]
    public function getPipeline(): JsonResponse
    {
        try {
            $pipeline = $this->dashboardService->getOpportunitiesPipeline();
            return ApiResponse::success($pipeline);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve opportunities pipeline');
        }
    }

    #[Route('/tasks-summary', name: 'api_dashboard_tasks_summary', methods: ['GET'])]
    public function getTasksSummary(): JsonResponse
    {
        try {
            $summary = $this->dashboardService->getTasksSummary();
            return ApiResponse::success($summary);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve tasks summary');
        }
    }
}