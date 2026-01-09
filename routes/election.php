<?php

use App\Http\Controllers\Dashboard\ElectionController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('election/dashboard', [ElectionController::class, 'dashboard'])->name('admin.election.dashboard');
        Route::get('election/details/{uuid}', [ElectionController::class, 'electionDetails'])->name('admin.election.details');
        Route::get('election/choosed/member/list/{uuid}/{member_id}', [ElectionController::class, 'getChoosedMemberList'])->name('admin.election.get.choosed.member.list');
        Route::get('election/content/manage', [ElectionController::class, 'electionContentManage'])->name('admin.election.content.manage');
        Route::post('election/content/create', [ElectionController::class, 'electionCreateContent'])->name('admin.election.create.content');
        Route::get('election/create', [ElectionController::class, 'createElection'])->name('admin.election.create');
        Route::post('election/store', [ElectionController::class, 'storeElection'])->name('admin.election.store');
        Route::post('election/get/available/positions', [ElectionController::class, 'getAvailableElectionPosition'])->name('admin.election.get.available.positions');
        Route::post('election/elect/member/for/position', [ElectionController::class, 'electMemberForPosition'])->name('admin.election.position.select.member');
        Route::get('election/position/export', [ElectionController::class, 'electionPositionExport'])->name('election.position.export');
        Route::get('customer/election/export', [ElectionController::class, 'customerElectionExport'])->name('customer.election.export');
    });
});
