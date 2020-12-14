<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{HomeController,UserController,CashierController,ManagementController,
                        EDCController,ComputerController,CounterController,ScheduleController,
                        ShiftController,MonitoringController,ActivityController,ConsolidateController,
                        ReportController};


Route::get('/', function () {return view('portfolio.portfolio');});

Auth::routes(['verify' => true]);

Route::get('/admin', [HomeController::class, 'index'])->name('admin');

Route::prefix('admin')->middleware('auth')->group(function(){
    Route::get('profile', [UserController::class, 'index'])->name('profile');
    Route::get('lockscreen', [UserController::class, 'lockscreen'])->name('lockscreen');
    Route::get('contact', [UserController::class, 'create'])->name('contact');
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('gallery', [HomeController::class, 'galler::classy'])->name('gallery');
    Route::get('calendar', [HomeController::class, 'calendar'])->name('calendar');
    Route::get('banana', [HomeController::class, 'banana'])->name('banana');
    Route::get('helpdesk', [HomeController::class, 'helpdesk'])->name('helpdesk');
    Route::get('sales', [HomeController::class, 'sales'])->name('sales');
    Route::get('mailbox', [HomeController::class, 'mailbox'])->name('mailbox');
    Route::get('compose', [HomeController::class, 'compose'])->name('compose');
    Route::get('readmail', [HomeController::class, 'readmail'])->name('readmail');
    Route::get('error', [HomeController::class, 'error'])->name('error');


    Route::get('cashierdatatable', [CashierController::class, 'datatable'])->name('cashier.datatable');
    Route::resource('cashier', CashierController::class);
    Route::get('superadmin', [CashierController::class, 'index'])->name('superadmin');
    Route::get('cashiermoredelete', [CashierController::class, 'moredelete'])->name('cashier.moredelete');

    // Route::get('managementdatatable', [ManagementController::class, 'datatable'])->name('management.datatable');
    // Route::resource('management', ManagementController::class);
    // Route::get('managementmoredelete', [ManagementController::class, 'moredelete'])->name('management.moredelete');

    Route::get('edc/yajra', [EDCController::class, 'yajra'])->name('edc.yajra');
    Route::resource('edc', EDCController::class);
    Route::post('edc/store', [EDCController::class, 'store']);
    Route::get('edcdatatable', [EDCController::class, 'datatable'])->name('edc.datatable');

    Route::get('edcmoredelete', [EDCController::class, 'moredelete'])->name('edc.moredelete');

    Route::get('computerdatatable', [ComputerController::class, 'datatable'])->name('computer.datatable');
    Route::resource('computer', ComputerController::class);
    Route::get('computermoredelete', [ComputerController::class, 'moredelete'])->name('computer.moredelete');

    Route::get('counterdatatable', [CounterController::class, 'datatable'])->name('counter.datatable');
    Route::resource('counter', CounterController::class);
    Route::get('countersomedelete', [CounterController::class, 'moredelete'])->name('counter.moredelete');

    Route::get('scheduledatatable', [ScheduleController::class, 'datatable'])->name('schedule.datatable');
    Route::post('scheduledatatablepost', [ScheduleController::class, 'datatable'])->name('schedule.datatablepost');
    Route::get('scheduleadd', [ScheduleController::class, 'getBasic']);
    Route::get('schedulenew', [ScheduleController::class, 'indexnew']);
    Route::get('schedule/datatablecreate', [ScheduleController::class, 'datatablecreate'])->name('schedule.datatablecreate');
    Route::resource('schedule', ScheduleController::class);
    Route::get('schedule/{schedule}/create', [ScheduleController::class, 'form'])->name('schedule.form');;
    Route::get('scheduledatatable/destroy/{id}', [ScheduleController::class, 'destroydatatable']);
    Route::post('schedule/day', [ScheduleController::class, 'day']);

    Route::get('shiftdatatable', [ShiftController::class, 'datatable'])->name('shift.datatable');
    Route::resource('shift', ShiftController::class);

    Route::resource('monitoring', MonitoringController::class);
    Route::get('monitoring/destroy/{id}', [MonitoringController::class, 'destroy']);

    Route::resource('chronology', ActivityController::class);
    Route::get('reminder', [ActivityController::class, 'reminder'])->name('reminder');
    Route::get('performance', [ActivityController::class, 'performance'])->name('performance');
    Route::get('pratice', [ActivityController::class, 'pratice'])->name('pratice');
    Route::get('question', [ActivityController::class, 'question'])->name('question');
    Route::get('score', [ActivityController::class, 'score'])->name('score');
    Route::get('training', [ActivityController::class, 'training'])->name('training.index');
    Route::get('elearning', [ActivityController::class, 'elearning'])->name('elearning.index');

    Route::resource('consolidate', ConsolidateController::class);
    Route::get('deposit', [ConsolidateController::class, 'deposit'])->name('consolidate.deposit');
    Route::get('consolidatedatatable', [ConsolidateController::class, 'datatable'])->name('consolidate.datatable');
    Route::get('banana', [ConsolidateController::class, 'banana'])->name('consolidate.banana');

    Route::resource('report', ReportController::class);

});
