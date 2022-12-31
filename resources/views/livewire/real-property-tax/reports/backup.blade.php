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
<div class="row">
<div class="col-2">&nbsp;&nbsp;&nbsp;&nbsp;</div>

<div class="col-8">
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
                        <select style="border-color:transparent;background-color:transparent; font-weight:bold;">
                            <option value="General">General</option>
                            <option value="Proper">Proper</option>
                            <option value="Other">Other</option>
                        </select>
                    </span>
                </td>
                <td colspan="2" style="width:50%" class="right">
                    <span style="font-size:10pt;">Date:</span>
                    <span style="font-size:10pt;padding-right:5pt;">
                        <input type="date" style="border-color:transparent;background-color:transparent; font-weight:bold;"/>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <span style="font-size:10pt;"><i>
                        Name of Accountable Officer:
                    </i></span>
                    <span style="font-size:10pt;"><strong>
                        ULYSSES E. DANSECO
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

            <tr>
                <td class="bordered">AF # 56</td>
                <td class="bordered center">1229000</td>
                <td class="bordered center">1229100</td>
                <td class="bordered right">
                    <img width="8px" src="{{ url('img/peso.png') }}"/>
                    <span><strong>1425,525.00</strong></span>
                </td>
            </tr>

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
                    <span style="font-size: 10;"><strong>1,425,525.00</strong></span>
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

            <tr>
                <td class="bordered">AF # 56</td>
                <td class="bordered center">25</td>
                <td class="bordered center">1234565</td>
                <td class="bordered center">1234565</td>
                <td class="bordered center">25</td>
                <td class="bordered center">1234565</td>
                <td class="bordered center">1234565</td>
                <td class="bordered center">25</td>
                <td class="bordered center">1234565</td>
                <td class="bordered center">1234565</td>
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
                <td class="underline right bold">P 124,245.00</td>
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
                <td class="underline right bold">P 123,123.00</td>
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
                receipt of <u class="bold">P 214,256.00</u>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="rightline">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td class="center" style="font-size: 9">
                <div class="row">
                    <div class="col-3">
                        <label for="fname">FULLNAME:</label>
                        <label for="fname">POSITION:</label>
                        <label for="fname">DATE:</label>
                    </div>
                    <div class="col-6">
                        <input type="text" id="fname" name="fname"><br>
                        <input type="text" id="fname" name="fname"><br>
                        <input type="text" id="fname" name="fname"><br>
                    </div>
                </div>
            </td>
            <td class="center rightline">
            </td>
            <td style="font-size: 9">
                <div class="row">
                    <div class="col-3">
                        <label for="fname">FULLNAME:</label>
                        <label for="fname">POSITION:</label>
                        <label for="fname">DATE:</label>
                    </div>
                    <div class="col-6">
                        <input type="text" id="fname" name="fname"><br>
                        <input type="text" id="fname" name="fname"><br>
                        <input type="text" id="fname" name="fname"><br>
                    </div>
                </div>
            </td>
        </tr>
    </table>

</div>

<div class="col-2">&nbsp;&nbsp;&nbsp;&nbsp;</div>
</div>
