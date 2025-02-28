<?php


use App\Http\Controllers\SchoolAdmin\MembershipHeadController;
use App\Http\Controllers\SchoolAdmin\MembershipController;


    Route::get('membershiphead', [MembershipHeadController::class, 'index'])->name('membershiphead.index');
    Route::get('membershiphead/create', 'MembershipHeadController@create')->name('membershiphead.create');
    Route::post('membershiphead', 'MembershipHeadController@store')->name('membershiphead.store');
    Route::get('membershiphead/{membershiphead}/edit', [MembershipHeadController::class, 'edit'])->name('membershiphead.edit');
    Route::put('membershiphead/{membershiphead}', [MembershipHeadController::class, 'update'])->name('membershiphead.update');
    Route::delete('membershiphead/{membershiphead}', [MembershipHeadController::class, 'destroy'])->name('membershiphead.destroy');




    Route::get('members', [MembershipController::class, 'index'])->name('members.index');
    Route::get('members/create', [MembershipController::class, 'create'])->name('members.create');
    Route::post('members', [MembershipController::class, 'store'])->name('members.store');
    Route::get('members/{member}/edit', [MembershipController::class, 'edit'])->name('members.edit');
    Route::put('members/{member}', [MembershipController::class, 'update'])->name('members.update');
    Route::delete('members/{member}', [MembershipController::class, 'destroy'])->name('members.destroy');


   
    Route::get('get-districts/{stateId}', [MembershipController::class, 'getDistrictsByState']);
    Route::get('get-municipalities/{districtId}', [MembershipController::class, 'getMunicipalitiesByDistrict']);
    Route::get('get-wards/{municipalityId}', [MembershipController::class, 'getWardsByMunicipality']);

