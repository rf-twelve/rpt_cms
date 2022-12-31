<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            padding:4px;
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
        .spacing-1 {
            letter-spacing: 1px;
        }
        .spacing-2 {
            letter-spacing: 2px;
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
    <table style="font-size: 8px">
        <tbody>
            <tr>
                <td style="width:100%; line-height:190%" class="center">
                    <img width="50" src="{{ url('/img/lgulopezquezon.png') }}" /><br>
                    <span style="font-size:8pt;">Republic of the Philippines</span><br>
                    <span style="font-size:8pt;">Province of QUEZON</span><br>
                    <span style="font-size:8pt;">Municipality of LOPEZ</span><br>
                    <span class="spacing-1 bold" style="font-size:9pt;">
                        <strong>OFFICE OF THE MUNICIPAL TREASURER</strong>
                    </span><br>
                    <span style="font-size:8pt;">As of {{ $date }}</span><br>
                    <span style="font-size:11pt;">
                        <strong>
                            ASSESSMENT ROLL SUMMARY
                        </strong>
                    </span><br>
                    <span style="font-size:7pt;">Taxable Properties</span><br>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; font-size: 9pt;margin-bottom: 2pt;">
        <tr>
            <td style="width: 10%">PROVINCE:</td>
            <td class="underline" style="width: 10%"><strong>QUEZON</strong></td>
            <td style="width: 60%"></td>
            <td style="width: 10%">Index No.</td>
            <td class="underline" style="width: 10%"><strong>015</strong></td>
        </tr>
        <tr>
            <td style="width: 10%">MUNICIPALITY:</td>
            <td class="underline" style="width: 10%"><strong>LOPEZ</strong></td>
            <td style="width: 60%"></td>
            <td style="width: 10%">Index No.</td>
            <td class="underline" style="width: 10%"><strong>16</strong></td>
        </tr>
    </table>

    <table class="bordered" style="font-size: 9pt;border-collapse: collapse;">
        <thead>
            <tr>
                <th class="bordered" style="width:16%">BARANGAY</th>
                <th class="bordered" style="width:6%">Code</th>
                <th class="bordered" style="width:13%">Land</th>
                <th class="bordered" style="width:13%">Building</th>
                <th class="bordered" style="width:13%">Machineries</th>
                <th class="bordered" style="width:13%">Total Assessed Value</th>
                <th class="bordered" style="width:13%">Total Tax Collectibles(2%)</th>
                <th class="bordered" style="width:13%">Previous Assessed Value</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assessment_roll_data as $value)
                <tr class="even_row">
                    <td class="bordered left"><i>{{ $value['barangay'] }}</i></td>
                    <td class="bordered center">{{ $value['code'] }}</td>
                    <td class="bordered right">{{ number_format($value['land'],2,'.',',') }}</td>
                    <td class="bordered right">{{ number_format($value['building'],2,'.',',') }}</td>
                    <td class="bordered right">{{ number_format($value['machineries'],2,'.',',') }}</td>
                    <td class="bordered right">{{ number_format($value['total_av'],2,'.',',') }}</td>
                    <td class="bordered right">{{ number_format($value['total_collectibles'],2,'.',',') }}</td>
                    <td class="bordered right">{{ number_format($value['total_av_prev'],2,'.',',') }}</td>
                </tr>
            @empty

            @endforelse


            <tr class="even_row">
                <td class="bordered" style="text-align: center"><i><strong>Grand Total</strong></i></td>
                <td class="bordered"style="text-align: right"><strong></strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['land'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['building'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['machineries'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['total_av'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['total_collectibles'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['total_av_prev'],2,'.',',') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <table style="border: 1px solid black; border-collapse: collapse; width:100%">
        <tr style="font-size:8pt;">
            <td style="border-right: 1px solid black; border-collapse: collapse; width:50%">
                <span><i>Prepared by:</i></span>
            </td>
            <td>
                <span><i>Noted by:</i></span>
            </td>
        </tr>
        <tr>
            <td
                style="border-right: 1px solid black; border-collapse: collapse; text-align:center; padding-top: 1.5em;margin-left: 4em; font-size:10pt">
                <strong>
                    <u>{{ $signatory1 }}</u>
                </strong><br>
                <span style="font-size:8pt">{{ $designation1 }}</span><br><br>
            </td>
            <td
                style="border-right: 1px solid black; border-collapse: collapse; text-align:center; padding-top: 1.5em;margin-left: 4em; font-size:10pt">
                <strong>
                    <u>{{ $signatory2 }}</u>
                </strong><br>
                <span style="font-size:8pt">{{ $designation2 }}</span><br><br>
            </td>
        </tr>
    </table>

</body>

</html>
