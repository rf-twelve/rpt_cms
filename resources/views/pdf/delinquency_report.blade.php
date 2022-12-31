<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            /* margin: 0.50in; */
            margin-top: 0.25in;
            margin-left: 0.5in;
            margin-right: 0.5in;
            margin-bottom: 0.25in;
            size: 8.5in 11in;
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
            p {
                margin: 2px;
            }
        }

        table {
            width: 100%;
        }

        td {
            /* padding:4px; */
            word-wrap: break-word;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        .bordered {
            border: 1px solid black;
            border-collapse: collapse;
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

        .pt-4 {
            padding-top: 4px;
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
                    <span style="font-size:8pt;">{{ $start_year }} - {{ $end_year }}</span><br><br>
                    <span style="font-size:11pt;">
                        <strong>
                            SUMMARY OF REAL PROPERTY TAX DELINQUENCIES PER BARANGAY
                        </strong>
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="bordered" style="font-size: 9pt;border-collapse: collapse;">
        <thead>
            <tr>
                <th class="bordered" style="width:20%">BARANGAY</th>
                <th class="bordered" style="width:15%">Sum of ASSESED VALUE</th>
                <th class="bordered" style="width:15%">Sum of BASIC</th>
                <th class="bordered" style="width:15%">Sum of SEF</th>
                <th class="bordered" style="width:15%">Sum of PENALTY</th>
                <th class="bordered" style="width:20%">Sum of TOTAL DELINQUENCY</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($delinquencies as $item)
                <tr class="even_row">
                    <td class="bordered" style="text-align: left"><i>{{ $item['brgy'] }}</i></td>
                    <td class="bordered" style="text-align: right">{{ number_format($item['av_sum'],2,'.',',') }}</td>
                    <td class="bordered" style="text-align: right">{{ number_format($item['basic_sum'],2,'.',',') }}</td>
                    <td class="bordered" style="text-align: right">{{ number_format($item['sef_sum'],2,'.',',') }}</td>
                    <td class="bordered" style="text-align: right">{{ number_format($item['penalty_sum'],2,'.',',') }}</td>
                    <td class="bordered" style="text-align: right">{{ number_format($item['delinquency_sum'],2,'.',',') }}</td>
                </tr>
            @empty

            @endforelse
            <tr class="even_row">
                <td class="bordered" style="text-align: center"><i><strong>Grand Total</strong></i></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($total['av'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($total['basic'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($total['sef'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($total['penalty'],2,'.',',') }}</strong></td>
                <td class="bordered"style="text-align: right"><strong>{{ number_format($total['delinquency'],2,'.',',') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <table style="border-collapse: collapse; width:100%">
        <tr>
            <td style="width:50%"></td>
            <td
                style="text-align:center; padding-top:50px;font-size:10pt">
                <strong>
                    <u>{{ $signatory1 }}</u>
                </strong><br>
                <span style="font-size:8pt">{{ $designation1 }}</span><br><br>
            </td>
        </tr>
    </table>

</body>

</html>
