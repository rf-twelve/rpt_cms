<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{

      // AF # 56
      public function af_56(Request $request)
      {
        dd($request);
        parse_str($request, $output);
        $dataArray = $output['aParam'];

        // dd($dataArray);
        return view('forms/af_56',$dataArray);
      }

      // RPT REPORTS
      public function delinquency_report()
      {
          return view('main')
              ->with([
                  'component' => 'real-property-tax.reports.delinquency',
                  'id' => ''
              ]);
      }
      public function assessment_roll_report()
      {
          return view('main')
              ->with([
                  'component' => 'real-property-tax.reports.assessment-roll',
                  'id' => ''
              ]);
      }
      public function collectible_report()
      {
          return view('main')
              ->with([
                  'component' => 'real-property-tax.reports.collectible',
                  'id' => ''
              ]);
      }
      public function collections_and_deposits_report()
      {
          return view('main')
              ->with([
                  'component' => 'real-property-tax.reports.collections-and-deposits',
                  'id' => ''
              ]);
      }

}
