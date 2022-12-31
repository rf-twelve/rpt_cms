<?php

namespace App\Http\Livewire\Forms;

use Livewire\Component;

class SettingBasic extends Component
{
    public $updateOn = false;
    public $data_id;
    public $yb_from, $yb_to, $years_no;

    protected $listeners = [
        'refreshForm' => '$refresh',
        'addRecordBasic' => 'addRecordBasicEvent',
        'viewRecordBasic' => 'viewRecordBasicEvent'
    ];

    public function addRecordBasicEvent()
    {
        $this->dispatchBrowserEvent('setBasicOpen');
        $this->resetFields();
        $this->emitSelf('refreshForm');
    }

    public function viewRecordBasicEvent($data)
    {
        $this->updateOn = true;
        $this->dispatchBrowserEvent('setBasicOpen');
        $this->setFields($data);
        $this->emitSelf('refreshForm');
    }

    public function updateRecord()
    {
    }
    public function saveRecord()
    {
    }
    public function closeRecord()
    {
        $this->resetFields();
        $this->dispatchBrowserEvent('setBasicClose');
    }


    public function render()
    {
        return view('livewire.forms.setting-basic');
    }

    public function setFields($data)
    {
        $this->yb_from = $data['yb_from'];
        $this->yb_to = $data['yb_to'];
        $this->years_no = $data['years_no'];
    }

    public function resetFields()
    {
        $this->yb_from = '';
        $this->yb_to = '';
        $this->years_no = '';
    }
}
