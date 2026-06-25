<?php

namespace App\Http\Controllers;

use App\Services\DeliveryReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    public function deliveries(DeliveryReportService $report): JsonResponse
    {
        return response()->json($report->endpointHealth());
    }
}
