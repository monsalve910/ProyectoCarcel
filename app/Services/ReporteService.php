<?php

namespace App\Services;

use App\Models\LoginLog;
use App\Models\Prisionero;
use App\Models\Visita;
use App\Models\Visitante;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteService
{
    public function generarReportePrisioneros(?string $fechaDesde = null, ?string $fechaHasta = null): array
    {
        $query = Prisionero::query();

        if ($fechaDesde) {
            $query->whereDate('fecha_ingreso', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('fecha_ingreso', '<=', $fechaHasta);
        }

        $prisioneros = $query->orderBy('nombre')->get();

        return [
            'titulo' => 'Reporte de Prisioneros',
            'fecha_generacion' => now()->format('d/m/Y H:i:s'),
            'fecha_desde' => $fechaDesde,
            'fecha_hasta' => $fechaHasta,
            'datos' => $prisioneros,
            'total' => $prisioneros->count(),
        ];
    }

    public function generarReporteVisitantes(?string $fechaDesde = null, ?string $fechaHasta = null): array
    {
        $query = Visitante::query();

        if ($fechaDesde) {
            $query->whereDate('created_at', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('created_at', '<=', $fechaHasta);
        }

        $visitantes = $query->orderBy('nombre')->get();

        return [
            'titulo' => 'Reporte de Visitantes',
            'fecha_generacion' => now()->format('d/m/Y H:i:s'),
            'fecha_desde' => $fechaDesde,
            'fecha_hasta' => $fechaHasta,
            'datos' => $visitantes,
            'total' => $visitantes->count(),
        ];
    }

    public function generarReporteVisitas(?string $fechaDesde = null, ?string $fechaHasta = null, ?string $estado = null): array
    {
        $query = Visita::with(['prisionero', 'visitante', 'guardia']);

        if ($fechaDesde) {
            $query->whereDate('fecha_hora_entrada', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('fecha_hora_entrada', '<=', $fechaHasta);
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        $visitas = $query->orderBy('fecha_hora_entrada', 'desc')->get();

        return [
            'titulo' => 'Reporte de Visitas',
            'fecha_generacion' => now()->format('d/m/Y H:i:s'),
            'fecha_desde' => $fechaDesde,
            'fecha_hasta' => $fechaHasta,
            'estado' => $estado,
            'datos' => $visitas,
            'total' => $visitas->count(),
            'stats' => [
                'pendientes' => $visitas->where('estado', 'pendiente')->count(),
                'aprobadas' => $visitas->where('estado', 'aprobada')->count(),
                'completadas' => $visitas->where('estado', 'completada')->count(),
                'rechazadas' => $visitas->where('estado', 'rechazada')->count(),
                'canceladas' => $visitas->where('estado', 'cancelada')->count(),
            ],
        ];
    }

    public function generarReporteAuditoria(?string $fechaDesde = null, ?string $fechaHasta = null): array
    {
        $query = LoginLog::with('user');

        if ($fechaDesde) {
            $query->whereDate('login_at', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('login_at', '<=', $fechaHasta);
        }

        $logs = $query->orderBy('login_at', 'desc')->get();

        return [
            'titulo' => 'Reporte de Auditoría de Accesos',
            'fecha_generacion' => now()->format('d/m/Y H:i:s'),
            'fecha_desde' => $fechaDesde,
            'fecha_hasta' => $fechaHasta,
            'datos' => $logs,
            'total' => $logs->count(),
            'stats' => [
                'exitosos' => $logs->where('successful', true)->count(),
                'fallidos' => $logs->where('successful', false)->count(),
            ],
        ];
    }

    public function exportarPdfPrisioneros(array $data): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('reportes.pdf.prisioneros', $data);
    }

    public function exportarPdfVisitantes(array $data): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('reportes.pdf.visitantes', $data);
    }

    public function exportarPdfVisitas(array $data): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('reportes.pdf.visitas', $data);
    }

    public function exportarPdfAuditoria(array $data): \Barryvdh\DomPDF\PDF
    {
        return Pdf::loadView('reportes.pdf.auditoria', $data);
    }

    public function exportarExcelPrisioneros(array $data): Spreadsheet
    {
        return $this->generarExcel($data, ['Número Celda', 'Nombre', 'Apellido', 'Identificación', 'Fecha Nac.', 'Delito', 'Fecha Ingreso', 'Estado']);
    }

    public function exportarExcelVisitantes(array $data): Spreadsheet
    {
        return $this->generarExcel($data, ['Nombre', 'Apellido', 'Identificación', 'Teléfono', 'Parentesco', 'Dirección', 'Estado']);
    }

    public function exportarExcelVisitas(array $data): Spreadsheet
    {
        return $this->generarExcel($data, ['Fecha/Hora Entrada', 'Fecha/Hora Salida', 'Prisionero', 'Visitante', 'Guardia', 'Estado', 'Observaciones']);
    }

    public function exportarExcelAuditoria(array $data): Spreadsheet
    {
        return $this->generarExcel($data, ['Usuario', 'Fecha/Hora Login', 'Fecha/Hora Logout', 'IP', 'Exitoso']);
    }

    protected function generarExcel(array $data, array $headers): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', $data['titulo']);
        $sheet->mergeCells('A1:' . chr(64 + count($headers)) . '1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        $sheet->setCellValue('A2', 'Generado: ' . $data['fecha_generacion']);
        $sheet->mergeCells('A2:' . chr(64 + count($headers)) . '2');

        if ($data['fecha_desde'] || $data['fecha_hasta']) {
            $filtros = 'Período: ';
            $filtros .= $data['fecha_desde'] ? "Desde {$data['fecha_desde']}" : '';
            $filtros .= $data['fecha_hasta'] ? " Hasta {$data['fecha_hasta']}" : '';
            $sheet->setCellValue('A3', $filtros);
            $sheet->mergeCells('A3:' . chr(64 + count($headers)) . '3');
            $startRow = 4;
        } else {
            $startRow = 3;
        }

        $headerRow = $startRow;
        foreach ($headers as $index => $header) {
            $cell = chr(65 + $index) . $headerRow;
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getStyle("A{$headerRow}:" . chr(64 + count($headers)) . $headerRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCCCCC']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        $currentRow = $headerRow + 1;
        foreach ($data['datos'] as $item) {
            $this->populateRow($sheet, $item, $currentRow, $headers);
            $currentRow++;
        }

        foreach (range('A', chr(64 + count($headers))) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $totalRow = $currentRow;
        $sheet->setCellValue('A' . $totalRow, 'Total de registros: ' . $data['total']);
        $sheet->mergeCells('A' . $totalRow . ':' . chr(64 + count($headers)) . $totalRow);
        $sheet->getStyle('A' . $totalRow)->applyFromArray([
            'font' => ['bold' => true],
        ]);

        return $spreadsheet;
    }

    protected function populateRow($sheet, $item, int $row, array $headers): void
    {
        $mapping = $this->getMappingForItem($item, $headers);
        foreach ($mapping as $index => $value) {
            $sheet->setCellValue(chr(65 + $index) . $row, $value);
        }
    }

    protected function getMappingForItem($item, array $headers): array
    {
        if ($item instanceof Prisionero) {
            return [
                $item->numero_celda,
                $item->nombre,
                $item->apellido,
                $item->numero_identificacion,
                $item->fecha_nacimiento?->format('d/m/Y'),
                $item->delito,
                $item->fecha_ingreso?->format('d/m/Y'),
                $item->estado ? 'Activo' : 'Inactivo',
            ];
        }

        if ($item instanceof Visitante) {
            return [
                $item->nombre,
                $item->apellido,
                $item->numero_identificacion,
                $item->telefono,
                $item->parentesco,
                $item->direccion,
                $item->estado ? 'Activo' : 'Inactivo',
            ];
        }

        if ($item instanceof Visita) {
            return [
                $item->fecha_hora_entrada?->format('d/m/Y H:i'),
                $item->fecha_hora_salida?->format('d/m/Y H:i'),
                $item->prisionero?->nombre_completo ?? 'N/A',
                $item->visitante?->nombre_completo ?? 'N/A',
                $item->guardia?->name ?? 'N/A',
                ucfirst($item->estado),
                $item->observaciones,
            ];
        }

        if ($item instanceof LoginLog) {
            return [
                $item->user?->name ?? 'N/A',
                $item->login_at?->format('d/m/Y H:i:s'),
                $item->logout_at?->format('d/m/Y H:i:s'),
                $item->ip_address,
                $item->successful ? 'Sí' : 'No',
            ];
        }

        return [];
    }
}
