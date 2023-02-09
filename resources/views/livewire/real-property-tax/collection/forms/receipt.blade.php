<div>
    <style>
        @page {
            margin-top: 0in;
            margin-left: 0in;
            margin-right: 0in;
            margin-bottom: 0in;
            background-color: red;
        }
        @media print {

            .no-print{
                display: none;!important
            }
            .wrapper{
                right:0px;
            /* left:0px; */
                top: 0px;
                transform: rotate(90deg);

            }
        }

        .wrapper{
            position: absolute;

            /* bottom: 0px; */
            /* rotate: 90deg; */
            font-family: 'Times New Roman', Times, serif;
            font-size: 18px;
            /* size: 10in 5in; */

        }
        .invoice{
            /* background: rgb(236, 84, 84); */
            /* width: 11in; */
        }
        .row-1{
            position: absolute;
            width: 15in;
            top:31px;
        }
        .image-size{
            /* width: 5.5in; */
            /* height: 5in; */
        }
        .row-2{
            position: absolute;
            width: 15in;
            top:55px;
        }
        .row-3{
            font-size: 22px;
            position: absolute;
            width: 15in;
            top:148px;
        }
        .row-4{
            position: absolute;
            width: 15in;
            top:178px;
        }
        .row-5{
            font-size: 18px;
            position: absolute;
            width: 15in;
            top:238px;
        }
        .row-6{
            font-size: 20px;
            position: absolute;
            width: 15in;
            top:330px;
        }
        .row-7{
            font-size: 20px;
            position: absolute;
            width: 15in;
            top:350px;
        }
        .row-8{
            font-size: 16px;
            position: absolute;
            width: 15in;
            top:300px;
        }
        .row-9{
            font-size: 14px;
            position: absolute;
            width: 15in;
            top:520px;
        }
        .row-10{
            position: absolute;
            top:560px;
        }
        .row-11{
            position: absolute;
            top:590px;
        }
        .row-12{
            position: absolute;
            top:680px;
        }
        .adjust-button{
            border: 1px;
            border-radius:20%;
            border-color: gray;
            background: rgb(230, 225, 225);
            font-style: bold;
            font-size: 16px;
            /* padding: 1px; */
        }
        .img-size{
            /* size: 10in 10in; */
            margin: 0;
        }
        img {
            position: fixed;
            z-index:-1;
        }
    </style>
    <div class="wrapper">
        <img width="{{ $array_size }}px" class="img-size {{ $is_background ? '' : 'no-print' }}" src="http://localhost/RPT_CMS/public/img/system/AF56.jpg">
    {{-- <div style="background-image: {{ url('img\system\AF56.jpg') }}" class="wrapper"> --}}
    <!-- Main content -->
    {{-- <section class="invoice"> --}}
        {{-- <img class="image-size image-print-size {{ $is_background ? 'no-print' : '' }}" style="position: fixed;z-index:-1;" src="{{ url('img\system\AF56.jpg') }}" /> --}}
        {{-- First Row --}}
        <div class="row-1">
            <span style="margin-left: 540px">{{ $receipt->prev_trn }}</span>
        </div>
        <div class="row-1">
            <span style="margin-left: 730px">{{ date('m/d/Y',strtotime($receipt->prev_date))}}</span>
        </div>
        <div class="row-1" style="margin-left: 980px;width:200px;">
            <span style="">{{ $receipt->prev_for }}</span>
        </div>
        {{-- Second Row --}}
        <div class="row-2" style="margin-left: 1050px;font-size: 16px;">
            <span style="">TRN: {{ $receipt->trn }}</span>
        </div>
        {{-- Third Row --}}
        <div class="row-3" width="1000px">
            <span style="margin-left: 260px">{{ $receipt->province }}</span>
            <span style="margin-left: 260px">{{ $receipt->city }}</span>
            <span style="margin-left: 300px">{{ date('m/d/Y',strtotime($receipt->date)) }}</span>
        </div>
        {{-- Fourth Row --}}
        <div class="row-4" style="margin-top:1px;">
            <span style="margin-left: 350px">{{ $receipt->payee }}</span>
        </div>
        <div class="row-4" style="margin-left: 830px;width:190px;">
            <span style="font-size:9px;font-weight: 900;">{{ $receipt->amount_words }}</span>
        </div>
        <div class="row-4" style="margin-left:1180px;width:85px;margin-top:1px;text-align:center">
            <span style="font-family:Tahoma-narrow;font-size:18px;">{{ number_format($receipt->amount,2,'.',',') }}</span>
        </div>
        {{-- Fifth Row --}}
        <div class="row-5">
            <span style="margin-left: 440px">{{ $receipt->for }}</span>
        </div>
        <div class="row-5">
            <span style="margin-left: 695px">{{ $receipt->is_basic ? '✔' : '' }}</span>
        </div>
        <div class="row-5">
            <span style="margin-left: 905px">{{ $receipt->is_sef ? '✔' : '' }}</span>
        </div>
        {{-- Six Row --}}
        <div class="row-6" style="margin-left:48px;width: 90px;">
            <span style="font-size:16px;">
                {{ $receipt->owner_name }}
            </span>
        </div>
        <div class="row-6" style="margin-left:136px;width:250px;">
            <span style="font-size:16px;">
                {{ $receipt->location }}
            </span>
        </div>
        <div class="row-6" style="margin-left:250px;width:200px;text-align:center">
            <span style="font-size:16px;">
                {{ $receipt->tdn }}
            </span>
        </div>

        @if (count($receipt->receipt_datas) > 0)
        @foreach ($receipt->receipt_datas as $computation)
            {{-- <div style="top:{{ $initial_top }}px;position:absolute;margin-left:840px; width: 60px;text-align:right;">
                <span style="font-size:16px;">{{ number_format($computation['av'],2, '.', ',') }}</span>
            </div>
            <div style="top:{{ $initial_top }}px;position:absolute;margin-left:900px; width: 60px;text-align:right;">
                <span style="font-size:16px;">{{ number_format($computation['td'],2, '.', ',') }}</span>
            </div> --}}
            <div style="top:{{ $initial_top }}px;position:absolute;margin-left: 960px; width: 98px;text-align:right;">
                <span style="font-size:14px;">{{ $computation['label'] }}</span>
            </div>
            {{-- <div sttop:{{ $initial_top }}px;yle="posiion: absolute;margin-left:565px; width: 40px;text-align:right;">
                <span style="font-size:16px;">{{ $computation[''] }}</span>
            </div> --}}
            <div style="top:{{ $initial_top }}px;position:absolute;margin-left:1070px; width: 60px;text-align:right;">
                <span style="font-size:16px;">{{ number_format($computation['total_td'],2, '.', ',') }}</span>
            </div>
            <div style="top:{{ $initial_top }}px;position:absolute;margin-left:1150px; width: 60px;text-align:right;">
                <span style="font-size:16px;">({{ number_format($computation['penalty'],2, '.', ',') }})</span>
            </div>
            <div style="top:{{ $initial_top }}px;position:absolute;margin-left:1220px; width: 60px;text-align:right;">
                <span style="font-size:16px;">{{ number_format($computation['subtotal'],2, '.', ',') }}</span>
            </div>
            @php
                $initial_top = $initial_top + $array_gap;
                $initial_sef = $initial_sef + $computation['subtotal'];
            @endphp
        @endforeach
            @php
                $initial_total = ($initial_total + $initial_sef)*2;
            @endphp

        @endif
        <div style="top:{{ $initial_top }}px;position:absolute;margin-left:1000px; width: 45px;text-align:right;">
            <span style="font-size:16px;">{{ 'SEF' }}</span>
        </div>
        <div style="top:{{ $initial_top }}px;position:absolute;margin-left:1230px; width: 60px;text-align:right;">
            <span style="font-size:16px;">{{ number_format($initial_sef,2, '.', ',') }}</span>
        </div>

        <div class="row-9" style="margin-left:1000px; width: 50px;text-align:right;">
            <span style="font-size:16px;">TOTAL:</span>
        </div>
        <div class="row-9" style="margin-left:1200px; width: 92px;text-align:right;">
            <span style="font-size:16px;">P {{ number_format($receipt->amount,2,'.',',') }}</span>
        </div>
        {{-- Tenth Row --}}
        <div class="row-10" style="margin-left:1040px;width: 200px;text-align:center;">
            <span style="font-size:16px">{{ $receipt->user_treasurer }}</span>
        </div>
        {{-- Tenth Row --}}
        <div class="row-11" style="margin-left:1040px;width: 200px;text-align:center;">
            <span style="font-size:16px">{{ $receipt->user_deputy }}</span>
        </div>
        {{-- BUTTONS --}}
        <div class="row-12 no-print" style="margin-left:100px;width:200px;">
            <button wire:click="minusGap" type="button" class="adjust-button">-</button>
            <button wire:click="addGap" type="button" class="adjust-button">+</button>
            <span>(Gap Adjust : {{ $array_gap }})</span>
        </div>
        <div class="row-12 no-print" style="margin-left:300px;width:200px;">
            <button wire:click="minusSize" type="button" class="adjust-button">-</button>
            <button wire:click="addSize" type="button" class="adjust-button">+</button>
            <span>(Size Adjust : {{ $array_size }})</span>
        </div>
        <div class="row-12 no-print" style="margin-left:500px;width:200px;">
            <input wire:model="is_background" type="checkbox" />
            <span style="margin-left:0px;">(Background Print)</span>
        </div>
        <div class="row-12 no-print" style="margin-left:700px;width:200px;">
            <button onclick="window.print()">Print receipt</button>
        </div>
        <!-- /.row -->
    <!-- ./wrapper -->

    <script type="text/javascript">
    //   window.addEventListener("load", window.print());
    </script>
    </div>
</div>
