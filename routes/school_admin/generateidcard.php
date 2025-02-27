<?php

// use App\Models\GenerateMarkSheet;

use App\Http\Controllers\SchoolAdmin\IDCardGenerationController;

Route::prefix('generate-idcards')->name('generate-idcards.')->group(function () {
    Route::get('/', [IDCardGenerationController::class, 'index'])->name('index');
    Route::post('/students/get', [IDCardGenerationController::class, 'getStudents'])->name('students.get');
    Route::get('/get-sections/{classId}', [IDCardGenerationController::class, 'getSections'])->name('get-sections');
    Route::get('/get-programs/{sectionId}', [IDCardGenerationController::class, 'getPrograms'])->name('get-programs');
    Route::get('/show-idcard-design/{studentId}/{idCardId}', [IDCardGenerationController::class, 'showIDCardDesign'])->name('show-idcard-design');
    Route::get('/download-id-card/{studentId}/{idCardId}', [IDCardGenerationController::class, 'downloadIDCard'])->name('download-id-card');
    Route::post('/bulk-download', [IDCardGenerationController::class, 'bulkDownload'])->name('bulk-download');
    Route::get('admin/get-faculties/{classId}', [IDCardGenerationController::class, 'getFaculties'])->name('get-faculties');
    Route::get('admin/get-programs/{sectionId}', [IDCardGenerationController::class, 'getProgram'])->name('get-programs');
});