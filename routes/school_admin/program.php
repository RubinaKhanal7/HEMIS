<?php

use App\Http\Controllers\SchoolAdmin\ProgramController;

Route::prefix('programs')->group(function () {
    Route::get('/', [ProgramController::class, 'index'])->name('programs.index');
    Route::post('/store', [ProgramController::class, 'store'])->name('programs.store');
    Route::put('/update/{program}', [ProgramController::class, 'update'])->name('programs.update');
    Route::delete('/delete/{program}', [ProgramController::class, 'destroy'])->name('programs.destroy');
    Route::post('programs/get', [ProgramController::class, 'getAllPrograms'])->name('programs.get');
});