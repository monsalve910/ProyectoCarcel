<?php

namespace App\Http\Controllers;

use App\Services\ReporteService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteController extends Controller
{
    protected ReporteService $reporteService;

    public function __construct(ReporteService $reporteService)
    {
        $this->reporteService = $reporteService;
    }

    public function index(): View
    {
        return view('reportes.index');
    }

    public function prisioneros(Request $request): View
    {
        $data = $this->reporteService->generarReportePrisioneros(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta')
        );

        return view('reportes.prisioneros', $data);
    }

    public function visitantes(Request $request): View
    {
        $data = $this->reporteService->generarReporteVisitantes(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta')
        );

        return view('reportes.visitantes', $data);
    }

    public function visitas(Request $request): View
    {
        $data = $this->reporteService->generarReporteVisitas(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta'),
            $request->input('estado')
        );

        return view('reportes.visitas', $data);
    }

    public function auditoria(Request $request): View
    {
        $data = $this->reporteService->generarReporteAuditoria(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta')
        );

        return view('reportes.auditoria', $data);
    }

    public function exportarPdfPrisioneros(Request $request)
    {
        $data = $this->reporteService->generarReportePrisioneros(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta')
        );

        $pdf = $this->reporteService->exportarPdfPrisioneros($data);
        $nombre = 'reporte_prisioneros_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($nombre);
    }

    public function exportarPdfVisitantes(Request $request)
    {
        $data = $this->reporteService->generarReporteVisitantes(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta')
        );

        $pdf = $this->reporteService->exportarPdfVisitantes($data);
        $nombre = 'reporte_visitantes_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($nombre);
    }

    public function exportarPdfVisitas(Request $request)
    {
        $data = $this->reporteService->generarReporteVisitas(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta'),
            $request->input('estado')
        );

        $pdf = $this->reporteService->exportarPdfVisitas($data);
        $nombre = 'reporte_visitas_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($nombre);
    }

    public function exportarPdfAuditoria(Request $request)
    {
        $data = $this->reporteService->generarReporteAuditoria(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta')
        );

        $pdf = $this->reporteService->exportarPdfAuditoria($data);
        $nombre = 'reporte_auditoria_' . now()->format('Ymd_His') . '.pdf';

        return $pdf->download($nombre);
    }

    public function exportarExcelPrisioneros(Request $request): StreamedResponse
    {
        $data = $this->reporteService->generarReportePrisioneros(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta')
        );

        $spreadsheet = $this->reporteService->exportarExcelPrisioneros($data);
        $nombre = 'reporte_prisioneros_' . now()->format('Ymd_His') . '.xlsx';

        return $this->downloadExcel($spreadsheet, $nombre);
    }

    public function exportarExcelVisitantes(Request $request): StreamedResponse
    {
        $data = $this->reporteService->generarReporteVisitantes(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta')
        );

        $spreadsheet = $this->reporteService->exportarExcelVisitantes($data);
        $nombre = 'reporte_visitantes_' . now()->format('Ymd_His') . '.xlsx';

        return $this->downloadExcel($spreadsheet, $nombre);
    }

    public function exportarExcelVisitas(Request $request): StreamedResponse
    {
        $data = $this->reporteService->generarReporteVisitas(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta'),
            $request->input('estado')
        );

        $spreadsheet = $this->reporteService->exportarExcelVisitas($data);
        $nombre = 'reporte_visitas_' . now()->format('Ymd_His') . '.xlsx';

        return $this->downloadExcel($spreadsheet, $nombre);
    }

    public function exportarExcelAuditoria(Request $request): StreamedResponse
    {
        $data = $this->reporteService->generarReporteAuditoria(
            $request->input('fecha_desde'),
            $request->input('fecha_hasta')
        );

        $spreadsheet = $this->reporteService->exportarExcelAuditoria($data);
        $nombre = 'reporte_auditoria_' . now()->format('Ymd_His') . '.xlsx';

        return $this->downloadExcel($spreadsheet, $nombre);
    }

    protected function downloadExcel($spreadsheet, string $nombre): StreamedResponse
    {
        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        return response()->streamDownload(
            fn () => print($content),
            $nombre,
            ['Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
        );
    }
}
