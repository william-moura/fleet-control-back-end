<?php

namespace App\Http\Controllers;

use App\DTOs\GenerateReportDTO;
use App\Http\Requests\GenerateReportRequest;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function generatePdfReport(string $id, GenerateReportRequest $request): Response
    {
        $dto = GenerateReportDTO::fromRequest($request);
        $pdf = $this->reportService->generatePdfReport($id, $dto);
        return $pdf->stream("relatorio_{$id}.pdf");
    }
    public function generateExcelReport(string $id, GenerateReportRequest $request): BinaryFileResponse
    {
        $dto = GenerateReportDTO::fromRequest($request);
        return $this->reportService->generateExcelReport($id, $dto);
    }
}
