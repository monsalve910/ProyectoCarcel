<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuardiaController;
use App\Http\Controllers\PrisioneroController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\VisitaController;
use App\Http\Controllers\VisitanteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        
        Route::get('/guardias', [GuardiaController::class, 'index'])->name('guardias.index');
        Route::get('/guardias/create', [GuardiaController::class, 'create'])->name('guardias.create');
        Route::post('/guardias', [GuardiaController::class, 'store'])->name('guardias.store');
        Route::get('/guardias/{guardia}', [GuardiaController::class, 'show'])->name('guardias.show');
        Route::get('/guardias/{guardia}/edit', [GuardiaController::class, 'edit'])->name('guardias.edit');
        Route::put('/guardias/{guardia}', [GuardiaController::class, 'update'])->name('guardias.update');
        Route::delete('/guardias/{guardia}', [GuardiaController::class, 'destroy'])->name('guardias.destroy');
        Route::patch('/guardias/{guardia}/toggle-active', [GuardiaController::class, 'toggleActive'])->name('guardias.toggle-active');

        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/prisioneros', [ReporteController::class, 'prisioneros'])->name('reportes.prisioneros');
        Route::get('/reportes/visitantes', [ReporteController::class, 'visitantes'])->name('reportes.visitantes');
        Route::get('/reportes/visitas', [ReporteController::class, 'visitas'])->name('reportes.visitas');
        Route::get('/reportes/auditoria', [ReporteController::class, 'auditoria'])->name('reportes.auditoria');

        Route::get('/reportes/prisioneros/pdf', [ReporteController::class, 'exportarPdfPrisioneros'])->name('reportes.prisioneros.pdf');
        Route::get('/reportes/visitantes/pdf', [ReporteController::class, 'exportarPdfVisitantes'])->name('reportes.visitantes.pdf');
        Route::get('/reportes/visitas/pdf', [ReporteController::class, 'exportarPdfVisitas'])->name('reportes.visitas.pdf');
        Route::get('/reportes/auditoria/pdf', [ReporteController::class, 'exportarPdfAuditoria'])->name('reportes.auditoria.pdf');

        Route::get('/reportes/prisioneros/excel', [ReporteController::class, 'exportarExcelPrisioneros'])->name('reportes.prisioneros.excel');
        Route::get('/reportes/visitantes/excel', [ReporteController::class, 'exportarExcelVisitantes'])->name('reportes.visitantes.excel');
        Route::get('/reportes/visitas/excel', [ReporteController::class, 'exportarExcelVisitas'])->name('reportes.visitas.excel');
        Route::get('/reportes/auditoria/excel', [ReporteController::class, 'exportarExcelAuditoria'])->name('reportes.auditoria.excel');
    });

    Route::prefix('guardia')->middleware(['role:guardia'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'guardiaDashboard'])->name('guardia.dashboard');
    });

    Route::middleware(['role:guardia'])->group(function () {
        Route::resource('prisioneros', PrisioneroController::class);
        Route::resource('visitantes', VisitanteController::class);
        Route::resource('visitas', VisitaController::class);

        Route::patch('/visitas/{visita}/approve', [VisitaController::class, 'approve'])->name('visitas.approve');
        Route::patch('/visitas/{visita}/reject', [VisitaController::class, 'reject'])->name('visitas.reject');
        Route::patch('/visitas/{visita}/complete', [VisitaController::class, 'complete'])->name('visitas.complete');
        Route::patch('/visitas/{visita}/cancel', [VisitaController::class, 'cancel'])->name('visitas.cancel');
    });
});
