<div class="col-12">
    <div class="card">
        <div class="card-header bg-primary p-1">
            <h3 class="card-title">
                <i class="nav-icon fas fa-info-circle"></i>
                <i>TAX DUE</i>
            </h3>
            <div class="card-header ui-sortable-handle py-0">
                <div class="card-tools">
                    <div class="custom-control custom-switch custom-switch-off-white custom-switch-on-warning">
                    <input wire:click="payOption()" wire:model="pay_option" type="checkbox"
                    class="custom-control-input" id="cSwitch1">
                    <label class="custom-control-label" for="cSwitch1">Payment Option</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive table-sm p-0">
            {{-- @if (count($payment_record)) --}}
            <table class="table table-head-fixed table-bordered table-head-fixed text-nowrap">
                <tbody>
                    <tr class="bg-secondary">
                        <td class="text-center" rowspan="2"></td>
                        <td class="text-center" rowspan="2">BRACKET</td>
                        <td class="text-center" rowspan="2">YEAR</td>
                        <td class="text-center" colspan="3">TAX DUE</td>
                        <td class="text-center" colspan="3">PENALTY</td>
                        <td class="text-center" style="width:170px" rowspan="2">TOTAL AMOUNT DUE </td>
                        {{-- <td class="text-center"></td> --}}
                    </tr>
                    <tr class="bg-secondary">
                        <td class="text-center">BASIC</td>
                        <td class="text-center">SEF</td>
                        <td class="text-center">TOTAL</td>
                        <td class="text-center">BASIC</td>
                        <td class="text-center">SEF</td>
                        <td class="text-center">TOTAL</td>
                        {{-- <td class="text-center"></td> --}}
                    </tr>
                    @if ($payment_dues)
                    @forelse ($payment_dues as $key => $item)
                    <tr class="{{($item['status'] == 2)  ? '':'bg-gray'}}" >
                        @if ($item['status'] == 2)
                            <td style="width:4px;" class="bg-white text-center p-2">
                                <div class="custom-control custom-checkbox">
                                    <input onclick="confirm('Do you want to remove this bracket?') || event.stopImmediatePropagation()"
                                    wire:click="uncheckList({{$item['count']}})"
                                    class="custom-control-input" type="checkbox" id="checkbox{{$item['count']}}"
                                    {{($item['status'] == 2 ? 'checked' : '')}}>
                                    <label for="checkbox{{$item['count']}}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td class="bg-info" style="width:170px">
                                {{ $item['label']}}
                            </td>
                            <td class="text-center">{{$item['year_no']}}</td>
                            <td>
                                @if (strpos($item['td_basic'], ',') !== false)
                                {{'P '.$item['td_basic']}}
                                @else
                                {{'P '.number_format($item['td_basic'], 2, '.', ',')}}
                                @endif
                            </td>
                            <td>
                                @if (strpos($item['td_sef'], ',') !== false)
                                {{'P '.$item['td_sef']}}
                                @else
                                {{'P '.number_format($item['td_sef'], 2, '.', ',')}}
                                @endif
                            </td>
                            <td>
                                @if (strpos($item['td_total'], ',') !== false)
                                {{'P '.$item['td_total']}}
                                @else
                                {{'P '.number_format($item['td_total'], 2, '.', ',')}}
                                @endif
                            </td>
                            <td>
                                @if (strpos($item['pen_basic'], ',') !== false)
                                {{'P '.$item['pen_basic']}}
                                @else
                                {{'P '.number_format($item['pen_basic'], 2, '.', ',')}}
                                @endif
                            </td>
                            <td>
                                @if (strpos($item['pen_sef'], ',') !== false)
                                {{'P '.$item['pen_sef']}}
                                @else
                                {{'P '.number_format($item['pen_sef'], 2, '.', ',')}}
                                @endif
                            </td>
                            <td>
                                @if (strpos($item['pen_total'], ',') !== false)
                                {{'P '.$item['pen_total']}}
                                @else
                                {{'P '.number_format($item['pen_total'], 2, '.', ',')}}
                                @endif
                            </td>
                            <td>
                                @if (strpos($item['amount_due'], ',') !== false)
                                {{'P '.$item['amount_due']}}
                                @else
                                {{'P '.number_format($item['amount_due'], 2, '.', ',')}}
                                @endif
                            </td>
                        @else
                            <td style="width:4px;" class="bg-white text-center p-2">
                                <div class="custom-control custom-checkbox">
                                    <input onclick="confirm('Do you want to add this bracket?') || event.stopImmediatePropagation()"
                                    wire:click="checkList({{$item['count']}})"
                                    class="custom-control-input" type="checkbox" id="checkbox{{$item['count']}}">
                                    <label for="checkbox{{$item['count']}}" class="custom-control-label"></label>
                                </div>
                            </td>
                            <td class="bg-gray" style="width:170px">
                                {{ $item['label']}}
                            </td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        @endif
                    </tr>
                    @empty
                    @endforelse
                    @endif
                    <tr>
                        <td colspan="9" class="bg-primary" style="width:170px">
                            TOTAL
                        </td>
                        <td>
                            @if (strpos($amount_due, ',') !== false)
                            {{'P '.$amount_due}}
                            @else
                            {{'P '.number_format($amount_due, 2, '.', ',')}}
                            @endif</td>
                    </tr>
                    {{-- <tr>
                        <td class="bg-indigo" style="width:170px">
                            GRAND-TOTAL
                        </td>
                        <td colspan="2"></td>
                        <td class="bg-secondary" colspan="6"></td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <div class="text-right">
        <button wire:click.prevent="open_payment()" class="btn btn-primary" {{$payment_button}}>
            <i class="fas fa-money-bill-wave"></i> Payment
        </button>
    </div>
</div>
