<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('livewire.reports.preview');
    }

    public function exportReport()
    {
        $categories = ['cat','dog'];
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('livewire.reports.export.summary-of-rpt-delinquencies-per-brgy');
        return $pdf->stream();
    }
}
