<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportPDF;
use App\Http\Livewire\Reports\Reports;
use App\Http\Livewire\RealPropertyTax\Collection\Forms\Receipt;


// Route::get('/', function () {
//     return view('auth.login');
// });
// Route::get('sample1',Receipt::class)->name('sample1');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/accountable-form-56/{id}', [App\Http\Controllers\ReportController::class, 'af_56'])->name('AF56');
Route::get('/home/export', [App\Http\Controllers\HomeController::class, 'export']);

Auth::routes();

Route::middleware('auth')->group(function () {

    // Route::group(['middleware' => 'role:admin'], function(){
    // });
    Route::get('dashboard', [App\Http\Controllers\MainController::class, 'dashboard'])->name('dashboard');


    //Assessor
    // Route::get('assessor/accounts', [App\Http\Controllers\MainController::class, 'assessor_accounts'])->name('assessor_accounts');
    Route::get('assessor/assessment-roll', [App\Http\Controllers\MainController::class, 'assessor_assessment_roll'])->name('assessor_assessment_roll');
    Route::post('assessor/import_assessment_roll', [App\Http\Livewire\Assessor\AssessmentRoll::class, 'import_assessment'])->name('import_assessment');

    //Real Property Tax
    Route::get('rpt/accounts/account-verification', [App\Http\Controllers\MainController::class, 'rpt_account_verification'])->name('rpt_account_verification');
    Route::get('rpt/accounts/ledger-entry/{id}', [App\Http\Controllers\MainController::class, 'rpt_ledger_entry'])->name('rpt_ledger_entry');
    Route::get('rpt/ledger/collection', [App\Http\Controllers\MainController::class, 'rpt_collection_accounts'])->name('rpt_collection_accounts');
    Route::get('rpt/ledger/collection/receipt/AF56/{trn}',Receipt::class)->name('AF56 RECEIPT');

    // Route::get('rpt/ledger/collection/af56/{$id}', [App\Http\Controllers\MainController::class, 'af_56'])->name('af_56');
    Route::get('rpt/ledger/accounts', [App\Http\Controllers\MainController::class, 'rpt_ledger_accounts'])->name('rpt_ledger_accounts');
    Route::get('rpt/ledger/account/{id}', [App\Http\Controllers\MainController::class, 'rpt_ledger_forms_account'])->name('rpt_ledger_forms_account');
    Route::get('rpt/ledger/delinquency', [App\Http\Controllers\MainController::class, 'rpt_delinquency_accounts'])->name('rpt_delinquency_accounts');
    Route::get('rpt/ledger/barangay-masterlist', [App\Http\Controllers\MainController::class, 'rpt_barangay_masterlists'])->name('rpt_barangay_masterlists');

    Route::get('rpt/reports/assessment-roll', [App\Http\Controllers\ReportController::class,'assessment_roll_report'])->name('assessment_roll_report');
    Route::get('rpt/reports/collectibles', [App\Http\Controllers\ReportController::class,'collectible_report'])->name('collectible_report');
    Route::get('rpt/reports/collection-and-deposits', [App\Http\Controllers\ReportController::class,'collections_and_deposits_report'])->name('collections_and_deposits_report');
    Route::get('rpt/reports/delinquency', [App\Http\Controllers\ReportController::class,'delinquency_report'])->name('delinquency_report');

    Route::get('ledger-view/{id}', [App\Http\Controllers\MainController::class, 'ledger_view'])->name('ledger-view');

    //Settings
    Route::get('settings/address', [App\Http\Controllers\MainController::class, 'settings_address'])->name('settings_address');
    Route::get('settings/booklets', [App\Http\Controllers\MainController::class, 'settings_booklets'])->name('settings_booklets');
    Route::get('settings/taxtables', [App\Http\Controllers\MainController::class, 'settings_taxtables'])->name('settings_taxtables');
    Route::get('settings/forms', [App\Http\Controllers\MainController::class, 'settings_form'])->name('settings_forms');
    Route::get('settings/users', [App\Http\Controllers\MainController::class, 'settings_users'])->name('settings_users');
    //Settings Import
    Route::post('settings/address/import_regions', [App\Http\Livewire\Settings\Address\Region::class, 'import_regions'])->name('import_regions');
    Route::post('settings/address/import_provinces', [App\Http\Livewire\Settings\Address\Province::class, 'import_provinces'])->name('import_provinces');
    Route::post('settings/address/import_municities', [App\Http\Livewire\Settings\Address\Municity::class, 'import_municities'])->name('import_municities');
    Route::post('settings/address/import_barangays', [App\Http\Livewire\Settings\Address\Barangay::class, 'import_barangays'])->name('import_barangays');



    //Revenue Collection System

    // Route::get('', [App\Http\Controllers\MainController::class, 'collection_abstract'])->name('collection-abstract');

    //Revenue Collection System

    // Route::post('assessor/rpt/accounts/import/', [App\Http\Controllers\MainController::class, 'import_rpt'])->name('import_rpt');
    // Route::post('assessor/rpt/accounts/import/', [App\Http\Livewire\Assessor\AccountVerification::class, 'import_rpt'])->name('import_rpt');
    // Route::post('assessor/import_accounts', [App\Http\Livewire\Assessor\AccountVerification::class, 'import_rpt'])->name('import_rpt');
    //Export
    Route::get('assessor/rpt/accounts/export/', [App\Http\Controllers\MainController::class, 'export_rpt'])->name('export_rpt');


    //Report
    Route::get('report/{id}', [ReportPDF::class, 'pdf'])->name('PDF');


    Route::get('reports', [App\Http\Controllers\MainController::class, 'reports'])->name('reports');
    Route::get('reports/rpt-delinquency/{date}', [App\Http\Controllers\ReportController::class, 'rpt_delinquency_report'])->name('rpt_delinquency_report');
    Route::get('reports/rpt-assessment-roll', [App\Http\Controllers\ReportController::class, 'rpt_assessment_roll_report'])->name('rpt_assessment_roll_report');
    Route::get('reports/rpt-collective/{year}', [App\Http\Controllers\ReportController::class, 'rpt_collective_report'])->name('rpt_collective_report');

    // Route::get('reports/view', [App\Http\Controllers\ReportController::class, 'index'])->name('sample');
    Route::get('reports/sample', [App\Http\Controllers\Controller::class, 'exportReport']);


    // Report
    Route::get('reports/preview', [App\Http\Controllers\ReportController::class,'delinquencyReports'])->name('report.preview');
    Route::get('reports/export/summary-of-delinquency',
        [Controller::class, 'summaryOfDelinquency'])->name('delinquency.summary');
});
