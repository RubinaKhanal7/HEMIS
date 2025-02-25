<?php




use App\Http\Controllers\SchoolAdmin\IdCardDesignController;




Route::get('id-carddesigns/{id}/edit', [IdCardDesignController::class, 'edit'])->name('id-carddesigns.edit');
   


Route::put('id-carddesigns/{id}', [IdCardDesignController::class, 'update'])->name('id-carddesigns.update');

Route::delete('id-carddesigns/{idCardDesign}', [App\Http\Controllers\SchoolAdmin\IdCardDesignController::class, 'destroy'])->name('id-carddesigns.destroy');

Route::resource('id-carddesigns', IdCardDesignController::class);
Route::post('id-card-design/get', [IdCardDesignController::class, 'getAllAdmitCardDesign'])->name('admit-carddesigns.get');

Route::get('admitcard/get-sections/{classId}', [IdCardDesignController::class, 'getSections'])->name('admitcard.get-sections');
Route::get('id-carddesigns/show-design/{id}', [App\Http\Controllers\SchoolAdmin\IdCardDesignController::class, 'showDesign'])->name('id-carddesigns.show-design');