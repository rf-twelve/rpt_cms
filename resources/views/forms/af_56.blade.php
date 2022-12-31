<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.ico" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <style>
        @page {
            margin-top: 0in;
            margin-left: 0.5in;
            margin-right: 0.5in;
            margin-bottom: 0.25in;
            size: 8.5in 11in;
        }
        .wrapper{
            /* position: absolute; */
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
        }
        .row-1{
            position: absolute;
            width: 820px;
            top:4px;
        }
        .row-2{
            position: absolute;
            width: 820px;
            top:20px;
        }
        .row-3{
            font-size: 16px;
            position: absolute;
            width: 820px;
            top:78px;
        }
        .row-4{
            font-size: 14px;
            position: absolute;
            width: 820px;
            top:96px;
        }
        .row-5{
            font-size: 16px;
            position: absolute;
            width: 820px;
            top:128px;
        }
        .row-6{
            font-size: 16px;
            position: absolute;
            width: 820px;
            top:190px;
        }
        .row-7{
            font-size: 16px;
            position: absolute;
            width: 820px;
            top:275px;
        }
        .row-8{
            font-size: 16px;
            position: absolute;
            width: 820px;
            top:292px;
        }
        .row-9{
            font-size: 16px;
            position: absolute;
            width: 820px;
            top:315px;
        }
        .row-10{
            position: absolute;
            top:345px;
        }
        .row-11{
            position: absolute;
            top:378px;
        }

    </style>
</head>
<body>
<div class="wrapper" style="position:fixed;top:0">
  <!-- Main content -->
  <section class="invoice">
    <img style="position: fixed;z-index:-1;" src="{{ url('img\system\AF56.jpg') }}" width="820px" />
    {{-- First Row --}}
    <div class="row-1">
        <span style="margin-left: 310px">{{ $prev_trn }}</span>
    </div>
    <div class="row-1">
        <span style="margin-left: 435px">{{ $prev_date }}</span>
    </div>
    <div class="row-1" style="text-align: right; margin-left: 595px;width:200px;">
        {{-- <span style="">{{ $prev_for }}</span> --}}
    </div>
    {{-- Second Row --}}
    <div class="row-2" style="text-align:right;margin-left:710px;width:100px;">
        <span style="">TRN: {{ $trn }}</span>
    </div>
    {{-- Third Row --}}
    <div class="row-3">
        <span style="margin-left: 130px">{{ $province }}</span>
        <span style="margin-left: 130px">{{ $city }}</span>
        <span style="margin-left: 182px">{{ date('m/d/Y',strtotime($date)) }}</span>
    </div>
    {{-- Fourth Row --}}
    <div class="row-4" style="margin-top:1px;">
        <span style="margin-left: 186px">{{ $payee }}</span>
    </div>
    <div class="row-4" style="margin-left: 510px;max-width:200px;line-height:.5;">
        <span style="font-family:Tahoma-narrow;font-size:9px;">{{ $amount_words }}</span>
    </div>
    <div class="row-4" style="margin-left:730px;width:50px;margin-top:1px">
        <span style="font-family:Tahoma-narrow;font-size:9px;">{{ $amount }}</span>
    </div>
    {{-- Fifth Row --}}
    <div class="row-5">
        {{-- <span style="margin-left: 195px">{{ $for }}</span> --}}
    </div>
    <div class="row-5">
        <span style="margin-left: 418px">{{ '✔' }}</span>
    </div>
    <div class="row-5">
        <span style="margin-left: 552px">{{ '✔' }}</span>
    </div>
    {{-- Six Row --}}
    <div class="row-6" style="margin-left:5px;max-width: 90px;">
        <span style="font-size:10px;">
            {{ $owner_name }}
        </span>
    </div>
    <div class="row-6" style="margin-left:98px; max-width:99px;">
        <span style="font-size:10px;">
            {{ $location }}
        </span>
    </div>
    <div class="row-6" style="margin-left:200px; max-width: 150px;">
        <span style="font-size:10px;">
            {{ $tdn }}
        </span>
    </div>
    {{ dump($computations) }}
    <div class="row-6" style="margin-left:448px; max-width: 45px;text-align:right;">
        <span style="font-size:10px;">{{ number_format($total_av,0, '.', ',') }}</span>
    </div>
    <div class="row-6" style="margin-left:493px; max-width: 44px;text-align:right;">
        <span style="font-size:10px;">{{ number_format($tax_due,0, '.', ',') }}</span>
    </div>
    <div class="row-6" style="margin-left:549px; max-width: 10px;text-align:right;">
        <span style="font-size:10px;">{{ $installment_no }}</span>
    </div>
    <div class="row-6" style="margin-left:565px; max-width: 40px;text-align:right;">
        <span style="font-size:10px;">{{ $installment_year }}</span>
    </div>
    <div class="row-6" style="margin-left:620px; max-width: 40px;text-align:right;">
        <span style="font-size:10px;">{{ number_format($full_payment,0, '.', ',') }}</span>
    </div>
    <div class="row-6" style="margin-left:672px; max-width: 40px;text-align:right;">
        <span style="font-size:10px;">({{ number_format($discount_penalty,2, '.', ',') }})</span>
    </div>
    <div class="row-6" style="margin-left:750px; max-width: 40px;text-align:right;">
        <span style="font-size:10px;">{{ number_format($subtotal,2, '.', ',') }}</span>
    </div>

    {{-- Seven Row --}}
    <div class="row-7" style="margin-left:650px; width: 50px;text-align:right;">
        <span style="">BASIC:</span>
    </div>
    <div class="row-7" style="margin-left:700px; width: 92px;text-align:right;">
        <span style="">{{ number_format($basic,2, '.', ',') }}</span>
    </div>
    {{-- Eight Row --}}
    <div class="row-8" style="margin-left:650px; width: 50px;text-align:right;">
        <span style="">SEF:</span>
    </div>
    <div class="row-8" style="margin-left:700px; width: 92px;text-align:right;">
        <span style="">{{ number_format($sef,2, '.', ',') }}</span>
    </div>
    {{-- Nine Row --}}
    <div class="row-9" style="margin-left:650px; width: 50px;text-align:right;">
        <span style="">TOTAL:</span>
    </div>
    <div class="row-9" style="margin-left:700px; width: 92px;text-align:right;">
        <span style="">{{ number_format($grand_total,2, '.', ',') }}</span>
    </div>
    {{-- Tenth Row --}}
    <div class="row-10" style="margin-left:585px;width: 200px;text-align:center;">
        <span style="font-size:10px">{{ $person_treas }}</span>
    </div>
    {{-- Tenth Row --}}
    <div class="row-11" style="margin-left:585px;width: 200px;text-align:center;">
        <span style="font-size:10px">{{ $person_deputy }}</span>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->

<script type="text/javascript">
//   window.addEventListener("load", window.print());
</script>
</body>

</html>
