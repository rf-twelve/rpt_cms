<div class="row">
    <div class="col-12">
    {{-- {{$delinquent_year}} --}}
    {{-- @if(count($rptAccounts) > 0) --}}
    <table class="table table-bordered">
    <thead>
        <tr>
        <th style="width: 10px">No.</th>
        <th class="text-center">CODE</th>
        <th class="text-center">BARANGAY</th>
        <th class="text-center" style="width:110px">NEW ASSESSED VALUE</th>
        <th class="text-center" style="width:110px">OLD ASSESSED VALUE</th>
        <th class="text-center" style="width:110px">OLD AV 1%</th>
        <th class="text-center" style="width:110px">NEW AV 70% (NEWAV-OLDAV)</th>
        <th class="text-center" style="width:110px">TOTAL</th>
        </tr>
    </thead>
    <tbody>
        <?php $num = 1 ?>
        @forelse ($records as $item)
        <tr>
            <td>{{$num++}}.</td>
            <td class="text-left">{{$item['code']}}</td>
            <td class="text-left">{{$item['brgy']}}</td>
            <td class="text-right">{{number_format($item['new_av'], 2, '.', ',')}}</td>
            <td class="text-right">{{number_format($item['old_av'], 2, '.', ',')}}</td>
            <td class="text-right">{{number_format($item['old_av_1'], 2, '.', ',')}}</td>
            <td class="text-right">{{number_format($item['new_av_70'], 2, '.', ',')}}</td>
            <td class="text-right">{{number_format($item['total'], 2, '.', ',')}}</td>
        </tr>
        @empty
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endforelse
        <tr>
            <td class="text-center" colspan="3"><strong><i>Total</i></strong></td>
            <td class="text-right"><strong>{{number_format(floor(($grandTotal['grandTotal_new_av']*100))/100, 2, '.', ',')}}</strong></td>
            <td class="text-right"><strong>{{number_format(floor(($grandTotal['grandTotal_old_av']*100))/100, 2, '.', ',')}}</strong></td>
            <td class="text-right"><strong>{{number_format(floor(($grandTotal['grandTotal_old_av_1']*100))/100, 2, '.', ',')}}</strong></td>
            <td class="text-right"><strong>{{number_format(floor(($grandTotal['grandTotal_new_av_70']*100))/100, 2, '.', ',')}}</strong></td>
            <td class="text-right"><strong>{{number_format(floor(($grandTotal['grandTotal_total']*100))/100, 2, '.', ',')}}</strong></td>

        </tr>
    </tbody>
    </table>
    {{-- @endif --}}
</div>
