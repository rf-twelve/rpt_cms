<?php

namespace App\Http\Livewire\RealPropertyTax\Accounts;

use App\Exports\RptAccountExportAll;
use App\Imports\RptAccountImport;
use App\Models\ListBarangay;
use App\Models\ListMunicity;
use App\Models\ListProvince;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\RptAccount as ModRptAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;

class AccountVerification extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rptExcellFile;
    public $perPage = 10;
    public $sortBy = 'rpt_pin';
    public $sortType = 'asc';
    public $searchType = 'rpt_pin';
    public $searchTerm = '';
    public $searchProvince = '';
    public $searchMunicipality = '';
    public $searchBarangay = '';
    public $upload_file;
    public $rpt_duplicates = 0;
    public $rpt_unverified = 0;
    public $toggleDuplicateSelected1;
    public $toggleDuplicateSelected2;
    public $toggleDuplicateSelected3;
    public $toggleVerified4;
    public $toggleUnVerified5;
    public $findDuplicates = null;

    protected $listeners = [
        'accountVerificationRefresh' => '$refresh',
    ];

    public function createRecord()
    {
        $this->emit('addRecord');
        $this->emitSelf('refreshParent');
    }

    public function viewRecord($id)
    {
        $data = $this->searchRPTAccount($id);
        $this->emit('viewRecord', $data);
        $this->emitSelf('refreshParent');
    }

    public function verifyRecord($id)
    {
        $data = $this->searchRPTAccount($id);
        $this->emit('verifyRecord', $data);
        $this->emitSelf('refreshParent');
    }

    public function viewAccount($id)
    {
        $data = $this->searchRPTAccount($id);
        $type = 'view';
        $this->emit('viewAccount', $data, $type);
        $this->emitSelf('refreshParent');
    }


    public function import_rpt(Request $request)
    {
        $request->validate([
            'rpt_excell' => 'required|max:25000|mimes:xlsx,xls',
        ]);
        $file = $request->file('rpt_excell');
        Excel::import(new RptAccountImport, $file);

        // Excel::import(new RptAccountImport, request()->file($this->rptExcellFile));
        return redirect()->back();
    }

    public function deleteSingleRecord($id)
    {
        $person = ModRptAccount::findOrFail($id);
        $person->delete();
        $this->dispatchBrowserEvent('swalDelete');
    }

    public function export_rpt()
    {
        return Excel::download(new RptAccountExportAll, 'RPT Accounts.xlsx');
    }

    // Find record
    public function searchRPTAccount($id)
    {
        $data = ModRptAccount::findOrFail($id);
        return $data;
    }

    // Find Duplicate PIN
    public function findDuplicatePin()
    {
    return ModRptAccount::select('rpt_pin')
        ->groupBy('rpt_pin')
        ->havingRaw('count(*) > 1')
        ->where('rpt_pin','!=','')
        ->get();
    }

    // Find Duplicate TD/ARP
    public function findDuplicateTdArp()
    {
    return ModRptAccount::select('rpt_td_no')
        ->groupBy('rpt_td_no')
        ->havingRaw('count(*) > 1')
        ->where('rpt_pin','!=','')
        ->get();
    }

    // Find Duplicate PIN + TD/ARP
    public function findDuplicatePinTdArp()
    {
    return ModRptAccount::select('rpt_pin','rpt_td_no')
        ->groupBy('rpt_pin','rpt_td_no')
        ->havingRaw('count(*) > 1')
        ->where('rpt_pin','!=','')
        ->get();
    }
    // Find Record where status is verified
    public function findVerifiedStatus()
    {
    return ModRptAccount::select('id')
        ->where('rtdp_status','verified')
        ->get();
    }
    // Find Record where status is unverified
    public function findUnVerifiedStatus()
    {
    return ModRptAccount::select('id')
        ->where('rtdp_status','new')->get();
    }

    public function getDuplicates($value)
    {
        switch ($value) {
            case 1:
                $this->findDuplicates = ModRptAccount::select('id','rpt_pin','rpt_kind','rpt_class','rpt_td_no','rpt_arp_no','ro_name','rtdp_tc_basic','rtdp_tc_sef','rtdp_tc_penalty','rtdp_tc_total','rtdp_payment_date','rtdp_or_no','rtdp_payment_covered_year','rtdp_status',)
                ->whereIn('rpt_pin',$this->findDuplicatePin())->orderBy('rpt_pin', 'asc')->get();
                break;
            case 2:
                $this->findDuplicates = ModRptAccount::select('id','rpt_pin','rpt_kind','rpt_class','rpt_td_no','rpt_arp_no','ro_name','rtdp_tc_basic','rtdp_tc_sef','rtdp_tc_penalty','rtdp_tc_total','rtdp_payment_date','rtdp_or_no','rtdp_payment_covered_year','rtdp_status',)
                ->whereIn('rpt_td_no',$this->findDuplicateTdArp())->orderBy('rpt_td_no', 'asc')->get();
                break;
            case 3:
                $this->findDuplicates = ModRptAccount::select('id','rpt_pin','rpt_kind','rpt_class','rpt_td_no','rpt_arp_no','ro_name','rtdp_tc_basic','rtdp_tc_sef','rtdp_tc_penalty','rtdp_tc_total','rtdp_payment_date','rtdp_or_no','rtdp_payment_covered_year','rtdp_status',)
                ->whereIn('rpt_pin',$this->findDuplicatePinTdArp())->orderBy('rpt_td_no', 'asc')->orderBy('rpt_pin', 'asc')->get();
                break;
            case 4:
                // dd($this->findVerifiedStatus());
                $this->findDuplicates = ModRptAccount::select('id','rpt_pin','rpt_kind','rpt_class','rpt_td_no','rpt_arp_no','ro_name','rtdp_tc_basic','rtdp_tc_sef','rtdp_tc_penalty','rtdp_tc_total','rtdp_payment_date','rtdp_or_no','rtdp_payment_covered_year','rtdp_status',)
                ->whereIn('id',$this->findVerifiedStatus())->orderBy('rpt_td_no', 'asc')->orderBy('rpt_pin', 'asc')->get();
                break;
            case 5:
                $this->findDuplicates = ModRptAccount::select('id','rpt_pin','rpt_kind','rpt_class','rpt_td_no','rpt_arp_no','ro_name','rtdp_tc_basic','rtdp_tc_sef','rtdp_tc_penalty','rtdp_tc_total','rtdp_payment_date','rtdp_or_no','rtdp_payment_covered_year','rtdp_status',)
                ->where('rtdp_status','new')->get();
                break;
            default:
                # code...
                break;
        }
    }

    public function toggleDuplicate1(Request $request)
    {
        $this->getDuplicates(1);
        $this->toggleDuplicateSelected1 =! $this->toggleDuplicateSelected1;
        $this->toggleDuplicateSelected2 = 0;
        $this->toggleDuplicateSelected3 = 0;
        $this->toggleVerified4 = 0;
        $this->toggleUnVerified5 = 0;
    }
    public function toggleDuplicate2(Request $request)
    {
        $this->getDuplicates(2);
        $this->toggleDuplicateSelected2 =! $this->toggleDuplicateSelected2;
        $this->toggleDuplicateSelected1 = 0;
        $this->toggleDuplicateSelected3 = 0;
        $this->toggleVerified4 = 0;
        $this->toggleUnVerified5 = 0;
    }
    public function toggleDuplicate3(Request $request)
    {
        $this->getDuplicates(3);
        $this->toggleDuplicateSelected3 =! $this->toggleDuplicateSelected3;
        $this->toggleDuplicateSelected1 = 0;
        $this->toggleDuplicateSelected2 = 0;
        $this->toggleVerified4 = 0;
        $this->toggleUnVerified5 = 0;
    }
    public function toggleVerified4(Request $request)
    {
        $this->getDuplicates(4);
        $this->toggleVerified4 =! $this->toggleVerified4;
        $this->toggleDuplicateSelected1 = 0;
        $this->toggleDuplicateSelected2 = 0;
        $this->toggleDuplicateSelected3 = 0;
        $this->toggleUnVerified5 = 0;
    }
    public function toggleUnVerified5(Request $request)
    {
        $this->getDuplicates(5);
        $this->toggleUnVerified5 =! $this->toggleUnVerified5;
        $this->toggleDuplicateSelected1 = 0;
        $this->toggleDuplicateSelected2 = 0;
        $this->toggleDuplicateSelected3 = 0;
        $this->toggleVerified4 = 0;
    }


    public function render()
    {
        $record = DB::table('rpt_accounts')
            ->select(DB::raw('count(*) as record_count, rpt_pin'))
            ->groupBy('rpt_pin')
            ->get();

        $this->rpt_duplicates =  $record->where('record_count', '>', 1)->count();
        $this->rpt_unverified =  DB::table('rpt_accounts')->where('rtdp_status', 'new')->count();;

        return view('livewire.real-property-tax.accounts.account-verification')->with(([
            'rptAccountDuplicates' => $this->findDuplicates,
            'rptAccount' => DB::table('rpt_accounts')
                ->where(function ($query) {
                    $query->where($this->searchType, 'like', '%' . $this->searchTerm . '%')
                    ->where('lp_brgy', 'like', '%' . $this->searchBarangay . '%')
                        ->where('lp_municity', 'like', '%' . $this->searchMunicipality . '%')
                        ->where('lp_province', 'like', '%' . $this->searchProvince . '%');
                })->orderBy($this->sortBy, $this->sortType)
                ->paginate($this->perPage),
            'list_province' => ListProvince::get(['name','index'])->toArray(),
            'list_municity' => ListMunicity::get(['name','index'])->toArray(),
            'list_barangay' => ListBarangay::get(['name','index'])->toArray(),
            'duplicatePin' => $this->findDuplicatePin()->count() ?? 0,
            'duplicateTdArp' => $this->findDuplicateTdArp()->count() ?? 0,
            'duplicatePinTdArp' => $this->findDuplicatePinTdArp()->count() ?? 0,
            'verifiedStatus' => $this->findVerifiedStatus()->count() ?? 0,
            'unverifiedStatus' => $this->findUnVerifiedStatus()->count() ?? 0,
        ]));
    }
}
