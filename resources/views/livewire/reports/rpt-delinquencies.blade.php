<div>
    {{-- {{$delinquent_year}} --}}
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
            if(count($rptAccounts) > 0){
            <tr>
                <td></td>
                <td class="text-center"><strong><i>Grand Total</i></strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_av'], 2, '.', ',')}}</strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_basic'], 2, '.', ',')}}</strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_sef'], 2, '.', ',')}}</strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_penalty'], 2, '.', ',')}}</strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_taxDue'], 2, '.', ',')}}</strong></td>
            </tr>
            }


        </tbody>
    </table>
</div>
