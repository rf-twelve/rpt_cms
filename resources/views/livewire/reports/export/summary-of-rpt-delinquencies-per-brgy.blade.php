<div class="card card-primary">
    <div class="pt-4 text-center">
        <img src="{{ asset('\img\lgulopezquezon.png') }}" alt="logo" height="50">
    </div>

    <div class="text-center">
        Republic of the Philippines<br>
        Province of QUEZON<br>
        Municipality of LOPEZ<br>
        <strong>OFFICE OF THE MUNICIPAL TREASURER</strong><br>
        <strong>{{$from}} - {{$to}} </strong><br>
        {{-- as of {{ $invoice->getDate() }}<br> --}}
        as of {{ $as_of }}<br>

    </div>
    <div class="text-center">
        <h6>SUMMARY OF REAL PROPERTY TAX DELINQUENCIES PER BARANGAY</h6>
    </div>
    <div class="text-center">
        <table class="table table-bordered">
            <thead>
                <tr>
                <th style="width: 10px">#</th>
                <th class="text-center">BARANGAY</th>
                <th class="text-center" style="width:110px">Sum of ASSESSED VALUE</th>
                <th class="text-center" style="width:110px">Sum of BASIC</th>
                <th class="text-center" style="width:110px">Sum of SEF</th>
                <th class="text-center" style="width:110px">Sum of PENALTY</th>
                <th class="text-center" style="width:110px">Sum of TOTAL DELINQUENCY</th>
                </tr>
            </thead>
            <tbody>
                <?php $num = 1 ?>
                @forelse ($rptAccounts as $item)
                <tr>
                    <td>{{$num++}}.</td>
                    <td class="text-left">{{$item['brgy']}}</td>
                    <td class="text-right">{{number_format($item['av'], 2, '.', ',')}}</td>
                    <td class="text-right">{{number_format($item['td_basic'], 2, '.', ',')}}</td>
                    <td class="text-right">{{number_format($item['td_sef'], 2, '.', ',')}}</td>
                    <td class="text-right">{{number_format($item['penalty_basic'], 2, '.', ',')}}</td>
                    <td class="text-right">{{number_format($item['total'], 2, '.', ',')}}</td>
                </tr>
                @empty

                @endforelse
                @if ($grandTotal)
                <tr>
                    <td></td>
                    <td class="text-center"><strong><i>Grand Total</i></strong></td>
                    <td class="text-right"><strong>{{number_format($grandTotal['total_av'], 2, '.', ',')}}</strong></td>
                    <td class="text-right"><strong>{{number_format($grandTotal['total_basic'], 2, '.', ',')}}</strong></td>
                    <td class="text-right"><strong>{{number_format($grandTotal['total_sef'], 2, '.', ',')}}</strong></td>
                    <td class="text-right"><strong>{{number_format($grandTotal['total_penalty'], 2, '.', ',')}}</strong></td>
                    <td class="text-right"><strong>{{number_format($grandTotal['total_taxDue'], 2, '.', ',')}}</strong></td>
                </tr>
                @endif

            <button type="button" wire:click="print">print</button>

            </tbody>
        </table>
    </div>
    <p class="mt-5 ml-4">
        <strong>HERMES A. ARGANTE</strong><br>
        &nbsp;&nbsp;&nbsp;Municipal Treasurer<br>
    </p>

</div>
