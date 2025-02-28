<?php

use App\Http\Controllers\SchoolAdmin\StaffReportController;

Route::get('staff-reports', [StaffReportController::class, 'index'])->name('staff-reports.index');
Route::get('staff-reports/report', [StaffReportController::class, 'report'])->name('staff-reports.report');