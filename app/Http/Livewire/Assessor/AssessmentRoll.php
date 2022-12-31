<?php

namespace App\Http\Livewire\Assessor;

use App\Exports\RptAccountExportAll;
use App\Imports\RptAssessmentRollImport;
use App\Models\ListBarangay;
use App\Models\ListMunicity;
use App\Models\ListProvince;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AssmtRollAccount as ModAssmtRollAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use Livewire\Component;

class AssessmentRoll extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rptExcellFile;
    public $perPage = 10;
    public $sortBy = 'assmt_roll_pin';
    public $sortType = 'asc';
    public $searchType = 'assmt_roll_pin';
    public $searchTerm = '';
    public $searchProvince = '';
    public $searchMunicipality = '';
    public $searchBarangay = '';
    public $upload_file;
    public $toggleDuplicateSelected1;
    public $toggleDuplicateSelected2;
    public $toggleDuplicateSelected3;
    public $toggleVerified4;
    public $toggleUnVerified5;
    public $findDuplicates = null;
    public $rptAccountTable;

    protected $listeners = [
        'assessmentRollRefresh' => '$refresh',
    ];

    public function createRecord()
    {
        $this->emit('addRecordRegistry');
        $this->reset();
    }

    public function viewRecord($id)
    {
        $data = $this->searchRPTAccount($id);
        $this->emit('viewRecordRegistry', $data);
        $this->reset();
    }

    // Find Duplicate PIN
    public function findDuplicatePin()
    {
    return ModAssmtRollAccount::select('assmt_roll_pin')
        ->groupBy('assmt_roll_pin')
        ->havingRaw('count(*) > 1')
        ->where('assmt_roll_pin','!=','')
        ->get();
    }

    // Find Duplicate TD/ARP
    public function findDuplicateTdArp()
    {
    return ModAssmtRollAccount::select('assmt_roll_td_arp_no')
        ->groupBy('assmt_roll_td_arp_no')
        ->havingRaw('count(*) > 1')
        ->where('assmt_roll_pin','!=','')
        ->get();
    }

    // Find Duplicate PIN + TD/ARP
    public function findDuplicatePinTdArp()
    {
    return ModAssmtRollAccount::select('assmt_roll_pin','assmt_roll_td_arp_no')
        ->groupBy('assmt_roll_pin','assmt_roll_td_arp_no')
        ->havingRaw('count(*) > 1')
        ->where('assmt_roll_pin','!=','')
        ->get();
    }

    // Find Record where status is verified
    public function findVerifiedStatus()
    {
    return ModAssmtRollAccount::select('id')
        ->where('assmt_roll_status','verified')
        ->get();
    }
    // Find Record where status is unverified
    public function findUnVerifiedStatus()
    {
    return ModAssmtRollAccount::select('id')
        ->where('assmt_roll_status','new')->get();
    }

    public function getDuplicates($value)
    {
        switch ($value) {
            case 1:
                $this->findDuplicates = DB::table('assmt_roll_accounts')
                ->select('id','assmt_roll_td_arp_no','assmt_roll_pin','assmt_roll_owner','assmt_roll_address','assmt_roll_status')
                ->whereIn('assmt_roll_pin',$this->findDuplicatePin())->orderBy('assmt_roll_pin', 'asc')->get();
                break;
            case 2:
                $this->findDuplicates = DB::table('assmt_roll_accounts')
                ->select('id','assmt_roll_td_arp_no','assmt_roll_pin','assmt_roll_owner','assmt_roll_address','assmt_roll_status')
                ->whereIn('assmt_roll_td_arp_no',$this->findDuplicateTdArp())->orderBy('assmt_roll_td_arp_no', 'asc')->get();
                break;
            case 3:
                $this->findDuplicates = DB::table('assmt_roll_accounts')
                ->select('id','assmt_roll_td_arp_no','assmt_roll_pin','assmt_roll_owner','assmt_roll_address','assmt_roll_status')
                ->whereIn('assmt_roll_pin',$this->findDuplicatePinTdArp())->orderBy('assmt_roll_td_arp_no', 'asc')->orderBy('assmt_roll_pin', 'asc')->get();
                break;
            case 4:
                // dd($this->findVerifiedStatus());
                $this->findDuplicates = DB::table('assmt_roll_accounts')
                ->select('id','assmt_roll_td_arp_no','assmt_roll_pin','assmt_roll_owner','assmt_roll_address','assmt_roll_status')
                ->whereIn('id',$this->findVerifiedStatus())->orderBy('assmt_roll_td_arp_no', 'asc')->orderBy('assmt_roll_pin', 'asc')->get();
                break;
            case 5:
                $this->findDuplicates = ModAssmtRollAccount::select('id','assmt_roll_td_arp_no','assmt_roll_pin','assmt_roll_owner','assmt_roll_address','assmt_roll_status')
                ->where('assmt_roll_status','new')->get();
                break;
            default:
                # code...
                break;
        }
    }


    public function import_assessment(Request $request)
    {

        $request->validate([
            'rpt_excell' => 'required|max:25000|mimes:xlsx,xls',
        ]);

        $file = $request->file('rpt_excell');
        Excel::import(new RptAssessmentRollImport, $file);
        // Excel::import(new RptAccountImport, request()->file($this->rptExcellFile));
        return redirect()->back();
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

    public function deleteSingleRecord($id)
    {
        $person = ModAssmtRollAccount::findOrFail($id);
        $person->delete();
        $this->dispatchBrowserEvent('swalDelete');
        $this->reset();
    }

    public function export_rpt()
    {
        return Excel::download(new RptAccountExportAll, 'RPT Accounts.xlsx');
    }

    // Find record
    public function searchRPTAccount($id)
    {
        $data = ModAssmtRollAccount::findOrFail($id);
        return $data;
    }

    public function render()
    {
        return view('livewire.assessor.assessment-roll')->with(([
            'rptAccountDuplicates' => $this->findDuplicates,
            'rptAccount' => DB::table('assmt_roll_accounts')
                ->where(function ($query) {
                    $query->where($this->searchType, 'like', '%' . $this->searchTerm . '%')
                        ->where('assmt_roll_brgy', 'like', '%' . $this->searchBarangay . '%')
                        ->where('assmt_roll_municity', 'like', '%' . $this->searchMunicipality . '%')
                        ->where('assmt_roll_province', 'like', '%' . $this->searchProvince . '%');
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
