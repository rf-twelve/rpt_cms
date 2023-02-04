<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PeopleExport;
use App\Exports\RptAccountExportAll;
use App\Exports\VasExport;
use App\Imports\RptAccountImport;
use App\Imports\UsersImport;
use \Maatwebsite\Excel\Facades\Excel;
use PDF;

// PDF Report
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class MainController extends Controller
{
    public function welcome()
    {
        return view('welcome');
    }

    public function dashboard(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'dashboard',
                'id' => ''
            ]);
    }


    // ASSESSOR
    public function assessor_assessment_roll(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'assessor.assessment-roll',
                'id' => ''
            ]);
    }



    public function rpt_account(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'rpt-account',
                'id' => ''
            ]);
    }
    public function rpt_ledger_entry($id)
    {
        return view('main')
            ->with([
                'component' => 'real-property-tax.accounts.ledger-entry',
                'id' => $id
            ]);
    }
    public function rpt_account_verification(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'real-property-tax.accounts.account-verification',
                'id' => ''
            ]);
    }


    // REPORTS
    public function rpt_delinquencies()
    {
        return view('main')
            ->with([
                'component' => 'reports.rpt-delinquencies',
                'id' => ''
            ]);
    }


    //////////////////////////////////////////////////////
    // REAL PROPERTY TAX

    public function rpt_collection_accounts(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'real-property-tax.collection.accounts',
                'id' => ''
            ]);
    }
    public function rpt_ledger_accounts(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'real-property-tax.ledger.accounts',
                'id' => ''
            ]);
    }
    public function rpt_ledger_forms_account($id)
    {
        return view('main')
            ->with([
                'component' => 'real-property-tax.ledger.forms.registry',
                'id' => $id
            ]);
    }
    public function rpt_delinquency_accounts(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'real-property-tax.delinquency.accounts',
                'id' => ''
            ]);
    }
    public function rpt_barangay_masterlists(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'real-property-tax.barangay.masterlists',
                'id' => ''
            ]);
    }


    public function ledger_view($id)
    {
        return view('main')
            ->with([
                'component' => 'ledger-view',
                'id' => $id
            ]);
    }

    public function employees(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'employees',
                'id' => ''
            ]);
    }
    public function candidates(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'candidates',
                'id' => ''
            ]);
    }
    public function leaderist(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'leaderist',
                'id' => ''
            ]);
    }
    public function collection_abstract(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'collection-abstract',
                'id' => ''
            ]);
    }

    public function idcards(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'idcards',
                'id' => ''
            ]);
    }


    public function form_52(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'forms.form52',
                'id' => ''
            ]);
    }
    public function form_53(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'forms.form53',
                'id' => ''
            ]);
    }
    public function form_57(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'forms.form57',
                'id' => ''
            ]);
    }
    public function form_58(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'forms.form58',
                'id' => ''
            ]);
    }
    public function form_0017(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'forms.form0017',
                'id' => ''
            ]);
    }

    // Settings
    public function settings_address(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'settings.address',
                'id' => ''
            ]);
    }
    public function settings_booklets(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'settings.booklet',
                'id' => ''
            ]);
    }
    public function settings_taxtables(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'settings.taxtables',
                'id' => ''
            ]);
    }
    public function settings_form(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'settings.form',
                'id' => ''
            ]);
    }
    public function settings_users(Request $request)
    {
        return view('main')
            ->with([
                'component' => 'settings.users',
                'id' => ''
            ]);
    }

    public function qrcode($id)
    {
        return view('main')
            ->with([
                'component' => 'qrcode',
                'id' => $id
            ]);
    }
    // Export Controller



    public function rpt_accountImport()
    {
        return Excel::import(new RptAccountImport, request()->file('your_file'));
        // return Excel::import(new RptAccountImport, 'RPT import.xlsx');
        // return Excel::download(new RPTAccountImport, 'Masterlist.xlsx');
    }
    public function rpt_accountExport()
    {
        return Excel::download(new RptAccountExportAll, 'RPT Accounts.xlsx');
    }

    public function masterlistExport()
    {
        return Excel::download(new PeopleExport, 'Masterlist.xlsx');
    }

    public function vasExport($selectedDate)
    {
        return Excel::download(new VasExport($selectedDate), 'VIMS-VAS.xlsx');
    }

    // Import & Export
    public function import_rpt(Request $request)
    {
        $request->validate([
            'rpt_excell' => 'required|max:10000|mimes:xlsx,xls',
        ]);

        $file = $request->file('rpt_excell');
        Excel::import(new RptAccountImport, $file);
        // $temp = "";
        // $path1 = $request->file('rpt_excell')->store('temp');
        // $path = storage_path('app') . '/' . $path1;
        // dd($file);
        // dd($request);
        // Excel::download(new RptAccountImport, $path);
        // Excel::download(new RptAccountImport, request()->file('import_file'));
        return back()->withStatus('Import done!');
    }

    public function export_rpt($selectedDate)
    {
        return Excel::download(new VasExport($selectedDate), 'VIMS-VAS.xlsx');
    }



    // REPORTS
    public function reports()
    {
        return view('main')
            ->with([
                'component' => 'reports.reports',
                'id' => ''
            ]);
    }
}
