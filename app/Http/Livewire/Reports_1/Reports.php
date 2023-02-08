<?php

namespace App\Http\Livewire\Reports;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

// PDF Report
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class
Reports extends Component
{
    public $delinquent_year_from = null;
    public $delinquent_year_to = null;
    public $brgy_collectible_year = '';

    // Open deliquency
    public function open_rpt_deliquency(){
        if (is_null($this->delinquent_year_from) || empty($this->delinquent_year_from)
        || is_null($this->delinquent_year_to) || empty($this->delinquent_year_to)) {
            $this->dispatchBrowserEvent('swalEmptyField');
        } else {
            // $delinquent_date = [
            //     'from' => $this->delinquent_year_from,
            //     'to' => $this->delinquent_year_to,
            // ];
            // return redirect()->to(url('reports/rpt-delinquency/'. $delinquent_date));
            $this->rpt_delinquency_report();

        }
    }

    // Open Assessment Roll Report
    public function open_assessment_roll(){
        return redirect()->to(url('reports/rpt-assessment-roll'));
    }

    // Open Collectible per barangay report
    public function open_rpt_collective(){
        if (is_null($this->brgy_collectible_year) || empty($this->brgy_collectible_year)){
            $this->dispatchBrowserEvent('swalEmptyField');
        } else {
            // return redirect()->to(url('reports/rpt-collective/'.$this->brgy_collectible_year));
            // return redirect()->to(url('reports/rpt-collective/'.$this->brgy_collectible_year));
            $this->rpt_delinquency_report();
        }

    }

    public function rpt_delinquency_report()
    {
        // dd('de');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();
        $date_to = Carbon::create($this->delinquent_year_from);


        // dd($this->delinquent_year_from);
        $item = new Party([
            'from'          => 'HERMES A. ARGANTE',
            'to'         => 'Municipal Treasurer',
        ]);
        $client = new Party([
            'name'          => 'HERMES A. ARGANTE',
            'position'         => 'Municipal Treasurer',
            'phone'         => 'N/A',
            'custom_fields' => [
                'note'        => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);

        $customer = new Buyer([
            'name'          => 'RPT ACCOUNT',
            'custom_fields' => [
                'contact' => '123',
            ],
        ]);

        $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);
        // $item = (new InvoiceItem())->title('Service 1')->pricePerUnit(2);

        $invoice = Invoice::make()
            ->template('rpt_delinquencies')
            ->date($date_to)
            ->dateFormat('M d, Y')
            ->seller($client)
            ->buyer($customer)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(1.99)
            ->addItem($item)
            ->logo(public_path('img/lgulopezquezon.png'))
            ->save('public');
            return $invoice->stream();
        // return $invoice->stream();
        // return Invoice::make()->template('rpt_delinquencies')->buyer($customer)->addItem($item)->stream();
    }



    public function render()
    {
        dd('hello');
        return view('livewire.reports.reports');
    }
}
