<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\TblPerson;
use \Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{

    public function index()
    {
        // $date_now = date("Y-m-d");
        // $date_end = date('Y-m-d', strtotime('5 month'));
        // $data = collect(DB::table('inventories')->get('in_exp'));
        // $user = collect(DB::table('users')->get('id'));
        // $supplier = collect(DB::table('suppliers')->get('id'));
        // $client = collect(DB::table('clients')->get('id'));
        // $dash_prod = $data->count();
        // $dash_avail = $data->where('in_exp', '>', $date_end)->count();
        // $dash_near = $data->where('in_exp', '>', $date_now)->where('in_exp', '<=', $date_end)->count();
        // $dash_exp = $data->where('in_exp', '<=', $date_now)->count();;
        // $dash_supp = $supplier->count();
        // $dash_client = $client->count();



        // $encoders = DB::table('users')->get(['firstname', 'lastname']);

        // $data = collect(DB::table('people')->get(['category', 'consent', 'res_barangay', 'encoder']));
        // $number = 0;
        // foreach ($encoders as $encode) {
        //     $number++;
        //     $dataCount[$number] = $data->where('encoder', 'like', $encode->firstname)->count();
        //     $dataArray[] = [$dataCount[$number], $encode->firstname, $encode->lastname];
        // }
        // sort($dataArray);
        // $sortEncoded = collect($dataArray)->reverse();

        // $dash_a1 = $data->where('category', 'like', 'A1')->count();
        // $dash_a1_8 = $data->where('category', 'like', 'A1.8')->count();
        // $dash_a1_9 = $data->where('category', 'like', 'A1.9')->count();
        // $dash_a2 = $data->where('category', 'like', 'A2')->count();
        // $dash_a3 = $data->where('category', 'like', 'A3')->count();
        // $dash_a4 = $data->where('category', 'like', 'A4')->count();
        // $dash_a5 = $data->where('category', 'like', 'A5')->count();
        // $dash_rop = $data->where('category', 'like', 'ROP')->count();



        // $dash_individuals = $data->count();
        // $barangays = collect(DB::table('barangays')->get(['id', 'brgy_code', 'brgy_code_name', 'brgy_name', 'brgy_est_pop']));
        // $vaccinated = collect(DB::table('vaslists')->get(['id', 'vas_barangay', 'vas_first_name', 'vas_mid_name', 'vas_last_name', 'vas_dose_1st', 'vas_dose_2nd']));
        // $total_est_pop = $barangays->sum('brgy_est_pop');
        // $y = 0;
        // $temp = 0;
        // $tempCountFirst = 0;
        // $tempCountSecond = 0;
        // foreach ($barangays as $brgy) {
        //     $y++;
        //     $countBrgy[$y] = $data->where('res_barangay', 'like', $brgy->brgy_name)->count();
        //     $countFirstDose[$y] = $vaccinated->where('vas_barangay', 'like', $brgy->brgy_name)
        //         ->where('vas_dose_1st', 'like', 'Y')->count();
        //     $countSecondDose[$y] = $vaccinated->where('vas_barangay', 'like', $brgy->brgy_name)
        //         ->where('vas_dose_2nd', 'like', 'Y')->count();


        //     $prog_indicator = $countFirstDose[$y] * 100 / $countBrgy[$y];
        //     $arrayBrgy[] = [$countBrgy[$y], $brgy->brgy_name, $countFirstDose[$y], $countSecondDose[$y], $brgy->brgy_est_pop, $prog_indicator];
        //     $tempCountFirst = $tempCountFirst + $countFirstDose[$y];
        //     $tempCountSecond = $tempCountSecond + $countSecondDose[$y];
        //     $temp = $temp + $countBrgy[$y];
        // }
        // $total_first_dose = $tempCountFirst;
        // $total_second_dose = $tempCountSecond;
        // $total_reg = $temp;
        // $total_est_pop = collect($barangays)->sum('brgy_est_pop');
        // $people = TblPerson::all();

        // return view('welcome', compact(
        //     'people',

        // ));

        return view('welcome');
    }
}
