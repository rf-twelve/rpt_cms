<div>
    <table class="table border-0" style="margin-top:10px;margin-bottom:2px;">
        <tbody>
            <tr>
                <td class="border-0 pl-0" width="70%">
                    <h3 style="margin:0;padding:0">
                        PROVINCE : <span style="text-decoration: underline">QUEZON</span>
                    </h3>
                    <h3 style="margin:0;padding:0">
                        MUNICIPALITY : <span style="text-decoration: underline">LOPEZ</span>
                    </h3>
                </td>
                <td class="border-0 pl-0" width="70%">
                </td>
                <td class="border-0 pl-0" width="70%">
                    <h3 style="margin:0;padding:0">
                        INDEX No. : <span style="text-decoration: underline">015</span>
                    </h3>
                    <h3 style="margin:0;padding:0">
                        INDEX No. : <span style="text-decoration: underline">16</span>
                    </h3>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-12">
        {{-- {{$delinquent_year}} --}}
        {{-- @if(count($rptAccounts) > 0) --}}
        <table class="table table-bordered">
        <thead>
            <tr>
            <th style="width: 10px">#</th>
            <th class="text-center">Barangay</th>
            <th class="text-center">Code</th>
            <th class="text-center">Land</th>
            <th class="text-center">Building</th>
            <th class="text-center">Machineries</th>
            <th class="text-center">Total Assessed Value</th>
            <th class="text-center">Total Tax Collectibles(2%)</th>
            <th class="text-center">Previous Assessed Value</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1 ?>
            @forelse ($rptAccounts as $item)
            <tr>
                <td>{{$num++}}.</td>
                <td class="text-left">{{$item['brgy']}}</td>
                <td class="text-center">{{$item['code']}}</td>
                <td class="text-right">{{number_format($item['land'], 2, '.', ',')}}</td>
                <td class="text-right">{{number_format($item['build'], 2, '.', ',')}}</td>
                <td class="text-right">{{number_format($item['machine'], 2, '.', ',')}}</td>
                <td class="text-right">{{number_format($item['av'], 2, '.', ',')}}</td>
                <td class="text-right">{{number_format($item['collectible'], 2, '.', ',')}}</td>
                <td class="text-right">{{number_format($item['av_prev'], 2, '.', ',')}}</td>
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
                <td></td>
                <td></td>
            </tr>
            @endforelse
            @if (!is_null($grandTotal) || !empty($grandTotal))
            <tr>
                <td></td>
                <td class="text-center"><strong><i>Total</i></strong></td>
                <td></td>
                <td class="text-right"><strong></strong>{{number_format($grandTotal['total_land'], 2, '.', ',')}}</strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_build'], 2, '.', ',')}}</strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_machine'], 2, '.', ',')}}</strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_av'], 2, '.', ',')}}</strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_collectible'], 2, '.', ',')}}</strong></td>
                <td class="text-right"><strong>{{number_format($grandTotal['total_av_prev'], 2, '.', ',')}}</strong></td>
            </tr>
            @endif
        </tbody>
        </table>
        {{-- @endif --}}
    </div>
    </div>
    <table class="table border-0" style="margin-top:20px;margin-bottom:2px;">
        <tbody>
            <tr>
                <td class="border-0 pl-0" width="70%">
                    <h3 style="margin:0;padding:0">
                        LUCILA N. VILLASEÑOR
                    </h3>
                    <p style="margin:0;padding:0">
                        Administrative Aide II
                    </p>
                </td>
                <td class="border-0 pl-0" width="70%">
                </td>
                <td class="border-0 pl-0" width="70%">
                    <h3 style="margin:0;padding:0">
                        PELAGIA D. JAVIER
                    </h3>
                    <p style="margin:0;padding:0">
                        Municipal Assessor
                    </p>
                </td>
            </tr>
        </tbody>
    </table>
</div>
