<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\VirtualMachineController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/nodes', [NodeController::class, 'index'])->name('nodes.index');
    Route::get('/nodes/{nodeId}', [NodeController::class, 'show'])->name('nodes.show');

    Route::get('/nodes/{nodeId}/vms', [VirtualMachineController::class, 'index'])->name('vms.index');
    Route::post('/nodes/{nodeId}/vms/{vmid}/start', [VirtualMachineController::class, 'start'])->name('vms.start');
    Route::post('/nodes/{nodeId}/vms/{vmid}/stop', [VirtualMachineController::class, 'stop'])->name('vms.stop');
    Route::get('/nodes/{nodeId}/vms/{vmid}/console', [VirtualMachineController::class, 'console'])->name('vms.console');
});
