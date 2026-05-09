<?php

namespace App\Http\Controllers;

use App\DTOs\GenerateReportDTO;
use App\Http\Requests\GenerateReportRequest;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService)
    {
    }
    public function generateReport(string $id, GenerateReportRequest $request): JsonResponse
    {
        $dto = GenerateReportDTO::fromRequest($request);
        return response()->json($this->reportService->generateReport($id, $dto));
    }

    private function generatePdfReport(string $id, GenerateReportRequest $request): StreamedResponse
    {
        $dto = GenerateReportDTO::fromRequest($request);
        return $this->reportService->generatePdfReport($id, $dto);
    }
    public function generateExcelReport(string $id, GenerateReportRequest $request): BinaryFileResponse
    {
        $dto = GenerateReportDTO::fromRequest($request);
        return $this->reportService->generateExcelReport($id, $dto);
    }
}
