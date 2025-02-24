<?php

use App\Http\Controllers\SchoolAdmin\StudentController;


Route::resource('students', StudentController::class);
Route::post('/admin/student/get', [StudentController::class, 'getData'])->name('student.get');


Route::get('students-additionalinformations/{student_id}', [StudentController::class, 'additionalInformationStudents'])->name('students.additionalinformations_create');
Route::get('get-programs-by-class/{classId}', 'StudentController@getProgramsByClass');
Route::post('students/{student_id}/additional-information', [StudentController::class, 'updateAdditionalInformation'])->name('students.additionalInformation.update');


Route::get('admin/get-faculties/{classId}', [StudentController::class, 'getFaculties'])->name('student.get-faculties');
Route::get('admin/get-programs/{sectionId}', [StudentController::class, 'getPrograms'])->name('student.get-programs');

Route::get('/get-district-by-state/{state_id}', [StudentController::class, 'getDistrict'])->name('get-districts');
Route::get('student/import/index', [StudentController::class, 'importAllStudentIndex'])->name('students.import');

Route::post('/import', [StudentController::class, 'import'])->name('students.bulkimport');

Route::post('students/bulk-delete', [StudentController::class, 'destroyMultiple'])->name('students.bulk-delete');

Route::post('students/save-roll-number', [StudentController::class, 'saveRollNumber'])->name('students.save-roll-number');

Route::get('/admin/students/export-selected', [StudentController::class, 'exportSelected'])->name('students.export-selected');
Route::get('/admin/students/export-all', [StudentController::class, 'exportAll'])->name('students.export-all');

Route::get('/form', [StudentController::class, 'loadFormData'])->name('form.load');