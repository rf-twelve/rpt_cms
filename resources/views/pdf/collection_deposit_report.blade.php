<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    <title>{{ config('app.name', 'PDF') }}</title>
    <style>
        @page {
            margin-top: 0.25in;
            margin-left: 0.5in;
            margin-right: 0.5in;
            margin-bottom: 0.25in;
            size: 8.5in 13in;
        }

        /* General
        -----------------------------------------------------------------------*/
        body {
            background-color: transparent;
            color: black;
            font-family: "verdana", "sans-serif";
            margin: 0px;
            padding-top: 0px;
            font-size: 1em;
        }

        @media print {
            p { margin: 2px; }
        }

        table {
            width:100%;
        }
        td {
            padding:2px;
        }

        .table-bordered{
            border: 1px solid black;
            border-collapse: collapse;
        }
        .table-bordered th
        {
            border: 1px solid black;
        }
        .table-bordered td, {
            border-right: 1px solid black;
            border-left: 1px solid black;
        }
        .right{
            text-align: right;
        }
        .center{
            text-align: center;
        }
        .bold{
            font-weight: bold;
        }
        .bordered {
            border: 1px solid black;
            border-collapse: collapse;
        }
        .underline {
            border-bottom: 1px solid black;
        }
        .leftline {
            border-left: 1px solid black;
        }
        .rightline {
            border-right: 1px solid black;
        }
        .spacing-1 {
            letter-spacing: 1px;
        }
        .spacing-2 {
            letter-spacing: 2px;
        }
        .tab {
            padding-left: 10px;
        }
        .p-2 {
            padding: 2px;
        }
        .p-4 {
            padding: 4px;
        }
        .w-50 {
            width: 50%;
        }
        .w-60 {
            width: 60%;
        }

    </style>
</head>

<body>
    <table class="bordered" style="font-size: 8px">
        <tbody>
            <tr>
                <td colspan="4" style="width:100%; line-height:190%" class="center">
                    <span style="font-size:10pt;">
                        <strong>
                            REPORT OF COLLECTION AND DEPOSIT
                        </strong>
                    </span><br>
                    <span style="font-size:8pt;" class="bold">LOPEZ, QUEZON</span><br>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width:50%;">
                    <span style="font-size:10pt;">Fund:</span>
                    <span style="font-size:10pt;">
                        <strong>GENERAL</strong>
                    </span>
                </td>
                <td colspan="2" style="width:50%" class="right">
                    <span style="font-size:10pt;">Date:</span>
                    <span style="font-size:10pt;padding-right:5pt;">{{ $selectedData['pay_date'] }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <span style="font-size:10pt;"><i>
                        Name of Accountable Officer:
                    </i></span>
                    <span style="font-size:10pt;"><strong>
                        {{ $selectedData['pay_teller'] }}
                    </strong></span>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="bordered" style="font-size: 9pt;border-collapse: collapse;">
        <tbody>
            <tr>
                <td colspan="4" class="left"><strong>A. COLLECTIONS</strong><br>
                    <span style="padding-left: 20pt;">1. For Collectors</span>
                </td>
            </tr>
            <tr>
                <td rowspan="2" class="bordered center" style="width: 15%;">TYPE (Form No.)</td>
                <td colspan="2" class="bordered center" style="width: 45%;">Official Reciept/Serial No.</td>
                <td rowspan="2" class="bordered center" style="width: 40%;">Amount</td>
            </tr>
            <tr>
                <td class="bordered center" style="width: 22%;">From</td>
                <td class="bordered center" style="width: 22%;">To</td>
            </tr>
            @forelse ($accountableData as $item)
                <tr>
                    <td class="bordered">{{ $item['form_no'] }}</td>
                    <td class="bordered center">{{ $item['serial_no_from'] }}</td>
                    <td class="bordered center">{{ $item['serial_no_to'] }}</td>
                    <td class="bordered right">
                        <img width="8px" src="{{ url('img/peso.png') }}"/>
                        <span><strong>{{ number_format($item['amount'],2,'.',',') }}</strong></span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="bordered">&nbsp;</td>
                    <td class="bordered center"></td>
                    <td class="bordered center"></td>
                    <td class="bordered right"></td>
                </tr>
            @endforelse
            <tr>
                <td class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
            </tr>
            <tr>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered"></td>
                <td class="bordered right">
                    <u>
                    <img width="8px" src="{{ url('img/peso.png') }}"/>
                    <span style="font-size: 10;"><strong>{{ number_format($grandTotal,2,'.',',') }}</strong></span>
                    </u>
                </td>
            </tr>

            <tr>
                <td colspan="4" class="left">
                    <span style="padding-left: 20pt;">2. For Liquidating Officers/Treasurers</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="bordered center">Name of Accountant Officer</td>
                <td class="bordered center">Report No.</td>
                <td class="bordered center">Amount</td>
            </tr>
            <tr>
                <td colspan="2" class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
            </tr>

            {{-- B. REMITANCE AND DEPOSIT --}}
            <tr>
                <td colspan="4" class="left">
                    <strong>B. REMITANCES/DEPOSITS</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="bordered center">Accountable Officer/Bank</td>
                <td class="bordered center">Reference</td>
                <td class="bordered center">Amount</td>
            </tr>
            <tr>
                <td colspan="2" class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
                <td class="bordered">&nbsp;</td>
            </tr>
        </tbody>
    </table>

    {{-- C. ACCOUNTABILITY FOR ACCOUNTABLE FORMS --}}
    <table class="bordered" style="font-size: 9pt;border-collapse: collapse;">
        <tbody>
            <tr>
                <td colspan="10" class="left">
                    <strong>C. ACCOUNTABILITY FOR ACCOUNTABLE FORMS</strong>
                </td>
            </tr>
            <tr>
                <td rowspan="3" class="bordered center" style="width: 10%;">Name of Forms & No.</td>
                <td colspan="3" class="bordered center" style="width: 30%;">Beginning Balance</td>
                <td colspan="3" class="bordered center" style="width: 30%;">Issued</td>
                <td colspan="3" class="bordered center" style="width: 30%;">Ending Balance</td>
            </tr>
            <tr>
                <td rowspan="2" class="bordered center" style="width: 6%;">Qty.</td>
                <td colspan="2" class="bordered" style="width: 24%;">Inclusive Serial No.</td>
                <td rowspan="2" class="bordered center" style="width: 6%;">Qty.</td>
                <td colspan="2" class="bordered" style="width: 24%;">Inclusive Serial No.</td>
                <td rowspan="2" class="bordered center" style="width: 6%;">Qty.</td>
                <td colspan="2" class="bordered" style="width: 24%;">Inclusive Serial No.</td>
            </tr>
            <tr>
                <td class="bordered center" style="width: 12%;">FROM</td>
                <td class="bordered center" style="width: 12%;">TO</td>
                <td class="bordered center" style="width: 12%;">FROM</td>
                <td class="bordered center" style="width: 12%;">TO</td>
                <td class="bordered center" style="width: 12%;">FROM</td>
                <td class="bordered center" style="width: 12%;">TO</td>
            </tr>
            @forelse ($accountableFormData as $item)
            <tr>
                <td class="bordered">{{ $item['form_name'] }}</td>
                <td class="bordered center">{{ $item['begin_qty'] }}</td>
                <td class="bordered center">{{ $item['begin_serial_from'] }}</td>
                <td class="bordered center">{{ $item['begin_serial_to'] }}</td>
                <td class="bordered center">{{ $item['issued_qty'] }}</td>
                <td class="bordered center">{{ $item['issued_serial_from'] }}</td>
                <td class="bordered center">{{ $item['issued_serial_to'] }}</td>
                <td class="bordered center">{{ $item['end_qty'] }}</td>
                <td class="bordered center">{{ $item['end_serial_from'] }}</td>
                <td class="bordered center">{{ $item['end_serial_to'] }}</td>
            </tr>
            @empty
            <tr>
                <td class="bordered">&nbsp;</td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
            </tr>
            @endforelse
            <tr>
                <td class="bordered">&nbsp;</td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
            </tr>
            <tr>
                <td class="bordered">&nbsp;</td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
                <td class="bordered center"></td>
            </tr>


        </tbody>
    </table>

     {{-- D. SUMMARY OF COLLECTIONS AND REMITTANCES/DEPOSITS --}}
     <table class="bordered" style="font-size: 9pt;border-collapse: collapse;">
        <tbody>
            <tr>
                <td colspan="7" class="left">
                    <strong>D. SUMMARY OF COLLECTIONS AND REMITTANCES/DEPOSITS</strong>
                </td>
            </tr>
            <tr>
                <td colspan="4">Beginning Balance</td>
                <td colspan="3">List of Checks:</td>
            </tr>
            <tr>
                <td colspan="4">Add Collections</td>
                <td class="bordered center" style="width: 10%">Check No.</td>
                <td class="bordered center" style="width: 15%">Payee</td>
                <td class="bordered center" style="width: 20%">Amount</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
                <td class="leftline rightline"></td>
                <td class="rightline"></td>
                <td class="right"></td>
            </tr>
            <tr>
                <td></td>
                <td>Cash:</td>
                <td class="underline right bold">P {{ number_format($grandTotal,2,'.',',') }}</td>
                <td></td>
                <td class="leftline rightline"></td>
                <td class="rightline"></td>
                <td class="right"></td>
            </tr>
            <tr>
                <td></td>
                <td>Checks:</td>
                <td class="underline right bold"></td>
                <td></td>
                <td class="leftline rightline"></td>
                <td class="rightline"></td>
                <td class="right"></td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
                <td class="underline leftline rightline"></td>
                <td class="underline rightline"></td>
                <td class="right"></td>
            </tr>
            <tr>
                <td colspan="4">Total</td>
                <td colspan="2"></td>
                <td class="bordered right"></td>
            </tr>
            <tr>
                <td colspan="7">Less: Remitance/Deposit to Cashier</td>
            </tr>
            <tr>
                <td colspan="2">Treasuer/Deposit Bank</td>
                <td class="underline right bold">P {{ number_format($grandTotal,2,'.',',') }}</td>
                <td colspan="4"></td>
            </tr>
            <tr>
                <td colspan="2">Balance</td>
                <td class="underline right"></td>
                <td></td>
                <td colspan="3" style="font-size:6pt">Note: Use additional sheet if necessary.</td>
            </tr>
            <tr>
                <td colspan="7">&nbsp;</td>
            </tr>
        </tbody>
     </table>
    <table style="border: 1px solid black; border-collapse: collapse; width:100%">
        <tr style="font-size:8pt;">
            <td colspan="2" style="width:50%" class="bold rightline">
                CERTIFICATION
            </td>
            <td colspan="2" class="bold">
                VERIFICATION AND ACKNOWLEDGEMENT
            </td>
        </tr>
        <tr style="font-size:8pt;">
            <td colspan="2" class="rightline">
                &nbsp;&nbsp;&nbsp;&nbsp;
                I hereby certify that the foregoing report of
                collections and deposits, and accountability
                for accountable forms is true and correct.
            </td>
            <td colspan="2">
                &nbsp;&nbsp;&nbsp;&nbsp;
                I hereby certify that the foregoing report of
                collections that been verified abd acknowledgement
                receipt of <u class="bold">P {{ number_format($grandTotal,2,'.',',') }}</u>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="rightline">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="center" style="font-size: 9">
                <strong>{{ $selectedData['pay_teller'] }}</strong><br>
                <span style="font-size:8pt">{{ 'Accountable Officer' }}</span>
            </td>
            <td class="center rightline">
                <span style="font-size:8pt">{{ $selectedData['pay_date'] }}</span>
            </td>
            <td class="center" style="font-size: 9">
                <strong>{{ $verifier_name }}</strong><br>
                <span style="font-size:8pt">{{ $verifier_designation }}</span>
            </td>
            <td class="center">
                <span style="font-size:8pt">{{ $selectedData['pay_date'] }}</span>
            </td>
        </tr>
    </table>

</body>

</html>
