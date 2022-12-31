<?php

namespace App\Http\Controllers;

// PDF Report

use App\Models\RptAccount;
use App\Models\RptAssessedValue;
use Carbon\Carbon;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class ReportController extends Controller
{

    // REPORTS
    public function rpt_collective_report($date)
    {
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
        $dt = Carbon::create($date);

        $invoice = Invoice::make()
            ->template('rpt_collectibles_per_brgy')
            ->date($dt)
            ->dateFormat('Y')
            ->seller($client)
            ->buyer($customer)
            ->discountByPercent(10)
            ->taxRate(15)
            ->shipping(1.99)
            ->addItem($item)
            ->logo(public_path('img/lgulopezquezon.png'))
            ->save('public');
        return $invoice->stream();
    }

    public function rpt_assessment_roll_report()
    {
        // $delinquent_month_year = ['month'=>12, 'year'=>2022];
        // $taxDute = RptAccount::compute_tax_due($delinquent_month_year);
        // dd($taxDute);

        // dd($date);
        $year = new Party([
            'year'          => 'HERMES A. ARGANTE',
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

        $invoice = Invoice::make()
            ->template('rpt_assessment_roll')
            ->date(now()->subWeeks(3))
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
    }

    public function rpt_delinquency_report($date)
    {
        // $delinquent_month_year = ['month'=>12, 'year'=>2022];
        // $taxDute = RptAccount::compute_tax_due($delinquent_month_year);
        // dd($taxDute);

        // dd($date);
        $date_from = Carbon::create($date['from']);
        $date_to = Carbon::create($date['to']);


        // dd();
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

        $invoice = Invoice::make()
            ->template('rpt_delinquencies')
            ->date($date_from)
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
    }



    // public function pdf_report($data)
    // {
    //     $client = new Party([
    //         'name'          => 'Roosevelt Lloyd',
    //         'phone'         => '(520) 318-9486',
    //         'custom_fields' => [
    //             'note'        => 'IDDQD',
    //             'business id' => '365#GG',
    //         ],
    //     ]);

    //     $customer = new Party([
    //         'name'          => 'Ashley Medina',
    //         'address'       => 'The Green Street 12',
    //         'code'          => '#22663214',
    //         'custom_fields' => [
    //             'order number' => '> 654321 <',
    //         ],
    //     ]);

    //     $items = [
    //         (new InvoiceItem())
    //             ->title('Service 1')
    //             ->description('Your product or service description')
    //             ->pricePerUnit(47.79)
    //             ->quantity(2)
    //             ->discount(10),
    //         (new InvoiceItem())->title('Service 2')->pricePerUnit(71.96)->quantity(2),
    //         (new InvoiceItem())->title('Service 3')->pricePerUnit(4.56),
    //         (new InvoiceItem())->title('Service 4')->pricePerUnit(87.51)->quantity(7)->discount(4)->units('kg'),
    //         (new InvoiceItem())->title('Service 5')->pricePerUnit(71.09)->quantity(7)->discountByPercent(9),
    //         (new InvoiceItem())->title('Service 6')->pricePerUnit(76.32)->quantity(9),
    //         (new InvoiceItem())->title('Service 7')->pricePerUnit(58.18)->quantity(3)->discount(3),
    //         (new InvoiceItem())->title('Service 8')->pricePerUnit(42.99)->quantity(4)->discountByPercent(3),
    //         (new InvoiceItem())->title('Service 9')->pricePerUnit(33.24)->quantity(6)->units('m2'),
    //         (new InvoiceItem())->title('Service 11')->pricePerUnit(97.45)->quantity(2),
    //         (new InvoiceItem())->title('Service 12')->pricePerUnit(92.82),
    //         (new InvoiceItem())->title('Service 13')->pricePerUnit(12.98),
    //         (new InvoiceItem())->title('Service 14')->pricePerUnit(160)->units('hours'),
    //         (new InvoiceItem())->title('Service 15')->pricePerUnit(62.21)->discountByPercent(5),
    //         (new InvoiceItem())->title('Service 16')->pricePerUnit(2.80),
    //         (new InvoiceItem())->title('Service 17')->pricePerUnit(56.21),
    //         (new InvoiceItem())->title('Service 18')->pricePerUnit(66.81)->discountByPercent(8),
    //         (new InvoiceItem())->title('Service 19')->pricePerUnit(76.37),
    //         (new InvoiceItem())->title('Service 20')->pricePerUnit(55.80),
    //     ];

    //     $notes = [
    //         'your multiline',
    //         'additional notes',
    //         'in regards of delivery or something else',
    //     ];
    //     $notes = implode("<br>", $notes);

    //     $invoice = Invoice::make('receipt')
    //         ->template('rpt_delinquencies')
    //         // ->template('default')
    //         ->series('BIG')
    //         // ability to include translated invoice status
    //         // in case it was paid
    //         ->status(__('invoices::invoice.paid'))
    //         ->sequence(667)
    //         ->serialNumberFormat('{SEQUENCE}/{SERIES}')
    //         ->seller($client)
    //         ->buyer($customer)
    //         ->date(now()->subWeeks(3))
    //         ->dateFormat('m/d/Y')
    //         ->payUntilDays(14)
    //         ->currencySymbol('$')
    //         ->currencyCode('USD')
    //         ->currencyFormat('{SYMBOL}{VALUE}')
    //         ->currencyThousandsSeparator('.')
    //         ->currencyDecimalPoint(',')
    //         ->filename($client->name . ' ' . $customer->name)
    //         ->addItems($items)
    //         ->notes($notes)
    //         ->logo(public_path('img/lgulopezquezon.png'))
    //         // You can additionally save generated invoice to configured disk
    //         ->save('public');

    //     $link = $invoice->url();
    //     // Then send email to party with link

    //     // And return invoice itself to browser or have a different view
    //     return $invoice->stream();
    // }

}
