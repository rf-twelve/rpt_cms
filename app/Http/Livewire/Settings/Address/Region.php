<?php

namespace App\Http\Livewire\Settings\Address;

use App\Imports\ListRegionImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\ListRegion;
use Livewire\Component;

class Region extends Component
{

    public $data_index = null;
    public $data_values = [];
    public $input_fields;
    public $new_index;
    public $new_name;
    protected $rules = [
        'data_values.*.index' => ['required'],
        'data_values.*.name' => ['required']
    ];

    public function render()
    {
        return view('livewire.settings.address.region', [
            'data_tables' => $this->data_values,
        ]);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function mount()
    {
        $this->data_values = ListRegion::get()->toArray();
    }

    public function newRecord()
    {
        $this->new_index = '';
        $this->new_name = '';
        $this->input_fields = !$this->input_fields;
    }

    public function editRecord($index)
    {
        $this->data_index = $index;
    }

    public function deleteSingleRecord($id)
    {
        $record = ListRegion::findOrFail($id);
        $record->delete();
        $this->data_index = null;
        $this->mount();
        $this->dispatchBrowserEvent('swalDelete');
    }

    public function saveRecord()
    {
        Validator::make(
            ['index' => $this->new_index],
            ['index' => 'required'],
            ['required' => 'The :attribute field is required'],
        )->validate();

        Validator::make(
            ['name' => $this->new_name],
            ['name' => 'required'],
            ['required' => 'The :attribute field is required'],
        )->validate();

        ListRegion::create([
            'code' => null,
            'index' => $this->new_index,
            'name'  => $this->new_name,
            'is_active' => 1
        ]);
        $this->input_fields = false;
        $this->mount();
        $this->dispatchBrowserEvent('swalSuccess');
    }

    public function updateRecord($id, $index)
    {
        $data_validated = $this->validate();
        // $assessed_value = RptAssessedValue::where('id', $av_index)
        //     ->select('id', 'av_year_from', 'av_year_to', 'av_value')->get()->toArray() ?? NULL;
        if (!is_null($data_validated)) {
            $record = ListRegion::find($id);
            if ($record) {
                $record->update([
                    'index' => $data_validated['data_values'][$index]['index'],
                    'name' => strtoupper($data_validated['data_values'][$index]['name']),
                ]);
            }
        }
        $this->data_index = null;
        $this->mount();
        $this->dispatchBrowserEvent('swalUpdate');
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
}
