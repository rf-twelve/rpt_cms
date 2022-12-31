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
                            SUMMARY OF RPT COLLECTIBLES PER BARANGAY
                        </strong>
                    </span><br>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="bordered" style="font-size: 9pt;border-collapse: collapse;">
        <thead>
            <tr>
                <th class="bordered center" style="width:4%">NO.</th>
                <th class="bordered center" style="width:16%">BARANGAY</th>
                <th class="bordered center" style="width:16%">NEW ASSESSED VALUE</th>
                <th class="bordered center" style="width:16%">OLD ASSESSED VALUE</th>
                <th class="bordered center" style="width:16%">OLD AV 1%</th>
                <th class="bordered center" style="width:16%">NEW AV 70%</th>
                <th class="bordered center" style="width:16%">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($assessment_roll_data as $value)
                <tr class="even_row">
                    <td class="bordered right">{{ $value['count'] }}</td>
                    <td class="bordered left"><i>{{ $value['barangay'] }}</i></td>
                    <td class="bordered right">{{ number_format($value['new_av'],2,'.',',') }}</td>
                    <td class="bordered right">{{ number_format($value['old_av'],2,'.',',') }}</td>
                    <td class="bordered right">{{ number_format($value['old_av_1'],2,'.',',') }}</td>
                    <td class="bordered right">{{ number_format($value['new_av_70'],2,'.',',') }}</td>
                    <td class="bordered right">{{ number_format($value['total'],2,'.',',') }}</td>
                </tr>
            @empty

            @endforelse


            <tr class="even_row">
                <td colspan="2" class="bordered" style="text-align: center"><i><strong>Grand Total</strong></i></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['new_av'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['old_av'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['old_av_1'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['new_av_70'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($assessment_roll_total['total'],2,'.',',') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <table style="width:100%">
        <tr style="font-size:8pt;">
            <td style="width:50%">
                <span><i>Prepared by:</i></span>
            </td>
            <td style="width:50%">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center; padding-top: 1.5em;margin-left: 4em; font-size:10pt">
                <strong>
                    <u>{{ $signatory1 }}</u>
                </strong><br>
                <span style="font-size:8pt">{{ $designation1 }}</span><br><br>
            </td>
            <td style="width:50%">&nbsp;</td>
        </tr>
    </table>

</body>

</html>
