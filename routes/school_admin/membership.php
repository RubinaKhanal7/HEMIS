<?php

use App\Http\Controllers\SchoolAdmin\MembershipHeadController;

    Route::get('membershiphead', [MembershipHeadController::class, 'index'])->name('membershiphead.index');
    Route::get('membershiphead/create', 'MembershipHeadController@create')->name('membershiphead.create');
    Route::post('membershiphead', 'MembershipHeadController@store')->name('membershiphead.store');
    Route::get('membershiphead/{membershiphead}/edit', [MembershipHeadController::class, 'edit'])->name('membershiphead.edit');
    Route::put('membershiphead/{membershiphead}', [MembershipHeadController::class, 'update'])->name('membershiphead.update');
    Route::delete('membershiphead/{membershiphead}', [MembershipHeadController::class, 'destroy'])->name('membershiphead.destroy');
