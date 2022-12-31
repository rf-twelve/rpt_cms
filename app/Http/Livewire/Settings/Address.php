<?php

namespace App\Http\Livewire\Settings;

use App\Imports\ListBarangayImport;
use App\Imports\ListMunicityImport;
use App\Imports\ListProvinceImport;
use App\Imports\ListRegionImport;
use Livewire\Component;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Address extends Component
{
    public function render()
    {
        return view('livewire.settings.address');
    }

    public function import_regions(Request $request)
    {
        $request->validate([
            'rpt_excell' => 'required|max:25000|mimes:xlsx,xls',
        ]);
        $file = $request->file('rpt_excell');
        Excel::import(new ListRegionImport, $file);

        // Excel::import(new RptAccountImport, request()->file($this->rptExcellFile));
        return redirect()->back();
    }

    public function import_provinces(Request $request)
    {
        $request->validate([
            'rpt_excell' => 'required|max:25000|mimes:xlsx,xls',
        ]);
        $file = $request->file('rpt_excell');
        Excel::import(new ListProvinceImport, $file);

        // Excel::import(new RptAccountImport, request()->file($this->rptExcellFile));
        return redirect()->back();
    }

    public function import_municities(Request $request)
    {
        $request->validate([
            'rpt_excell' => 'required|max:25000|mimes:xlsx,xls',
        ]);
        $file = $request->file('rpt_excell');
        Excel::import(new ListMunicityImport, $file);

        // Excel::import(new RptAccountImport, request()->file($this->rptExcellFile));
        return redirect()->back();
    }

    public function import_barangays(Request $request)
    {
        $request->validate([
            'rpt_excell' => 'required|max:25000|mimes:xlsx,xls',
        ]);
        $file = $request->file('rpt_excell');
        Excel::import(new ListBarangayImport, $file);

        // Excel::import(new RptAccountImport, request()->file($this->rptExcellFile));
        return redirect()->back();
    }
}
